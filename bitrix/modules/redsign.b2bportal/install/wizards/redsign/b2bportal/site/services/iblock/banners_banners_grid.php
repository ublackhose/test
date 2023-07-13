<?php

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!CModule::IncludeModule("iblock"))
    return;

if (COption::GetOptionString("redsign.b2bportal", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA) {
    if ($wizard->GetVar('rewriteIndex', true)) {
        $iblockCode = "redsign_b2bportal_banners_banners_grid_" . WIZARD_SITE_ID;
        $iblockType = "banners";

        $rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
        $iblockID = false;
        if ($arIBlock = $rsIBlock->Fetch()) {
            $iblockID = $arIBlock['ID'];

            // Replace macros
            CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '/_index.php', ['BANNERS_BANNERS_GRID_IBLOCK_ID' => $iblockID]);
        }
    }
    return;
}

$iblockCode = "redsign_b2bportal_banners_banners_grid_" . WIZARD_SITE_ID;
$iblockType = "banners";

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH . "/xml/common/" . $iblockType . "/banners_grid-ru.xml";

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false;

if ($arIBlock = $rsIBlock->Fetch())
{
    $iblockID = $arIBlock["ID"];
    if (WIZARD_INSTALL_DEMO_DATA)
    {
        CIBlock::Delete($arIBlock["ID"]);
        $iblockID = false;
    }
}

if ($iblockID == false) {
    $permissions = array(
        "1" => "X",
        "2" => "R"
    );
    $by = "";
    $order = "";
    $dbGroup = CGroup::GetList('', '', array("STRING_ID" => "content_editor"));
    if ($arGroup = $dbGroup->Fetch()) {
        $permissions[$arGroup["ID"]] = 'W';
    };

    $iblockID = WizardServices::ImportIBlockFromXML(
        $iblockXMLFile,
        "redsign_b2bportal_banners_banners_grid",
        $iblockType,
        WIZARD_SITE_ID,
        $permissions
    );

    if ($iblockID < 1)
        return;

    //IBlock fields
    $iblock = new CIBlock();
    $arFields = [
        'ACTIVE' => 'Y',
        'FIELDS' => [
            'IBLOCK_SECTION' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'KEEP_IBLOCK_SECTION_ID' => 'N',
                ],
            ],
            'ACTIVE' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'Y',
            ],
            'ACTIVE_FROM' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'ACTIVE_TO' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'SORT' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '0',
            ],
            'NAME' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => '',
            ],
            'PREVIEW_PICTURE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'FROM_DETAIL' => 'N',
                    'SCALE' => 'N',
                    'WIDTH' => '',
                    'HEIGHT' => '',
                    'IGNORE_ERRORS' => 'N',
                    'METHOD' => 'resample',
                    'COMPRESSION' => 95,
                    'DELETE_WITH_DETAIL' => 'N',
                    'UPDATE_WITH_DETAIL' => 'N',
                    'USE_WATERMARK_TEXT' => 'N',
                    'WATERMARK_TEXT' => '',
                    'WATERMARK_TEXT_FONT' => '',
                    'WATERMARK_TEXT_COLOR' => '',
                    'WATERMARK_TEXT_SIZE' => '',
                    'WATERMARK_TEXT_POSITION' => 'tl',
                    'USE_WATERMARK_FILE' => 'N',
                    'WATERMARK_FILE' => '',
                    'WATERMARK_FILE_ALPHA' => '',
                    'WATERMARK_FILE_POSITION' => 'tl',
                    'WATERMARK_FILE_ORDER' => null,
                ],
            ],
            'PREVIEW_TEXT_TYPE' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'text',
            ],
            'PREVIEW_TEXT' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'DETAIL_PICTURE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'SCALE' => 'N',
                    'WIDTH' => '',
                    'HEIGHT' => '',
                    'IGNORE_ERRORS' => 'N',
                    'METHOD' => 'resample',
                    'COMPRESSION' => 95,
                    'USE_WATERMARK_TEXT' => 'N',
                    'WATERMARK_TEXT' => '',
                    'WATERMARK_TEXT_FONT' => '',
                    'WATERMARK_TEXT_COLOR' => '',
                    'WATERMARK_TEXT_SIZE' => '',
                    'WATERMARK_TEXT_POSITION' => 'tl',
                    'USE_WATERMARK_FILE' => 'N',
                    'WATERMARK_FILE' => '',
                    'WATERMARK_FILE_ALPHA' => '',
                    'WATERMARK_FILE_POSITION' => 'tl',
                    'WATERMARK_FILE_ORDER' => null,
                ],
            ],
            'DETAIL_TEXT_TYPE' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'text',
            ],
            'DETAIL_TEXT' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'XML_ID' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => '',
            ],
            'CODE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'UNIQUE' => 'N',
                    'TRANSLITERATION' => 'Y',
                    'TRANS_LEN' => 100,
                    'TRANS_CASE' => 'L',
                    'TRANS_SPACE' => '-',
                    'TRANS_OTHER' => '-',
                    'TRANS_EAT' => 'Y',
                    'USE_GOOGLE' => 'N',
                ],
            ],
            'TAGS' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'SECTION_NAME' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => '',
            ],
            'SECTION_PICTURE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'FROM_DETAIL' => 'N',
                    'SCALE' => 'N',
                    'WIDTH' => '',
                    'HEIGHT' => '',
                    'IGNORE_ERRORS' => 'N',
                    'METHOD' => 'resample',
                    'COMPRESSION' => 95,
                    'DELETE_WITH_DETAIL' => 'N',
                    'UPDATE_WITH_DETAIL' => 'N',
                    'USE_WATERMARK_TEXT' => 'N',
                    'WATERMARK_TEXT' => '',
                    'WATERMARK_TEXT_FONT' => '',
                    'WATERMARK_TEXT_COLOR' => '',
                    'WATERMARK_TEXT_SIZE' => '',
                    'WATERMARK_TEXT_POSITION' => 'tl',
                    'USE_WATERMARK_FILE' => 'N',
                    'WATERMARK_FILE' => '',
                    'WATERMARK_FILE_ALPHA' => '',
                    'WATERMARK_FILE_POSITION' => 'tl',
                    'WATERMARK_FILE_ORDER' => null,
                ],
            ],
            'SECTION_DESCRIPTION_TYPE' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => 'text',
            ],
            'SECTION_DESCRIPTION' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'SECTION_DETAIL_PICTURE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'SCALE' => 'N',
                    'WIDTH' => '',
                    'HEIGHT' => '',
                    'IGNORE_ERRORS' => 'N',
                    'METHOD' => 'resample',
                    'COMPRESSION' => 95,
                    'USE_WATERMARK_TEXT' => 'N',
                    'WATERMARK_TEXT' => '',
                    'WATERMARK_TEXT_FONT' => '',
                    'WATERMARK_TEXT_COLOR' => '',
                    'WATERMARK_TEXT_SIZE' => '',
                    'WATERMARK_TEXT_POSITION' => 'tl',
                    'USE_WATERMARK_FILE' => 'N',
                    'WATERMARK_FILE' => '',
                    'WATERMARK_FILE_ALPHA' => '',
                    'WATERMARK_FILE_POSITION' => 'tl',
                    'WATERMARK_FILE_ORDER' => null,
                ],
            ],
            'SECTION_XML_ID' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => '',
            ],
            'SECTION_CODE' => [
                'IS_REQUIRED' => 'N',
                'DEFAULT_VALUE' => [
                    'UNIQUE' => 'N',
                    'TRANSLITERATION' => 'Y',
                    'TRANS_LEN' => 100,
                    'TRANS_CASE' => 'L',
                    'TRANS_SPACE' => '-',
                    'TRANS_OTHER' => '-',
                    'TRANS_EAT' => 'Y',
                    'USE_GOOGLE' => 'N',
                ],
            ],
        ],
        'CODE' => 'banners_grid',
        'XML_ID' => $iblockCode,
        'API_CODE' => 'RedsignB2bportalBannersBannersGrid' . ucfirst(WIZARD_SITE_ID),
    ];

    $iblock->Update($iblockID, $arFields);
} else {
    $arSites = array();
    $db_res = CIBlock::GetSite($iblockID);
    while ($res = $db_res->Fetch())
        $arSites[] = $res["LID"];
    if (!in_array(WIZARD_SITE_ID, $arSites)) {
        $arSites[] = WIZARD_SITE_ID;
        $iblock = new CIBlock();
        $iblock->Update($iblockID, array("LID" => $arSites));
    }
}

// Replace macros
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '/_index.php', ['BANNERS_BANNERS_GRID_IBLOCK_ID' => $iblockID]);

$lang = '';
$dbSite = CSite::GetByID(WIZARD_SITE_ID);
if($arSite = $dbSite->Fetch())
    $lang = $arSite['LANGUAGE_ID'];
if($lang == '')
    $lang = 'ru';

WizardServices::IncludeServiceLang('banners_banners_grid.php', $lang);

$userFormElementOption = [
    'edit1' => [
        'ID',
        'ACTIVE',
        'ACTIVE_FROM',
        'ACTIVE_TO',
        'NAME',
        'SECTIONS',
        'SORT',
        'PROPERTY_LINK',
        'PROPERTY_LINK_TARGET',
        'PROPERTY_BACKGROUND_IMAGE',
    ],
    'edit14' => [
        'IPROPERTY_TEMPLATES_ELEMENT_META_TITLE',
        'IPROPERTY_TEMPLATES_ELEMENT_META_KEYWORDS',
        'IPROPERTY_TEMPLATES_ELEMENT_META_DESCRIPTION',
        'IPROPERTY_TEMPLATES_ELEMENT_PAGE_TITLE',
        'IPROPERTY_TEMPLATES_ELEMENTS_PREVIEW_PICTURE',
        'IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_ALT',
        'IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_TITLE',
        'IPROPERTY_TEMPLATES_ELEMENT_PREVIEW_PICTURE_FILE_NAME',
        'IPROPERTY_TEMPLATES_ELEMENTS_DETAIL_PICTURE',
        'IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_ALT',
        'IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_TITLE',
        'IPROPERTY_TEMPLATES_ELEMENT_DETAIL_PICTURE_FILE_NAME',
        'SEO_ADDITIONAL',
        'TAGS',
    ],
];

$properties = [];
$propertyIterator = \Bitrix\Iblock\PropertyTable::getList([
    "filter" => ["IBLOCK_ID" => $iblockID],
    "select" => ["ID", "CODE"]
]);
while ($property = $propertyIterator->fetch())
{
    $properties[$property["CODE"]] = $property["ID"];
}

$tabVals = [];
$tabIndex = 0;
foreach ($userFormElementOption as $tabId => $fields)
{
    $tabVals[$tabIndex][] = (($tabIndex == 0) ? $tabId : "--" . $tabId) . "--#--" . GetMessage("RS_WZRD_BANNERS_GRID_FORM_ELEMENT_TAB_" . $tabId) . "--";

    foreach ($fields as $fieldKey)
    {
        $code = $fieldKey;
        if (0 === strpos($fieldKey, "PROPERTY_"))
        {
            $code = substr($fieldKey, 9);
            $code = "PROPERTY_" . $properties[$code];
        }
        $tabVals[$tabIndex][] = "--" . $code . "--#--" . GetMessage("RS_WZRD_BANNERS_GRID_FORM_ELEMENT_FIELD_" . $fieldKey) . "--";
    }

    $tabIndex++;
}

$opts = [];
foreach ($tabVals as $fields) {
    $opts[] = implode(",", $fields);
}

$opts = implode(";", $opts) . ";--";

$userFormElementValue = [
    "tabs" => $opts,
];

\CUserOptions::SetOption('form', 'form_element_' . $iblockID, $userFormElementValue);

// update SITE_DIR in iblock content
$arPropsEdit = ['LINK', 'BUTTONS'];
$arOrder = [];
$arFilter = [
    'IBLOCK_ID' => $iblockID,
];
$arSelect = ['ID', 'IBLOCK_ID'];

$arSelect = array_merge(
    $arSelect,
    array_map(function ($v) {
        return 'PROPERTY_' . $v;
    }, $arPropsEdit)
);

$dbElements = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while ($obElement = $dbElements->GetNextElement())
{
    $arElement = $obElement->GetFields();
    $arElement['PROPERTIES'] = $obElement->GetProperties();

    foreach ($arPropsEdit as $code)
    {
        if (!empty($arElement['PROPERTIES'][$code]['VALUE']))
        {
            $propNewValue = false;
            if (is_array($arElement['PROPERTIES'][$code]['VALUE']))
            {
                foreach ($arElement['PROPERTIES'][$code]['VALUE'] as $key => $sPropValue)
                {
                    if (!empty($arElement['PROPERTIES'][$code]['DESCRIPTION']))
                    {
                        $propNewValue[$key] = [
                            'VALUE' => str_replace('#SITE_DIR#', WIZARD_SITE_DIR, $sPropValue),
                            'DESCRIPTION' => $arElement['PROPERTIES'][$code]['DESCRIPTION'][$key]
                        ];
                    }
                    else
                    {
                        $propNewValue[$key] = str_replace(
                            '#SITE_DIR#',
                            WIZARD_SITE_DIR,
                            $sPropValue
                        );
                    }
                }
            }
            else
            {
                $propNewValue = str_replace(
                    '#SITE_DIR#',
                    WIZARD_SITE_DIR,
                    $arElement['PROPERTIES'][$code]['VALUE']
                );
            }

            if ($propNewValue)
            {
                CIBlockElement::SetPropertyValuesEx(
                    $arElement['ID'],
                    $arElement['IBLOCK_ID'],
                    [$code => $propNewValue]
                );
            }
        }
    }
}
