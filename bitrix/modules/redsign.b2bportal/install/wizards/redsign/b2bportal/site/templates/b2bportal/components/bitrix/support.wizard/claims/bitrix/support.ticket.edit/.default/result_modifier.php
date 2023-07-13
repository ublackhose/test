<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!isset($arParams['ORDER_PATH']))
{
    $arParams['ORDER_PATH'] = SITE_DIR . '/personal/order/#ORDER_NUMBER#/';
}

if (\Bitrix\Main\Loader::includeModule('sale'))
{
    if (!empty($arResult['TICKET']) && !empty($arResult['TICKET']['UF_ORDER_ID']))
    {
        $order = Bitrix\Sale\Order::load($arResult['TICKET']['UF_ORDER_ID']);

        if (
            $order &&
            (int) $arResult['TICKET']['OWNER_USER_ID'] === (int) $order->getUserId()
        )
        {
            $orderFields = $order->getFields();
            $arResult['TICKET']['ORDER'] = $orderFields->getValues();

            $orderStatusIterator = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
                'order' => array('STATUS.SORT' => 'ASC'),
                'filter' => array('STATUS.ID' => $orderFields->get('STATUS_ID'),'LID' => LANGUAGE_ID),
                'select' => array('STATUS_ID', 'STATUS_COLOR' => 'STATUS.COLOR', 'NAME', 'DESCRIPTION'),
            ));

            $orderStatus = $orderStatusIterator->fetch();
            $arResult['TICKET']['ORDER']['STATUS_NAME'] = $orderStatus['NAME'] ?? '';
            $arResult['TICKET']['ORDER']['STATUS_DESCRIPTION'] = $orderStatus['DESCRIPTION'] ?? '';
            $arResult['TICKET']['ORDER']['STATUS_COLOR'] = $orderStatus['STATUS_COLOR'] ?? '';

            $saleModulePermissions = $APPLICATION->GetGroupRight("sale");
            if ($saleModulePermissions > 'D')
            {
                $arResult['TICKET']['ORDER']['DETAIL_PAGE'] = CComponentEngine::makePathFromTemplate(
                    '/bitrix/admin/sale_order_view.php?ID=#ORDER_ID#&lang=#LANG#',
                    array(
                        'ORDER_ID' => $arResult['TICKET']['ORDER']['ID'],
                        'LANG' => LANGUAGE_ID
                    )
                );
            }
            else
            {
                $arResult['TICKET']['ORDER']['DETAIL_PAGE'] = CComponentEngine::makePathFromTemplate(
                    $arParams['ORDER_PATH'],
                    array(
                        'ORDER_NUMBER' => urlencode(urlencode($arResult['TICKET']['ORDER']['ACCOUNT_NUMBER']))
                    )
                );
            }

            $datePayed = $orderFields->get('DATE_PAYED');
            if ($datePayed instanceof \Bitrix\Main\Type\Datetime)
            {
                $arResult['TICKET']['ORDER']['FORMATTED_DATE_PAYED'] = $datePayed->toString();
            }
        }
    }
}
