<?php

namespace Redsign\Components;

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Sale\Basket;
use Redsign\VBasket\Core;
use Redsign\VBasket\Factory\BasketFactory;
use Redsign\VBasket\Factory\BasketItemFactory;
use Redsign\VBasket\Factory\SaleBasketFactory;
use Redsign\VBasket\Repository\SharedBasketRepository;
use Redsign\VBasket\SharedBasket;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

if (!Loader::includeModule('redsign.vbasket')) {
    ShowError(Loc::getMessage('RS_VBASKET_VSA_MODULE_NOT_INSTALLED', ['#MODULE_ID#' => 'redsign.vbasket']));
    return;
}

class VBasketSharedApply extends \CBitrixComponent implements Controllerable
{
    private SharedBasket $sharedBasket;
    private SharedBasketRepository $repository;
    private Basket $saleBasket;
    private array $storage = [];

    public function configureActions(): array
    {
        return [];
    }

    protected function listKeysSignedParameters(): array
    {
        return [];
    }

    /**
     * @param array $params
     * @return array
     */
    public function onPrepareComponentParams($params): array
    {
        $params = parent::onPrepareComponentParams($params);

        if (!isset($params['VARTIABLE_NAME'])) {
            $params['VARIABLE_NAME'] = 'hash';
        }

        return $params;
    }

    private function checkModules(): void
    {
        if (!Loader::includeModule('redsign.vbasket')) {
            throw new SystemException(
                Loc::getMessage('RS_VBASKET_SA_MODULE_NOT_INSTALL') ?: ''
            );
        }
    }

    public function init(): void
    {
        $this->repository = Core::container()->get('shared_basket_repository'); // @phpstan-ignore-line

        $this->storage = [
            'IBLOCK_ELEMENTS' => [],
        ];
    }

    private function loadBasket(): bool
    {
        /** @var string $hash */
        $hash = $this->request->get($this->arParams['VARIABLE_NAME']) ?: '';
        if ($hash) {
            $sharedBasket = $this->repository->getByHash($hash);

            if ($sharedBasket) {
                $this->sharedBasket = $sharedBasket;
                $this->saleBasket = SaleBasketFactory::createFromSharedBasket($sharedBasket);

                foreach ($sharedBasket->getProducts() as [$fieldsValues]) {
                    $productId = (int) $fieldsValues['PRODUCT_ID'];

                    if ($productId > 0) {
                        $this->storage['IBLOCK_ELEMENTS'][$productId] = [];
                    }
                }

                return true;
            }
        }

        return false;
    }

    private function loadIblockElementsData(): void
    {
        $order = ['ID' => 'ASC'];
        $filter = ['=ID' => array_keys($this->storage['IBLOCK_ELEMENTS'])];
        $select = ['ID', 'IBLOCK_ID', 'NAME', 'MEASURE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'QUANTITY'];

        $iblockElementIterator = \CIBlockElement::GetList(
            $order,
            $filter,
            false,
            false,
            $select
        );

        while ($element = $iblockElementIterator->GetNext()) {
            $this->storage['IBLOCK_ELEMENTS'][$element['ID']] = $element;
        }
    }

    public function getRows(): array
    {
        $rows = [];
        foreach ($this->saleBasket as $index => $basketItem) {
            $productId = $basketItem->getProductId();

            $catalogData = [];
            if (isset($this->storage['IBLOCK_ELEMENTS'][$productId])) {
                $catalogData = [
                    'NAME' => $this->storage['IBLOCK_ELEMENTS'][$productId]['NAME'],
                    'DETAIL_PAGE_URL' => $this->storage['IBLOCK_ELEMENTS'][$productId]['DETAIL_PAGE_URL'],
                    'AVALAIBLE_QUANTITY' => $this->storage['IBLOCK_ELEMENTS'][$productId]['QUANTITY'],
                    'PREVIEW_PICTURE' => null
                ];

                if ($this->storage['IBLOCK_ELEMENTS'][$productId]['PREVIEW_PICTURE']) {
                    $catalogData['PREVIEW_PICTURE'] = \CFile::GetPath($this->storage['IBLOCK_ELEMENTS'][$productId]['PREVIEW_PICTURE']);
                }
            } else {
                $catalogData = [
                    'NAME' => $basketItem->getField('NAME'),
                    'DETAIL_PAGE_URL' => '',
                    'QUANTITY' => null,
                    'PREVIEW_PICTURE' => null
                ];
            }

            $rows[$index] = $catalogData + [
                'PRICE' => $basketItem->getPrice(),
                'DISCOUNT' => $basketItem->getDiscountPrice(),
                'CURRENCY' => $basketItem->getCurrency(),
                'CAN_BUY' => $basketItem->canBuy(),
                'SUM_PRICE' => $basketItem->getPrice() * $basketItem->getQuantity(),
                'MEASURE' => $basketItem->getField('MEASURE_NAME'),
                'QUANTITY' => $basketItem->getQuantity()
            ];
        }

        return $rows;
    }

    private function getSummary(): array
    {
        return [
            'PRICE' => $this->saleBasket->getPrice(),
            'CURRENCY' => $this->saleBasket->getContext()['CURRENCY']
        ];
    }

    private function getBasketData(): array
    {
        return [
            'ID' => $this->sharedBasket->getId(),
            'NAME' => $this->sharedBasket->getName(),
            'COLOR' => $this->sharedBasket->getColor()
        ];
    }

    private function applyTemplateMutator(array &$result): void
    {
        if ($this->initComponentTemplate()) {
            $template = $this->getTemplate();
            $templateFolder = $template->GetFolder();

            if (!empty($templateFolder)) {
                $file = new \Bitrix\Main\IO\File(\Bitrix\Main\Application::getDocumentRoot() . $templateFolder . '/mutator.php');

                if ($file->isExists()) {
                    include($file->getPath());
                }
            }
        }
    }

    private function getResult(): array
    {
        $result = [];

        $result['BASKET_DATA'] = $this->getBasketData();
        $result['ROWS'] = $this->getRows();
        $result['SUMMARY'] = $this->getSummary();

        $this->applyTemplateMutator($result);

        return $result;
    }

    private function getAction(): string
    {
        $action = 'confirm';

        if (
            $this->arParams['NEED_CONFIRM'] !== 'Y'
            || !empty($this->request->getPost('confirm'))
        ) {
            $action = 'switch';
        }

        return $action;
    }

    private function confirmAction(): void
    {
        if (count($this->storage['IBLOCK_ELEMENTS'])) {
            $this->loadIblockElementsData();
        }

        $this->arResult = $this->getResult();
        $this->IncludeComponentTemplate();
    }

    private function switchAction(): void
    {
        $virtualBasket = BasketFactory::createFromShared($this->sharedBasket);
        $result = $virtualBasket->save();

        if ($result->isSuccess()) {
            $virtualBasketItems = BasketItemFactory::createCollectionFromShared($this->sharedBasket, $virtualBasket);
            $virtualBasketItems->save(true);

            /** @var \Redsign\VBasket\Manager $manager */
            $manager = Core::container()->get('manager');
            $manager->select($virtualBasket);

            $this->sharedBasket->setDateLastApply(new \Bitrix\Main\Type\DateTime());
            $this->sharedBasket->save();

            LocalRedirect($this->arParams['PATH_TO_CART']);
        }
    }

    private function doAction(string $action): void
    {
        switch ($action) {
            case 'confirm':
                $this->confirmAction();
                break;
            case 'switchAction':
            default:
                $this->switchAction();
        }
    }

    public function executeComponent(): void
    {
        try {
            $this->checkModules();
            $this->init();

            if ($this->loadBasket()) {
                $action = $this->getAction();
                $this->doAction($action);
            } else {
                // process 404
            }
        } catch (SystemException $e) {
            \ShowError($e->getMessage());
        }
    }
}
