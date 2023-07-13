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


if (empty($arResult['GROUP']) || empty($arResult['PROPERTY']))
{
    return;
}

$orderFieldsTypes = unserialize(Option::get('redsign.b2bportal', 'order_fields_types', '', SITE_ID));
$hasOrderFields = is_array($orderFieldsTypes);

$arGroupIds = [];
foreach ($arResult['PROPERTY'] as &$property)
{
    $arGroupIds[] = $property['PROPS_GROUP_ID'];

    if ($hasOrderFields)
    {
        $fieldTypes = array_keys(
            array_filter($orderFieldsTypes, function ($val, $key) use ($property, $orderFieldsTypes) {
                return in_array($property['ID'], $orderFieldsTypes[$key]);
            }, ARRAY_FILTER_USE_BOTH)
        );

        $property['FIELD_TYPE'] = reset($fieldTypes);
    }
}
unset($property);

foreach ($arResult['GROUP'] as $key1 => $arGroup)
{
    if (in_array($arGroup['ID'], $arGroupIds))
    {
        $arResult['GROUP'][$key1]['HAVE_PROPS'] = true;
    }
    else
    {
        $arResult['GROUP'][$key1]['HAVE_PROPS'] = false;
    }
}
