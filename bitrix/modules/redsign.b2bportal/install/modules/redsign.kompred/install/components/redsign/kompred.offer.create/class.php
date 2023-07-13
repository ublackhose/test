<?php

namespace Redsign\Components\Kompred;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\KomPred\Offer;
use Redsign\KomPred\ErrorableImplementation;
use Redsign\KomPred\RefreshService;
use Redsign\KomPred\ServiceProvider;
use Redsign\KomPred\Shortener\ShortenerService;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

if (!\Bitrix\Main\Loader::includeModule('redsign.kompred')) {
    return;
}

class RedsignKompredOfferCreate extends \CBitrixComponent implements
    Errorable
{
    use ErrorableImplementation;

    public const ERROR_MODULE_NOT_INSTALLED = 10000;
    public const ERROR_NO_ACCESS = 10001;
    public const ERROR_FAILED_TO_CREATE = 10002;
    public const ERROR_CART_IS_EMPTY = 10003;

    /** @var Offer\Offer $offer */
    protected $offer;

    /** @var CurrentUser $user */
    protected $user;

    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->errorCollection = new ErrorCollection();
        $this->user = CurrentUser::get();
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        if (!isset($arParams['SITE_ID']))
        {
            $arParams['SITE_ID'] = $this->getSiteId();
        }

        if (empty($arParams['EDIT_URL']))
        {
            $arParams['EDIT_URL'] = SITE_DIR . '/kompred/edit/#ID#/';
        }

        if (empty($arParams['DOWNLOAD_URL']))
        {
            $arParams['DOWNLOAD_URL'] = SITE_DIR . '/kompred/download/#CODE#/';
        }

        return $arParams;
    }

    public function executeComponent(): void
    {
        if ($this->checkModules() && $this->checkPermission())
        {
            if ($this->createOffer())
            {
                $this->redirectToEdit();
            }
        }

        $this->formatResultErrors();
        $this->includeComponentTemplate();
    }

    protected function checkModules(): bool
    {
        if (!Loader::includeModule('redsign.kompred'))
        {
            $this->errorCollection[] = new Error(
                Loc::getMessage('RS_KP_KOC_MODULE_NOT_INSTALLED') ?: 'MODULE_NOT_INSTALLED',
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
            $this->errorCollection[] = new Error(
                Loc::getMessage('RS_KP_KOC_MODULE_NOT_ALLOWED') ?: 'MODULE_NOT_ALLOWED',
                self::ERROR_NO_ACCESS
            );

            return false;
        }

        return true;
    }

    protected function createOffer(): bool
    {
        $serviceLocator = ServiceLocator::getInstance();

        /** @var Offer\OfferBuilderInterface $offerBuilder */
        $offerBuilder = $serviceLocator->get(ServiceProvider::OFFER_BUILDER);

        /** @var \Bitrix\Sale\Basket */
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
            \Bitrix\Sale\Fuser::getId(),
            $this->arParams['SITE_ID']
        );

        try {
            $this->offer = $offerBuilder->buildFromBasket($basket);
        } catch (\Throwable $ex) {
            $this->errorCollection[] = new Error(
                Loc::getMessage('RS_KP_KOC_CREATE_ERROR') ?: 'CREATE_ERROR',
                self::ERROR_FAILED_TO_CREATE
            );

            return false;
        }

        if (!$this->offer->hasProducts())
        {
            $this->errorCollection[] = new Error(
                Loc::getMessage('RS_KP_KOC_CART_IS_EMPTY_ERROR') ?: 'CART_IS_EMPTY_ERROR',
                self::ERROR_CART_IS_EMPTY
            );

            return false;
        }

        /** @var RefreshService $refreshService */
        $refreshService = $serviceLocator->get(ServiceProvider::REFRESH_SERVICE);
        $refreshResult = $refreshService->refresh($this->offer);
        if (!$refreshResult->isSuccess())
        {
            $this->errorCollection->add($refreshResult->getErrors());
            return false;
        }

        $saveResult = $this->offer->save();
        $this->errorCollection->add($saveResult->getErrors());

        if ($saveResult->isSuccess())
        {
            $offerStructure = new Offer\OfferStructure();
            $offerStructure->setStructure($this->defaultStructure());
            $offerStructure->setOffer($this->offer);
            $offerStructure->save();

            if ($this->arParams['MAKE_SHORTLINK'] === 'Y')
            {
                /** @var ShortenerService $shortener */
                $shortener = $serviceLocator->get(ServiceProvider::SHORTENER_SERVICE);

                $shortener->make($this->offer, $this->offer->getPath($this->arParams['DOWNLOAD_URL']));
            }
        }

        return $saveResult->isSuccess();
    }

    protected function redirectToEdit(): void
    {
        \LocalRedirect($this->offer->getPath($this->arParams['EDIT_URL']));
    }

    protected function formatResultErrors(): void
    {
        $this->arResult['ERRORS'] = [];
        foreach ($this->errorCollection as $error)
        {
            $this->arResult['ERRORS'][$error->getCode()] = $error->getMessage();
        }
    }

    protected function defaultStructure(): array
    {
        return [
            'blocks' => [
                [
                    'type' => 'templateHeader',
                    'data' => [
                        'contacts' => $this->arParams['~DEFAULT_CONTACTS'],
                        'logo' => $this->arParams['DEFAULT_LOGO']
                    ]
                ],
                [
                    'type' => 'header',
                    'data' => [
                        'text' => $this->offer->getName(),
                        'level' => 4
                    ]
                ],
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => Loc::getMessage('RS_KP_KOC_STRUCTURE_P_1'),
                    ]
                ],
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => Loc::getMessage('RS_KP_KOC_STRUCTURE_P_2'),
                    ]
                ],
                [
                    'type' => 'productTable',
                    'data' => []
                ],
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => Loc::getMessage('RS_KP_KOC_STRUCTURE_P_3')
                    ]
                ]
            ]
        ];
    }
}
