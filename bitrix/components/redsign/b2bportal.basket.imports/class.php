<?php

use Bitrix\Catalog\Product\PropertyCatalogFeature;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\ErrorableImplementation;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Web\HttpClient;
use Redsign\B2BPortal\DI;
use Redsign\B2BPortal\Iblock\PropertyFeature;
use Redsign\B2BPortal\Spreadsheet;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

class RedsignB2BPortalBasketImports extends \CBitrixComponent implements Controllerable, Errorable
{
    use ErrorableImplementation;

    public const DEFAULT_PROP_CODE = 'CML2_ARTICLE';

    protected Spreadsheet\SpoutReader $reader;
    protected HttpClient $httpClient;

    protected int $iblockId;
    protected int $offersIblockId;

    /**
     * @return array
     */
    public function configureActions(): array
    {
        return [
            'check' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                ]
            ],
            'textImport' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                ]
            ],
            'addtobasket' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                ]
            ]
        ];
    }

    protected function listKeysSignedParameters(): array
    {
        return [
            'IBLOCK_ID',
            'PROP_CODE',
            'OFFERS_PROP_CODE'
        ];
    }

    /**
     * @param \CBitrixComponent|null $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->checkModules();

        $container = DI\ServiceContainer::getInstance();

        $this->errorCollection = new ErrorCollection();

        $this->reader = $container->get('Spreadsheet\Reader');
        $this->request = $container->get('Request');
        $this->httpClient = $container->get('HttpClient');
    }

    /**
     * @throws SystemException
     *
     * @return void
     */
    protected function checkModules(): void
    {
        if (!Loader::includeModule('redsign.b2bportal'))
        {
            throw new SystemException(
                Loc::getMessage('RS_B2BPORTAL_BS_MODULE_NOT_INSTALLED') ?: ''
            );
        }

        if (!Loader::includeModule('iblock'))
        {
            throw new SystemException(
                Loc::getMessage('RS_B2BPORTAL_BS_MODULE_IBLOCK_NOT_INSTALLED') ?: ''
            );
        }

        if (!Loader::includeModule('catalog'))
        {
            throw new SystemException(
                Loc::getMessage('RS_B2BPORTAL_BS_MODULE_CATALOG_NOT_INSTALLED') ?: ''
            );
        }
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        $arParams = parent::onPrepareComponentParams($arParams);

        if (empty($arParams['PROP_CODE']))
            $arParams['PROP_CODE'] = self::DEFAULT_PROP_CODE;

        if (empty($arParams['OFFERS_PROP_CODE']))
            $arParams['OFFERS_PROP_CODE'] = self::DEFAULT_PROP_CODE;

        $this->iblockId = (int) $arParams['IBLOCK_ID'];
        $this->offersIblockId = (int) $this->getOffersIblockId();

        if (Loader::includeModule('iblock') && PropertyFeature::isEnabledFeatures())
        {
            $arParams['PROP_CODE'] = PropertyFeature::getFirstArticlePropertyCode(
                $this->iblockId,
                ['CODE' => 'Y']
            );

            if ($this->offersIblockId)
            {
                $arParams['OFFERS_PROP_CODE'] = PropertyFeature::getFirstArticlePropertyCode(
                    $this->offersIblockId,
                    ['CODE' => 'Y']
                );
            }
        }

        return $arParams;
    }

    public function checkAction(array $codes): array
    {

        if (count($codes) == 0)
        {
            return [];
        }

        $arFoundItems = [];
        $products = $this->getProductsByCodes($codes);

        foreach($products as $arItem)
        {
            $arFoundItems[] = $arItem['CODE'];
        }

        return $arFoundItems;
    }

    public function getMeasureRatio(int $productId): float
    {
        $ratios = \Bitrix\Catalog\MeasureRatioTable::getCurrentRatio($productId);
        return is_array($ratios) ? $ratios[$productId] : 1;
    }

    /**
     * @param int $productId
     * @param int|float|null $quantity
     *
     * @return \Bitrix\Main\Result
     */
    public function addtobasket(int $productId, $quantity = null): \Bitrix\Main\Result
    {
        if (is_null($quantity))
        {
            $arRatio = \Bitrix\Catalog\MeasureRatioTable::getCurrentRatio($productId);
            $quantity = is_array($arRatio) ? $arRatio[$productId] : 1;
        }

        $product = [
            'PRODUCT_ID' => $productId,
            'QUANTITY' => $quantity
        ];

        if (PropertyCatalogFeature::isEnabledFeatures())
        {
            $iterator = \Bitrix\Catalog\ProductTable::getList([
                'select' => ['ID', 'TYPE'],
                'filter' => ['=ID' => $productId]
            ]);

            if ($productRow = $iterator->fetch())
            {
                if ($productRow['TYPE'] == \Bitrix\Catalog\ProductTable::TYPE_OFFER)
                {
                    $iblockId = (int)\CIBlockElement::GetIBlockByID($productId);
                    $catalog = \CCatalogSku::GetInfoByIBlock($iblockId);

                    $basketPropertyCodes = PropertyCatalogFeature::getBasketPropertyCodes(
                        $iblockId,
                        ['CODE' => 'Y']
                    );

                    $productProperties = \CIBlockPriceTools::GetOfferProperties(
                        $productId,
                        $catalog['PRODUCT_IBLOCK_ID'],
                        $basketPropertyCodes,
                        ""
                    );

                    if ($productProperties)
                        $product['PROPS'] = $productProperties;
                }
            }
        }

        $basketResult = \Bitrix\Catalog\Product\Basket::addProduct($product);

        return $basketResult;
    }

    /**
     * @param int $productId
     * @param int|float $quantity
     *
     * @return \Bitrix\Main\Result
     */
    protected function addProductToBasket(int $productId, $quantity): \Bitrix\Main\Result
    {
        $productData = [
            'PRODUCT_ID' => $productId,
            'QUANTITY' => $quantity
        ];

        return \Bitrix\Catalog\Product\Basket::addProduct($productData);
    }

    /**
     * @return int|false
     */
    protected function getOffersIblockId()
    {
        if (Loader::includeModule('catalog'))
        {
            $iterator = \Bitrix\Catalog\CatalogIblockTable::getList(array(
                'select' => array('IBLOCK_ID'),
                'filter' => array('=PRODUCT_IBLOCK_ID' => $this->iblockId)
            ));

            while ($row = $iterator->fetch())
            {
                return $row['IBLOCK_ID'];
            }
        }

        return false;
    }

    /**
     * @param array $codes
     *
     * @return array
     */
    protected function getProductsByCodes(array $codes): array
    {
        $products = [];

        $codes = array_map('trim', $codes);
        if (!$codes)
            return $products;

        if ($this->offersIblockId && !empty($this->arParams['OFFERS_PROP_CODE']))
        {
            $arFilter = ['LOGIC' => 'OR'];
            $arFilter[] = [
                '=IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                '=PROPERTY_' . $this->arParams['PROP_CODE'] => $codes,
                '=CATALOG_TYPE' => \Bitrix\Catalog\ProductTable::TYPE_PRODUCT
            ];
            $arFilter[] = [
                '=IBLOCK_ID' => $this->offersIblockId,
                '=PROPERTY_' . $this->arParams['PROP_CODE'] => $codes,
                '=CATALOG_TYPE' => \Bitrix\Catalog\ProductTable::TYPE_OFFER
            ];
        }
        else
        {
            $arFilter = [
                '=IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                '=PROPERTY_' . $this->arParams['PROP_CODE'] => $codes
            ];
        }

        $productIterator = \CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            $arFilter,
            false,
            false,
            ['ID', 'NAME', 'MEASURE', 'PROPERTY_' . $this->arParams['PROP_CODE']]
        );

        while ($product = $productIterator->GetNext())
        {
            $id = (int) $product['ID'];

            $products[$id] = [
                'ID' => $id,
                'NAME' => $product['NAME'],
                'MEASURE' => $product['MEASURE'],
                'CODE' => $product['PROPERTY_' . mb_strtoupper($this->arParams['PROP_CODE']) . '_VALUE']
            ];
        }

        return $products;
    }

    /**
     * returns an array of measures as id => name
     *
     * @return array
     */
    protected function getMeasureNames(): array
    {
        $names = [];

        $iterator = \CCatalogMeasure::getList(
            ['IS_DEFAULT' => 'DESC'],
            [],
            false,
            false,
            ['ID', 'SYMBOL_RUS']
        );

        while ($measure = $iterator->fetch())
        {
            $names[$measure['ID']] = $measure['SYMBOL_RUS'];
        }

        return $names;
    }

    /**
     * returns an array of ratios as productId => ratio
     *
     * @param $productIds
     *
     * @return array
     */
    protected function getProductsRatios(array $productIds): array
    {
        if (empty($productIds))
        {
            return [];
        }

        $ratios = array_fill_keys($productIds, 1);

        $iterator = \Bitrix\Catalog\MeasureRatioTable::getList([
            'select' => ['ID', 'RATIO', 'IS_DEFAULT', 'PRODUCT_ID'],
            'filter' => ['@PRODUCT_ID' => $productIds],
            'order' => ['PRODUCT_ID' => 'ASC']
        ]);

        while ($row = $iterator->fetch())
        {
            $ratio = ((float)$row['RATIO'] > (int)$row['RATIO'] ? (float)$row['RATIO'] : (int)$row['RATIO']);
            if ($ratio > CATALOG_VALUE_EPSILON)
            {

                $id = (int) $row['PRODUCT_ID'];
                $ratios[$id] = array();
                $ratios[$id][$row['ID']] = $row;
            }
        }

        return $ratios;
    }

    protected function checkExtensions(string $fileExtension): bool
    {
        if (!in_array($fileExtension, ['csv', 'xlsx', 'ods']))
        {
            $this->errorCollection[] = new Error(Loc::getMessage('RS_BP_BI_PRODUCT_INVALID_FILE_FORMAT') ?: '');
            //throw new \Exception('Invalid file format. Supported formats: csv, xlsx, ods.');

            return false;
        }

        return true;
    }

    /**
     * Download the file from the request and returns the path to it or false.
     *
     * @return string|false
     */
    protected function loadFileFromRequest()
    {
        $documentRoot = \Bitrix\Main\Application::getDocumentRoot();

        /** @var array */
        $uploadedFile = $this->request->getFile('file');

        $uploadDir = $documentRoot . '/upload/';
        $fileName = pathinfo($uploadedFile['name'], PATHINFO_FILENAME);
        $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . md5($fileName) . '.' . $fileExtension;

        if ($this->checkExtensions($fileExtension))
        {
            if (is_uploaded_file($uploadedFile['tmp_name']))
            {
                $r = move_uploaded_file($uploadedFile['tmp_name'], $filePath);

                if ($r)
                {
                    return $filePath;
                }
            }
        }

        return false;
    }

    /**
     * Download file by reference and returns the path to it or false/
     *
     * @param string $path
     * @return string|false
     */
    protected function loadFileByPath(string $path)
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

        if (preg_match('`^https?://docs.google.com/spreadsheets/.*output=(csv|xlsx|ods)$`', $path, $matches))
        {
            $fileExtension = $matches[1];
            $fileName = $this->randString(11) . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;
        }
        else
        {
            $fileName = pathinfo($path, PATHINFO_BASENAME);
            $filePath = $uploadDir . $fileName;
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        }

        if ($this->checkExtensions($fileExtension))
        {
            $r = $this->httpClient->download($path, $filePath);

            if ($r)
            {
                return $filePath;
            }
        }


        return false;
    }

    /**
     * returns an array of codes with the status of add to basket or false if data is empty
     *
     * @param array $data
     *
     * @return array|false
     */
    public function addtobasketAction(array $data)
    {

        if (count($data) === 0)
        {
            return false;
        }

        $productCodes = array_keys($data);
        $products = $this->getProductsByCodes($productCodes);

        $result = array_fill_keys($productCodes, [
            'isSuccess' => false,
            'message' => Loc::getMessage('RS_BP_BI_PRODUCT_NOT_FOUND', [
                '#CODE#' => ''
            ])
        ]);

        if (count($products) > 0)
        {
            $measureNames = $this->getMeasureNames();
            $defaultMeasureName = current($measureNames);
            $ratios = $this->getProductsRatios(array_keys($products));

            foreach ($products as $product)
            {
                $id = $product['ID'];
                $code = $product['CODE'];
                $measure = $product['MEASURE'];
                $ratio = isset($ratios[$id]) ? $ratios[$id] : 1;
                $quantity = isset($data[$code]) && $data[$code] > 0 ? $data[$code] : 1;



                $basketResult = $this->addProductToBasket($id, /*$ratio **/ $quantity);


                if ($basketResult->isSuccess())
                {
                    $result[$code] = [
                        'isSuccess' => true,
                        'message' => Loc::getMessage('RS_BP_BI_ADDTOBASKET_SUCCESS', [
                            '#CODE#' => $code,
                            '#NAME#' => $product['NAME'],
                            '#QUANTITY#' => $quantity,
                            '#MEASURE_NAME#' => isset($measureNames[$measure]) ? $measureNames[$measure] : $defaultMeasureName
                        ])
                    ];
                }
                else
                {
                    $result[$code] = [
                        'isSuccess' => false,
                        'message' => Loc::getMessage('RS_BP_BI_ADDTOBASKET_ERROR', [
                            '#CODE#' => $code,
                            '#ERROR#' => implode('; ', $basketResult->getErrorMessages())
                        ])
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * action on file parsing. Returns an array of rows.
     *
     * @param string $path
     * @return array
     */
    public function parseFileAction(?string $path = null): array
    {
        /** @var string */
        $filePath = is_null($path) ? $this->loadFileFromRequest() : $this->loadFileByPath($path);

        if (file_exists($filePath))
        {
            try
            {
                $this->reader->readFile($filePath);
            }
            catch(\Redsign\B2BPortal\Spreadsheet\Exception $ex)
            {
                $this->errorCollection[] = new Error(Loc::getMessage('RS_BP_BI_PRODUCT_READ_FILE_ERROR') ?: '');
            }

            if (!$this->hasErrors())
            {
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                if ($fileExtension != 'csv')
                {
                    $this->reader->setInputEncoding('UTF-8');
                }

                $activeSheetIndex = $this->reader->getActiveSheetIndex();
                $rows = $this->reader->getSheetRows($activeSheetIndex);

                $this->reader->close();

                unlink($filePath);

                return $rows;
            }
        }


        return [];
    }

    public function executeComponent(): void
    {
        try
        {
            $this->setFrameMode(false);
            $this->includeComponentTemplate();
        }
        catch(SystemException $e)
        {
            \ShowError($e->getMessage());
        }
    }
}
