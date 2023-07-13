<?php

use Bitrix\Main;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Errorable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Web\Uri;
use Redsign\KomPred\ErrorableImplementation;
use Redsign\KomPred\Offer\OfferCollection;
use Redsign\KomPred\Offer\OfferRepository;
use Redsign\KomPred\FlashService;
use Redsign\KomPred\ParamUtils;
use Redsign\KomPred\ServiceProvider;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

if (!\Bitrix\Main\Loader::includeModule('redsign.kompred'))
{
    \ShowError(Loc::getMessage('RS_KP_KOL_MODULE_NOT_INSTALLED'));
    return;
}

class RedsignKompredOfferList extends \CBitrixComponent implements
    Errorable
{
    use ErrorableImplementation;

    public const ERROR_MODULE_NOT_INSTALLED = 10000;
    public const ERROR_NO_ACCESS = 10001;

    public const SEARCH_QUERY_VARIABLE = 's';

    /** @var CMain $application */
    protected $application;

    /** @var CurrentUser $user */
    protected $user;

    /** @var OfferRepository $offerRepository */
    protected $offerRepository;

    /** @var FlashService $flashService */
    protected $flashService;

    /** @var PageNavigation $pageNav */
    protected $pageNav;

    /** @var ParamUtils $pUtils */
    protected $pUtils;

    /** @var array $filter */
    protected $filter;

    /** @var string $searchQuery */
    protected $searchQuery;

    /** @var ?OfferCollection $offers */
    protected $offers;

    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        /** @var CMain $APPLICATION */
        global $APPLICATION;

        parent::__construct($component);

        $this->errorCollection = new Main\ErrorCollection();
        $this->application = $APPLICATION;
        $this->user = CurrentUser::get();
        $this->offerRepository = ServiceLocator::getInstance()->get(ServiceProvider::OFFER_REPOSITORY);
        $this->flashService = ServiceLocator::getInstance()->get(ServiceProvider::FLASH_SERVICE);
        $this->pUtils = ServiceLocator::getInstance()->get(ServiceProvider::PARAM_UTILS);
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        $this->pUtils->tryParseInt($arParams['PAGE_SIZE'], 15);
        $this->pUtils->tryParseBoolean($arParams['USE_SEARCH']);
        $this->pUtils->tryParseString($arParams['DATE_FORMAT'], 'd.m.Y');
        $this->pUtils->tryParseString($arParams['DOWNLOAD_URL'], $this->application->GetCurPage() . '?CODE=#CODE#&ACTION=download');
        $this->pUtils->tryParseString($arParams['EDIT_URL'], $this->application->GetCurPage() . '?ID=#ID#&ACTION=edit');

        return $arParams;
    }

    public function executeComponent(): void
    {
        if ($this->checkModules() && $this->checkPermission())
        {
            $this->getSearchQuery();
            $this->prepareFilter();
            $this->initPageNav();
            $this->loadOffers();
            $this->formatResult();
        }

        $this->formatMessages();
        $this->formatResultErrors();

        $this->includeComponentTemplate();
    }

    protected function checkModules(): bool
    {
        if (!Loader::includeModule('redsign.kompred'))
        {
            $this->errorCollection[] = new Main\Error(
                Loc::getMessage('RS_KP_KOL_MODULE_NOT_INSTALLED') ?: 'MODULE_NOT_INSTALLED',
                self::ERROR_MODULE_NOT_INSTALLED
            );

            return false;
        }

        return true;
    }

    protected function checkPermission(): bool
    {
        if (!$this->user->getId())
        {
            $this->errorCollection[] = new Main\Error(
                Loc::getMessage('RS_KP_KOL_ACCESS_DENIED') ?: 'ACCESS_DENIED',
                self::ERROR_NO_ACCESS
            );

            return false;
        }

        return true;
    }

    protected function getSearchQuery(): void
    {
        $this->searchQuery = '';

        if ($this->arParams['USE_SEARCH'])
        {
            /** @var string */
            $query = $this->request->getQuery(self::SEARCH_QUERY_VARIABLE);
            if ($query) {
                $this->searchQuery = $query;
            }
        }
    }

    protected function prepareFilter(): void
    {
        $this->filter = [];
        $this->filter['USER_ID'] = $this->user->getId();

        if (mb_strlen($this->searchQuery))
        {
            /** @var string */
            $query = $this->request->getQuery(self::SEARCH_QUERY_VARIABLE);
            $this->filter['%=NAME'] = '%' . $query . '%';
        }
    }

    protected function initPageNav(): void
    {
        $navName = 'pagen-' . mb_strtolower($this->randString(2));
        $this->pageNav = new PageNavigation($navName);
        $this->pageNav
            ->allowAllRecords(true)
            ->setPageSize($this->arParams['PAGE_SIZE'])
            ->initFromUri();

        $recordsCount = $this->offerRepository->getRecordsCount($this->filter);
        $this->pageNav->setRecordCount($recordsCount);
    }

    protected function loadOffers(): void
    {
        $this->offers = $this->offerRepository->getByFilter(
            $this->filter,
            ['DATE_CREATED' => 'desc'],
            $this->pageNav->getOffset(),
            $this->pageNav->getLimit()
        );

        if ($this->offers) {
            foreach ($this->offers as $offer) {
                $offer->fill(['PRODUCTS', 'PROPERTIES']);
            }
        }
    }

    protected function formatResult(): void
    {
        $currentPage = htmlspecialcharsbx($this->application->GetCurPage());

        $this->arResult = [];
        $this->arResult['OFFERS'] = [];
        $this->arResult['PAGE_NAV'] = $this->pageNav;
        $this->arResult['SEARCH'] = [
            'VARIABLE' => self::SEARCH_QUERY_VARIABLE,
            'QUERY' => $this->searchQuery,
            'ACTION' => ($this->pageNav->clearParams(new Uri($currentPage), true))->getUri()
        ];

        if ($this->offers) {
            foreach ($this->offers as $offer) {
                $offerData = $offer->toArray();

                $offerData['~DATE_CREATED'] = $offerData['DATE_CREATED'];
                $offerData['DATE_CREATED'] = \FormatDate($this->arParams['DATE_FORMAT'], $offer->getDateCreated()->getTimestamp());

                $offerData['~DATE_UPDATED'] = $offerData['DATE_UPDATED'];
                $offerData['DATE_UPDATED'] = \FormatDate($this->arParams['DATE_FORMAT'], $offer->getDateUpdated()->getTimestamp());

                $offerData['DOWNLOAD_URL'] = $offer->getPath($this->arParams['DOWNLOAD_URL']);
                $offerData['EDIT_URL'] = $offer->getPath($this->arParams['EDIT_URL']);
                $offerData['DELETE_URL'] = $offer->getPath($this->arParams['EDIT_URL'], [
                    'del' => 'Y',
                    'sessid' => \bitrix_sessid()
                ]);

                $this->arResult['OFFERS'][] = $offerData;
            }
        }
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
}
