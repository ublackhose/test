<?php

namespace Redsign\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Redsign\VBasket\Core;
use Redsign\VBasket\BasketHelper;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

if (!Loader::includeModule('redsign.vbasket')) {
    ShowError(Loc::getMessage('RS_VBASKET_VS_MODULE_NOT_INSTALLED', ['#MODULE_ID#' => 'redsign.vbasket']));
    return;
}

class VBasketSelect extends \CBitrixComponent
{
    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * @param array $params
     * @return array
     */
    public function onPrepareComponentParams($params): array
    {
        $params = parent::onPrepareComponentParams($params);

        $params['USE_COUNTS'] = !isset($params['USE_COUNTS']) || !in_array($params['USE_COUNTS'], ['Y', 'N']);

        return $params;
    }

    protected function checkModules(): void
    {
        if (!Loader::includeModule('redsign.vbasket')) {
            throw new SystemException('redsign.vbasket module not installed');
        }
    }

    protected function getResult(): void
    {
        $this->arResult = BasketHelper::getAllBasketsByCurrentContext($this->arParams['USE_COUNTS']);
    }

    public function executeComponent(): void
    {
        try {
            if (Core::isEnabled()) {
                $this->checkModules();
                $this->setFrameMode(false);

                $this->getResult();

                $this->includeComponentTemplate();
            }
        } catch (SystemException $e) {
            \ShowError($e->getMessage());
        }
    }
}
