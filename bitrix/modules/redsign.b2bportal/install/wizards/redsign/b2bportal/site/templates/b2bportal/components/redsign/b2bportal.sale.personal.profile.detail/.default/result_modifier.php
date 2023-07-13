<?php

use Bitrix\Main\Config\Option;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$orderFieldsTypes = unserialize(Option::get('redsign.b2bportal', 'order_fields_types', '', SITE_ID));

if (is_array($orderFieldsTypes))
{
    foreach ($arResult["ORDER_PROPS"] as &$group)
    {
        foreach ($group['PROPS'] as &$property)
        {
            $fieldTypes = array_keys(
                array_filter($orderFieldsTypes, function ($val, $key) use ($property, $orderFieldsTypes) {
                    return in_array($property['ID'], $orderFieldsTypes[$key]);
                }, ARRAY_FILTER_USE_BOTH)
            );

            $property['FIELD_TYPE'] = reset($fieldTypes);
        }
        unset($property);
    }
    unset($group);
}
