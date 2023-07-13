<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"quicksearch", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "#CATALOG_CATALOG_IBLOCK_ID#",
		),
		"CHECK_DATES" => "N",
		"CONTAINER_ID" => "inheader-title-search",
		"CONVERT_CURRENCY" => "N",
		"INPUT_ID" => "inheader-title-search-input",
		"NUM_CATEGORIES" => "2",
		"ORDER" => "date",
		"PAGE" => "#SITE_DIR#catalog/",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"SHOW_PREVIEW" => "Y",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"PROP_CODE_ARTICLE" => "ARTNUMBER",
		"CATEGORY_1_TITLE" => "Предложения",
		"CATEGORY_1" => array(
			0 => "iblock_offers",
		),
		"CATEGORY_1_iblock_offers" => array(
			0 => "#OFFERS_OFFERS_IBLOCK_ID#",
		)
	),
	false
);?>