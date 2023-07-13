<?php

use Bitrix\Main;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Errorable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\MeasureRatioTable;
use Redsign\KomPred;
use Redsign\KomPred\Offer;
use Redsign\KomPred\FlashServiceInterface;
use Redsign\KomPred\FlashService;
use Redsign\KomPred\ParamUtils;
use Redsign\KomPred\ErrorableImplementation;
use Redsign\KomPred\Offer\OfferStructure;
use Redsign\KomPred\Product\ProductCollection;
use Redsign\KomPred\Shortener\ShortenerService;
use Redsign\KomPred\Shortener\ShortLinkCollection;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

if (!\Bitrix\Main\Loader::includeModule('redsign.kompred'))
{
    \ShowError(Loc::getMessage('RS_KP_KOS_MODULE_NOT_INSTALLED'));
    return;
}

class RedsignKompredOfferShow extends \CBitrixComponent implements
    Errorable,
    Controllerable
{
    use ErrorableImplementation;

    public const ERROR_MODULE_NOT_INSTALLED = 10000;
    public const ERROR_NO_ACCESS = 10001;
    public const ERROR_OFFER_NOT_FOUND = 10003;

    /** @var CMain $application */
    protected $application;

    /** @var Offer\OfferRepository $offerRepository */
    protected $offerRepository;

    /** @var FlashServiceInterface $flashService */
    protected $flashService;

    /** @var ParamUtils $pUtils */
    protected $pUtils;

    /** @var ?Offer\Offer $offer */
    protected $offer;

    /** @var CurrentUser $user */
    protected $user;

    /** @var ShortenerService $shortener */
    protected $shortener;

    /** @var array $measuresData */
    protected $measuresData;

    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        /** @var CMain $APPLICATION */
        global $APPLICATION;

        parent::__construct($component);
        $this->errorCollection = new Main\ErrorCollection();
        $this->user = CurrentUser::get();
        $this->application = $APPLICATION;
        $this->offerRepository = ServiceLocator::getInstance()->get(KomPred\ServiceProvider::OFFER_REPOSITORY);
        $this->flashService = ServiceLocator::getInstance()->get(KomPred\ServiceProvider::FLASH_SERVICE);
        $this->pUtils = ServiceLocator::getInstance()->get(KomPred\ServiceProvider::PARAM_UTILS);
        $this->shortener = ServiceLocator::getInstance()->get(KomPred\ServiceProvider::SHORTENER_SERVICE);
    }

    public function configureActions(): array
    {
        return [];
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        $this->pUtils->tryParseString($arParams['DOWNLOAD_URL'], $this->application->GetCurPage() . '?CODE=#CODE#&ACTION=download');
        $this->pUtils->tryParseString($arParams['EDIT_URL'], $this->application->GetCurPage() . '?ID=#ID#&ACTION=edit');

        return $arParams;
    }

    public function executeComponent(): void
    {
        if (
            $this->checkModules() &&
            $this->checkPermission() &&
            $this->loadOffer()
        )
        {
            $this->refresh();
            $this->formatResult();
        }

        $this->formatMessages();
        $this->formatResultErrors();

        $this->includeComponentTemplate();
    }

    public function fillMeasures(array &$arResult): void
    {
        if (!Loader::includeModule('catalog') || !isset($arResult['OFFER']['PRODUCTS']))
            return;

        $defaultMeasure = $this->getDefaultMeasure();

        if (!$this->measuresData)
        {
            $this->loadMeasuresData();
        }

        $measureRatios = [];

        if ($this->offer)
            $measureRatios = MeasureRatioTable::getCurrentRatio($this->offer->getProducts()->getProductIdList());

        foreach ($arResult['OFFER']['PRODUCTS'] as $i => ['PRODUCT_ID' => $pId, 'MEASURE' => $mId])
        {
            $arResult['OFFER']['PRODUCTS'][$i]['RATIO'] = $measureRatios[$pId] ?? 1;

            if ($this->measuresData[$mId])
            {
                $arResult['OFFER']['PRODUCTS'][$i]['MEASURE_NAME'] = $this->measuresData[$mId]['TITLE'];
            }
            elseif ($defaultMeasure)
            {
                $arResult['OFFER']['PRODUCTS'][$i]['MEASURE_NAME'] = $defaultMeasure['TITLE'];
            }
        }
    }

    public function formatPrices(array &$arResult): void
    {
        if (!Loader::includeModule('currency') || !isset($arResult['OFFER']['PRODUCTS']))
            return;

        /** @var string */
        $siteId = $this->offer ? $this->offer->getSiteId() : '';
        $siteCurrency = \Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency($siteId);

        $arResult['OFFER']['TOTAL_PRICE_FORMATTED'] = \CCurrencyLang::CurrencyFormat(
            $arResult['OFFER']['TOTAL_PRICE'],
            $siteCurrency
        );

        foreach ($arResult['OFFER']['PRODUCTS'] as &$productData)
        {
            $productData['PRICE_FORMATTED'] = \CCurrencyLang::CurrencyFormat(
                $productData['PRICE'],
                $productData['CURRENCY']
            );

            $productData['SUM_PRICE'] = $productData['PRICE'] * $productData['QUANTITY'];
            $productData['SUM_PRICE_FORMATTED'] = \CCurrencyLang::CurrencyFormat(
                $productData['SUM_PRICE'],
                $productData['CURRENCY']
            );
        }
    }

    protected function listKeysSignedParameters(): array
    {
        return [
            'ID',
            'CODE',
            'DOWNLOAD_URL',
            'EDIT_URL'
        ];
    }

    protected function checkModules(): bool
    {
        if (!Loader::includeModule('redsign.kompred'))
        {
            $this->errorCollection[] = new Main\Error(
                Loc::getMessage('RS_KP_KOS_MODULE_NOT_INSTALLED') ?: 'MODULE_NOT_INSTALLED',
                self::ERROR_MODULE_NOT_INSTALLED
            );

            return false;
        }

        return true;
    }

    protected function checkPermission(): bool
    {
        return true;
    }

    protected function loadOffer(): bool
    {
        if (is_null($this->offer))
        {
            if ($this->arParams['ID'])
            {
                $this->offer = $this->offerRepository->getById($this->arParams['ID']);
            }
            elseif ($this->arParams['CODE'])
            {
                $this->offer = $this->offerRepository->getByCode($this->arParams['CODE']);
            }

            if (!$this->offer)
            {
                $this->errorCollection[] = new Main\Error(
                    Loc::getMessage('RS_KP_KOS_OFFER_NOT_FOUND') ?: 'OFFER_NOT_FOUND',
                    self::ERROR_OFFER_NOT_FOUND
                );

                return false;
            }

            $this->offer->fillStrucutre();
            $this->offer->fillShortLinks();
        }

        return $this->offer !== null;
    }

    protected function refresh(): void
    {
        if (!$this->offer)
            return;

        /** @var KomPred\RefreshService $refreshService */
        $refreshService = ServiceLocator::getInstance()->get((KomPred\ServiceProvider::REFRESH_SERVICE));
        $refreshService->refresh($this->offer);
    }

    protected function formatResult(): void
    {
        if (!$this->offer)
            return;

        $this->arResult['OFFER'] = $this->offer->toArray();

        $this->arResult['OFFER']['DOWNLOAD_URL'] = $this->offer->getPath($this->arParams['DOWNLOAD_URL']);
        $this->arResult['OFFER']['EDIT_URL'] = $this->offer->getPath($this->arParams['EDIT_URL']);
        $this->arResult['OFFER']['DELETE_URL'] = $this->offer->getPath($this->arParams['EDIT_URL'], [
            'del' => 'Y',
            'sessid' => \bitrix_sessid()
        ]);

        $this->arResult['OFFER']['DOWNLOAD_URL_SHORT'] = null;

        /** @var ShortLinkCollection|null */
        $shortLinks = $this->offer->getShortLinks();
        if ($shortLinks)
        {
            foreach ($this->offer->getShortLinks() as $shortLink)
            {
                if ($shortLink->getFullUri() === $this->arResult['OFFER']['DOWNLOAD_URL'])
                {
                    $this->arResult['OFFER']['DOWNLOAD_URL_SHORT'] = $shortLink->getShortUri();
                    break;
                }
            }
        }

        /** @var OfferStructure|null */
        $offerStructure = $this->offer->getStrucutre();
        $this->arResult['STRUCTURE'] = $offerStructure ? $offerStructure->getStructure() : [];
    }

    protected function formatMessages(): void
    {
        $this->arResult['MESSAGES'] = [];
        $this->arResult['MESSAGES']['SUCCESS'] = $this->flashService->get(FlashService::TYPE_SUCCESS);
        $this->arResult['MESSAGES']['ERROR'] = $this->flashService->get(FlashService::TYPE_ERROR);
    }

    protected function formatResultErrors(): void
    {
        $this->arResult['ERRORS'] = [];
        foreach ($this->errorCollection as $error)
        {
            $this->arResult['ERRORS'][$error->getCode()] = $error->getMessage();
        }
    }

    protected function getDefaultMeasure(): ?array
    {
        static $measureData = null;

        if (is_null($measureData))
        {
            $defaultMeasure = \CCatalogMeasure::getDefaultMeasure(true, true);
            $measureData = [
                'ID' => $defaultMeasure['ID'],
                'TITLE' => $defaultMeasure['SYMBOL_RUS']
            ];
        }

        return $measureData;
    }

    protected function loadMeasuresData(): void
    {
        if (!$this->offer)
            return;

        /** @var ProductCollection|null */
        $products = $this->offer->getProducts();
        if (!$products)
            return;

        $measureIds = $products->getMeasureList();
        if ($measureIds)
        {
            $measureIterator = \CCatalogMeasure::getList(
                array(),
                array('@ID' => array_unique($measureIds)),
                false,
                false,
                array('ID', 'SYMBOL_RUS')
            );

            while ($measure = $measureIterator->GetNext())
            {
                $this->measuresData[$measure['ID']] = [
                    'ID' => $measure['ID'],
                    'TITLE' => $measure['SYMBOL_RUS']
                ];
            }
        }
    }
}
