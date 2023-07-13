<?php

use Bitrix\Main\Loader;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$personTypes = [];
$orderPropsGroups = [];
$orderProps = [];

$personTypesIterator = Bitrix\Sale\Internals\PersonTypeTable::query()
    ->addOrder('SORT', 'ASC')
    ->setSelect(['ID', 'ACTIVE', 'NAME', 'SORT'])
    ->addSelect('PERSON_TYPE_SITE.SITE_ID', 'SITE_ID')
    ->where('ACTIVE', 'Y')
    ->where('SITE_ID', SITE_ID)
    ->exec();
while ($row = $personTypesIterator->fetch()) $personTypes[$row['ID']] = $row;
unset($row, $personTypesIterator);

$orderPropsIterator = Bitrix\Sale\Internals\OrderPropsTable::query()
    ->addOrder('SORT', 'ASC')
    ->setSelect([
        'ID', 'ACTIVE', 'CODE', 'DEFAULT_VALUE', 'INPUT_FIELD_LOCATION', 'IS_ADDRESS', 'IS_EMAIL', 'IS_LOCATION', 'IS_PAYER', 'IS_PHONE',
        'IS_PROFILE_NAME', 'IS_ZIP', 'MULTIPLE', 'NAME', 'PERSON_TYPE_ID', 'PROPS_GROUP_ID', 'REQUIRED', 'SETTINGS', 'SORT', 'TYPE'
    ])
    ->whereIn('PERSON_TYPE_ID', array_keys($personTypes))
    ->where('USER_PROPS', 'Y')
    ->where('ACTIVE', 'Y')
    ->where('UTIL', 'N')
    ->exec();
while ($row = $orderPropsIterator->fetch()) $orderProps[$row['ID']] = $row;
unset($row, $orderPropsIterator);

if (count($orderProps) > 0)
{
    $enumPropsIds = array_keys(array_filter($orderProps, function ($propFields) {
        return in_array($propFields['TYPE'], ['SELECT', 'MULTISELECT', 'RADIO', 'ENUM']);
    }));

    if (count($enumPropsIds) > 0)
    {
        $orderPropVariantsIterator = \Bitrix\Sale\Internals\OrderPropsVariantTable::query()
            ->addSelect('*')
            ->setFilter([
                'ORDER_PROPS_ID' => $enumPropsIds
            ])
            ->exec();

        while ($propVariant = $orderPropVariantsIterator->fetch())
        {
            $orderProp = &$orderProps[$propVariant['ORDER_PROPS_ID']];
            if (!isset($orderProp['VALUES']))
            {
                $orderProp['VALUES'] = [];
            }

            $orderProp['VALUES'][] = $propVariant;
            unset($orderProp);
        }
    }
}


$orderPropsGroupsIterator = Bitrix\Sale\Internals\OrderPropsGroupTable::query()
    ->addOrder('SORT', 'ASC')
    ->addSelect('*')
    ->whereIn('PERSON_TYPE_ID', array_keys($personTypes))
    ->exec();
while($row = $orderPropsGroupsIterator->fetch()) $orderPropsGroups[$row['ID']] = $row;

$orderPropsValues = [
    'COMPANY_PERSON_TYPE' => isset($_REQUEST['COMPANY_PERSON_TYPE']) ? htmlspecialcharsbx($_REQUEST['COMPANY_PERSON_TYPE']) : false,
    'COMPANY_NAME' => isset($_REQUEST['COMPANY_NAME']) ? htmlspecialcharsbx($_REQUEST['COMPANY_NAME']) : ''
];

$orderFieldsTypes = unserialize(Bitrix\Main\Config\Option::get('redsign.b2bportal', 'order_fields_types', '', SITE_ID));
if (!is_array($orderFieldsTypes))
{
    $orderFieldsTypes = [];
}

foreach ($orderProps as $propertyId => &$orderProp)
{
    $fieldName = 'COMPANY_PROP_' . $propertyId;
    $isMultiple = $orderProp['MULTIPLE'] == 'Y';

    if (isset($_REQUEST[$fieldName]))
    {
        if ($isMultiple)
        {
            $orderPropsValues[$fieldName] = array_map('htmlspecialcharsbx', $_REQUEST[$fieldName]);
        }
        else
        {
            $orderPropsValues[$fieldName] = htmlspecialcharsbx($_REQUEST[$fieldName]);
        }
    }
    else
    {
        if (!empty($orderProp['DEFAULT_VALUE']))
        {
            $orderPropsValues[$fieldName] = $orderProp['DEFAULT_VALUE'];
        }
        else
        {
            $orderPropsValues[$fieldName] = $isMultiple ? [] : '';
        }
    }

    if ($orderProp['TYPE'] == 'LOCATION')
    {
        $parameters = array(
            'CODE' => '',
            'INPUT_NAME' => $fieldName . ($isMultiple ? '[]' : ''),
            'CACHE_TYPE' => 'A',
            'CACHE_TIME' => '36000000',
            'SEARCH_BY_PRIMARY' => 'N',
            'SHOW_DEFAULT_LOCATIONS' => 'Y',
            'PROVIDE_LINK_BY' => 'code',
            'JS_CALLBACK' => 'submitFormProxy',
            'JS_CONTROL_DEFERRED_INIT' => $propertyId . ($isMultiple ? '_indexkey' : ''),
            'JS_CONTROL_GLOBAL_ID' => $propertyId . ($isMultiple ? '_indexkey' : ''),
            'DISABLE_KEYBOARD_INPUT' => 'Y',
            'PRECACHE_LAST_LEVEL' => 'N',
            'PRESELECT_TREE_TRUNK' => 'Y',
            'SUPPRESS_ERRORS' => 'Y',
            'FILTER_BY_SITE' => 'Y',
            'FILTER_SITE_ID' => SITE_ID
        );

        ob_start();

        $APPLICATION->IncludeComponent(
            'bitrix:sale.location.selector.search',
            '',
            $parameters,
            null,
            array('HIDE_ICONS' => 'Y')
        );

        $orderProp['OUTPUT_HTML'] = ob_get_contents();
        ob_end_clean();

        if ($isMultiple)
        {
            if (!count($orderPropsValues[$fieldName]))
            {
                $orderPropsValues[$fieldName][] = $orderProp['OUTPUT_HTML'];
            }
            else
            {
                foreach ($orderPropsValues[$fieldName] as $index => $value)
                {
                    $parameters['CODE'] = $value;
                    $parameters['JS_CONTROL_DEFERRED_INIT'] = $propertyId . '_' . $index;

                    ob_start();
                    $APPLICATION->IncludeComponent(
                        'bitrix:sale.location.selector.search',
                        '',
                        $parameters,
                        null,
                        array('HIDE_ICONS' => 'Y')
                    );

                    $orderPropsValues[$fieldName][$index] = ob_get_contents();
                    ob_end_clean();
                }
            }
        }
        else
        {
            if (!empty($orderPropsValues[$fieldName]))
            {
                $parameters['CODE'] = $orderPropsValues[$fieldName];
                ob_start();
                $APPLICATION->IncludeComponent(
                    'bitrix:sale.location.selector.search',
                    '',
                    $parameters,
                    null,
                    array('HIDE_ICONS' => 'Y')
                );

                $orderPropsValues[$fieldName] = ob_get_contents();
                ob_end_clean();
            }
            else
            {
                $orderPropsValues[$fieldName] = $orderProp['OUTPUT_HTML'];
            }
        }
    }
    elseif ($orderProp['TYPE'] == 'STRING')
    {
        $fieldTypes = array_keys(
            array_filter($orderFieldsTypes, function ($val, $key) use ($orderProp, $orderFieldsTypes) {
                return in_array($orderProp['ID'], $orderFieldsTypes[$key]);
            }, ARRAY_FILTER_USE_BOTH)
        );

        $orderProp['FIELD_TYPE'] = reset($fieldTypes);
    }
}
unset($orderProp);


$arResult['PERSON_TYPES'] = array_values($personTypes);
$arResult['ORDER_PROPS'] = array_values($orderProps);
$arResult['ORDER_PROPS_GROUPS'] = array_values($orderPropsGroups);
$arResult['ORDER_PROPS_VALUES'] = $orderPropsValues;
