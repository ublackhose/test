<?php

use Bitrix\Main\Loader;
use Redsign\B2BPortal\Iblock\PropertyFeature;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arPropertyCodeRemove = [];

if (Loader::includeModule('redsign.b2bportal') && PropertyFeature::isEnabledFeatures())
{
    $arParams['PROP_CODE_ARTICLE'] = PropertyFeature::getFirstArticlePropertyCode(
        $arParams['IBLOCK_ID'],
        ['CODE' => 'Y']
    );
    $arParams['PROP_CODE_BRAND'] = PropertyFeature::getFirstBrandPropertyCode(
        $arParams['IBLOCK_ID'],
        ['CODE' => 'Y']
    );
}
else
{
    $arParams['PROP_CODE_ARTICLE'] = !empty($arParams['PROP_CODE_ARTICLE']) ? $arParams['PROP_CODE_ARTICLE'] : 'ARTICLE';
    $arParams['PROP_CODE_BRAND'] = !empty($arParams['PROP_CODE_BRAND']) ? $arParams['PROP_CODE_BRAND'] : 'BRAND';
}

$arParams['PROP_CODE_MORE_PHOTO'] = !empty($arParams['PROP_CODE_MORE_PHOTO']) ? $arParams['PROP_CODE_MORE_PHOTO'] : 'MORE_PHOTO';
$arParams['PROP_CODE_VIDEO_GALLERY'] = !empty($arParams['PROP_CODE_VIDEO_GALLERY']) ? $arParams['PROP_CODE_VIDEO_GALLERY'] : 'VIDEO_GALLERY';

$arParams['PROPERTY_CODE'] = array_diff($arParams['PROPERTY_CODE'], [
    $arParams['PROP_CODE_ARTICLE'],
    $arParams['PROP_CODE_BRAND'],
    $arParams['PROP_CODE_MORE_PHOTO'],
    $arParams['PROP_CODE_VIDEO_GALLERY']
]);


$arResult['GALLERY_ITEMS'] = [];

if ($arResult['DETAIL_PICTURE']['SAFE_SRC'])
{
    $arResult['GALLERY_ITEMS'][] = [
        'type' => 'image',
        'thumbnail' => $arResult['DETAIL_PICTURE']['SAFE_SRC'],
        'src' => $arResult['DETAIL_PICTURE']['SAFE_SRC'],
        'w' => $arResult['DETAIL_PICTURE']['WIDTH'],
        'h' => $arResult['DETAIL_PICTURE']['HEIGHT']
    ];
}

if (!empty($arResult['PROPERTIES'][$arParams['PROP_CODE_MORE_PHOTO']]['VALUE']))
{
    foreach ($arResult['PROPERTIES'][$arParams['PROP_CODE_MORE_PHOTO']]['VALUE'] as $iFile)
    {
        $fileValue = \CFile::GetFileArray($iFile);
        $fileSrc = \Bitrix\Iblock\Component\Tools::getImageSrc($fileValue);

        $arResult['GALLERY_ITEMS'][] = [
            'type' => 'image',
            'thumbnail' => $fileSrc,
            'src' => $fileSrc,
            'w' => $fileValue['WIDTH'],
            'h' => $fileValue['HEIGHT']
        ];
    }
}

if (!empty($arResult['PROPERTIES'][$arParams['PROP_CODE_VIDEO_GALLERY']]['VALUE']))
{
    $providers = [
        'youtube' => [
            'type' => 'iframe_video',
            'pattern' => '/^.+(youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(watch\?(.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*))(.*)/i',
            'src' => '//www.youtube-nocookie.com/embed/$4',
            'thumbnail' => '//img.youtube.com/vi/$4/hqdefault.jpg'
        ],
        'vimeo' => [
            'type' => 'iframe_video',
            'pattern' => '/^.+vimeo.com\/(.*\/)?([\d]+)(.*)?/',
            'src' => '//player.vimeo.com/video/$2'
        ]
    ];

    $values = [];
    if (is_array($arResult['PROPERTIES'][$arParams['PROP_CODE_VIDEO_GALLERY']]['VALUE']))
    {
        $values = $arResult['PROPERTIES'][$arParams['PROP_CODE_VIDEO_GALLERY']]['VALUE'];
    }
    else
    {
        $values[] = $arResult['PROPERTIES'][$arParams['PROP_CODE_VIDEO_GALLERY']]['VALUE'];
    }

    foreach ($values as $val)
    {
        $isFoundByProvider = false;

        foreach ($providers as $providerName => $provider)
        {
            if (preg_match($provider['pattern'], $val, $matches))
            {
                $thumbnail = null;
                if (isset($provider['thumbnail']))
                {
                    $thumbnail = preg_replace($provider['pattern'], $provider['thumbnail'], $val);
                }

                $arResult['GALLERY_ITEMS'][] = [
                    'type' => $provider['type'],
                    'src' => preg_replace($provider['pattern'], $provider['src'], $val),
                    'thumbnail' => $thumbnail
                ];

                $isFoundByProvider = true;
            }
        }

        if (!$isFoundByProvider && preg_match('/^.*\.(mp4|mov|avi|flv|mpeg|wmv|webm|mkv)$/i', $val))
        {
            $arResult['GALLERY_ITEMS'][] = [
                'type' => 'video',
                'src' => $val,
                'thumbnail' => null
            ];
        }
    }
}

$arResult['LABELS'] = [];
foreach ($arParams['LABEL_PROP'] as $propCode)
{
    if (isset($arResult['PROPERTIES'][$propCode]) && $arResult['PROPERTIES'][$propCode]['VALUE_XML_ID'])
    {
        $arResult['LABELS'][] = [
            'NAME' => $arResult['PROPERTIES'][$propCode]['NAME'],
            'CODE' => $arResult['PROPERTIES'][$propCode]['CODE'],
            'MODIFIER' => $arParams['LABEL_PROP_MODIFIER_' . $propCode] ?? 'primary'
        ];
    }
}

$this->getComponent()->SetResultCacheKeys(['DISPLAY_PROPERTIES']);
