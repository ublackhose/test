<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (empty($arResult['SECTIONS']))
    return;

// \CBitrixComponent::includeComponentClass('redsign:b2bportal.sections.extra');

if (!function_exists('sectionListMakeChildren'))
{
    function sectionListMakeChildren(array &$arItems, int $level = 1, int &$i = 0): array
    {
        $returnArray = array();

        if (!is_array($arItems))
        {
            return $returnArray;
        }

        for (
            $currentItemKey = 0, $countItems = count($arItems);
            $i < $countItems;
            ++$i
        ) {
            $arItem = $arItems[$i];

            if ($arItem['DEPTH_LEVEL'] == $level)
            {
                $returnArray[$currentItemKey++] = $arItem;
            }
            elseif ($arItem['DEPTH_LEVEL'] > $level)
            {
                $returnArray[$currentItemKey - 1]['CHILDREN'] = sectionListMakeChildren(
                    $arItems,
                    $level + 1,
                    $i
                );
            }
            elseif ($level > $arItem['DEPTH_LEVEL'])
            {
                --$i;
                break;
            }
        }

        return $returnArray;
    }
}

$sectionsDepthLevel = isset($arResult['SECTION']['DEPTH_LEVEL']) && $arResult['SECTION']['DEPTH_LEVEL'] >= 0 ? $arResult['SECTION']['DEPTH_LEVEL'] + 1 : 1;
$arResult['NEW_ITEMS'] = sectionListMakeChildren($arResult['SECTIONS'], $sectionsDepthLevel);
