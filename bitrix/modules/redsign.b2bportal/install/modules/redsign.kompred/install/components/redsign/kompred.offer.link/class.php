<?php

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!\Bitrix\Main\Loader::includeModule('redsign.kompred')) {
    return;
}

class RedsignKompredOfferLink extends \CBitrixComponent implements Controllerable
{
    /** @var CurrentUser $user */
    protected $user;

    public function configureActions()
    {
        return [];
    }

    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
        $this->user = CurrentUser::get();
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->arResult['VISIBLE'] = $this->checkVisibility();
        $this->includeComponentTemplate();
    }

    public function checkAction(): bool
    {
        return $this->checkVisibility();
    }

    protected function checkVisibility(): bool
    {
        if ($this->user->getId() && Loader::includeModule('sale'))
        {
            $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
                \Bitrix\Sale\Fuser::getId(),
                $this->getSiteId()
            );

            return !$basket->isEmpty();
        }

        return false;
    }
}
