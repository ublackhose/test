<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;
use Bitrix\Sale\Fuser;
use Bitrix\Main\Config\Option;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var \Redsign\Component\B2BPortal\BalanceList $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}


Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");


if ($_REQUEST['ID']) {
    $price = null;
    $sum_paid = null;
    $balance = null;
    $pdz = null;
    $dz = null;
    $arOrder = array();
    $inn = null;
    $userId = $USER->GetID();
    foreach ($arResult['ITEMS'] as $item) {
        if ($item['ID'] == $_REQUEST['ID']) {
            $inn = $item['TAXPAYER_CODE'];
            $balance = $item['VALUE'];
            //Пользователь
            $rsUser = CUser::GetByID($userId);
            $arUser = $rsUser->Fetch();

            $arFilter = array(
                "USER_ID" => $USER->GetID(),
            );

            $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);

            while ($ar_sales = $db_sales->Fetch()) {
                $order = \Bitrix\Sale\Order::load($ar_sales['ID']);
                $propertyCollection = $order->getPropertyCollection();
                $arProp = $propertyCollection->getArray();
                $check = false;
                foreach ($arProp['properties'] as $property) {
                    if ($property['ID'] == 10) {
                        if ($property['VALUE'][0] == $item['TAXPAYER_CODE']) {
                            $check = true;
                        }
                    }
                }


                if ($check) {
                    $price += $ar_sales['PRICE'];
                    $sum_paid += $ar_sales['SUM_PAID'];
                    $arOrder[] = $ar_sales;
                }
            }
        }
    }


    $db_sales = CSaleOrderUserProps::GetList(
        array("DATE_UPDATE" => "DESC"),
        array("USER_ID" => $USER->GetID())
    );


    while ($ar_sales = $db_sales->Fetch()) {
        $db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), array("USER_PROPS_ID" => $ar_sales['ID'])
        );
        $check = false;
        while ($arPropVals = $db_propVals->Fetch()) {
            if ($arPropVals['PROP_CODE'] == 'INN') {
                if ($arPropVals['VALUE'] == $inn) {
                    $check = true;
                }
            }
            $userProfileOrder[$arPropVals['PROP_CODE']] = $arPropVals;
        }
        if ($check) {
            break;
        }
    }


    ?>
    <div class="row">
        <div class="col-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label"><h3 class="kt-portlet__head-title">Баланс
                                <?if($userProfileOrder['DZ']['VALUE']== 0 && $userProfileOrder['PDZ']['VALUE']){?>
                            <span
                                    class="kt-badge kt-badge--inline kt-badge--pill
                                    kt-badge--primary ml-2 align-middle">Нет задолженностей</span>
                            <?}else{?>
                                    <span
                                            class="kt-badge kt-badge--inline kt-badge--pill
                                    kt-badge--danger ml-2 align-middle">Есть задолженности (ПДЗ/ДЗ)</span>
                            <?}?>
                        </h3></div>
                    <div class="kt-portlet__head-toolbar">

                    </div>
                </div>
                <div class="collapse show" id>
                    <div class="kt-portlet__body">
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">
                                <h6>Ф.И.О.:</h6>
                                <p class="mb-0"><?= $arUser['NAME'] . " " . $arUser['LAST_NAME'] ?></p>
                            </div>

<!---->
<!--                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">-->
<!--                                <h6>Текущий статус</h6>-->
<!--                                <p class="mb-0">-->
<!--                                    <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary-->
<!--                                    ml-2 align-middle">-->
<!--                                        Всё норм</span>-->
<!--                                </p>-->
<!--                            </div>-->


                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">
                                <h6>Осталось к оплате по заказам</h6>
                                <p class="mb-0"><?= $price ?> ₽
                                </p>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">
                                <h6>Оплачено по заказам</h6>
                                <p class="mb-0"><?= $sum_paid ?> ₽</p>
                            </div>

<!--                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">-->
<!--                                <h6>Баланс</h6>-->
<!--                                <p class="mb-0">--><?//= $balance ?><!-- ₽</p>-->
<!--                            </div>-->

                            <div class="col-12 col-md-6 col-lg-6 col-xl-2">
                                <h6>ИНН</h6>
                                <p class="mb-0"><?= $inn ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="kt-portlet kt-portlet--draggable" data-block="list" data-content="contract_detail_block_list">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Договоры</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#contract_detail_block_list" class="btn btn-default btn-bold btn-upper btn-font-sm"
                   data-toggle="collapse" aria-expanded="true">
                    <i class="fa fa-angle-down pr-0"></i>
                </a></div>
        </div>
        <div class="collapse show" id="contract_detail_block_list" style>
            <div class="kt-portlet__body">


                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата документа</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th class="text-right">Скачать</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php


                    foreach ($arOrder as $order) {
                        $rsDocuments = CIBlockElement::GetList(
                            ['SORT' => 'ASC'],
                            [
                                'IBLOCK_ID' => 3,
                                'PROPERTY_ORDER_ID' => $order['ID'],
                                'PROPERTY_OWNER_ID' => $userId
                            ],
                            false,
                            false,
                            ['ID', 'ACTIVE_FROM', 'NAME', 'SORT', 'PROPERTY_FILE', 'PROPERTY_TYPE', 'PROPERTY_GEN_TYPE']
                        );

                        while ($document = $rsDocuments->GetNext()) {
                            if (!empty($document['PROPERTY_GEN_TYPE_VALUE'])) {
                                $filePath = CComponentEngine::MakePathFromTemplate($genDocsPath, [
                                    'SITE_DIR' => SITE_DIR,
                                    'DOCUMENT_ID' => $document['ID']
                                ]);
                            } else {
                                $filePath = CFile::GetPath($document['PROPERTY_FILE_VALUE']);
                            }

                            $documents[] = [
                                'DATE' => $document['ACTIVE_FROM'] ?? '',
                                'ID' => $document['ID'],
                                'NAME' => $document['NAME'],
                                'TYPE' => $document['PROPERTY_TYPE_ENUM_ID'],
                                'FILE_PATH' => $filePath
                            ];
                        }
                        unset($document, $rsDocument);


                        if (isset($documents) && count($documents) > 0) {
                            $typeIds = array_unique(
                                array_map(function ($document) {
                                    return $document['TYPE'];
                                }, $documents)
                            );

                            $typeValues = array_fill_keys(
                                $typeIds,
                                []
                            );

                            $rsTypeValues = CIBlockPropertyEnum::GetList(
                                [],
                                [
                                    'ID' => $typeIds,
                                    'CODE' => 'TYPE',
                                    'IBLOCK_ID' => $arParams['DOCUMENTS_IBLOCK_ID'],
                                ]
                            );

                            while ($value = $rsTypeValues->GetNext()) {
                                $typeValues[$value['ID']] = $value;
                            }
                            unset($value, $rsTypeValues, $typeIds);

                            foreach ($documents as &$document) {
                                $document['TYPE'] = $typeValues[$document['TYPE']];
                            }
                            unset($document, $typeValues);
                        }

                        $arResult['DOCUMENTS'] = $documents;
                        unset($documents);

                        ?>

                        <?
                        foreach ($arResult['DOCUMENTS'] as $document) {
                            if ($document ['TYPE']['ID'] != 1) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if (!empty($document['DATE'])): ?>
                                        <?= $document['DATE'] ?>
                                    <?php
                                    endif; ?>
                                </td>
                                <td><?= $document['NAME'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($document['TYPE'])): ?>
                                        <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--<?= $document['TYPE']['XML_ID'] ?>">
							<?= $document['TYPE']['VALUE'] ?>
						</span>
                                    <?php
                                    endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php
                                    if (!empty($document['FILE_PATH']) > 0): ?>
                                        <a href="<?= $document['FILE_PATH'] ?>" class="btn btn-primary btn-sm"
                                           target="_blank">
                                            <i class="flaticon2-download-2 pr-0"></i>
                                        </a>
                                    <?php
                                    endif; ?>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="kt-portlet kt-portlet--draggable" data-block="list" data-content="mutual_settlements_detail_block_list">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">Взаиморасчеты</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#mutual_settlements_detail_block_list" class="btn btn-default btn-bold btn-upper btn-font-sm"
                   data-toggle="collapse" aria-expanded="true">
                    <i class="fa fa-angle-down pr-0"></i>
                </a></div>
        </div>
        <div class="collapse show" id="mutual_settlements_detail_block_list" style>
            <div class="kt-portlet__body">
                <div class="vgt-wrap">
                    <table class="vgt-table bordered ">

                        <thead>
                        <tr>
                            <th class="text-nowrap vgt-left-align " style="min-width: auto;width: auto;">
                                <span>ID заказа</span>
                            </th>
                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>
                                    Дата заказа
                                </span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Cумма</span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Оплаченная сумма</span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Осталось к оплате</span>
                            </th>
                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;font-size: 14px;">
                                <span>
                                    Оплата
                                </span>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arOrder as $order) {
                            ?>
                            <tr class>

                                <td class="vgt-left-align">
                                    <a href="/personal/orders/<?= $order['ID'] ?>/"><?= $order['ID'] ?></a>
                                    <div class="d-block">
                                    </div>
                                </td>

                                <td class="vgt-left-align">
                                    <a href="/personal/orders/<?= $order['ID'] ?>/">2<?= $order['DATE_INSERT'] ?></a>
                                </td>

                                <td class="vgt-left-align">
                                    <div><?= $order['PRICE'] ?> ₽</div>
                                </td>

                                <td class="vgt-left-align">
                                    <div><?= $order['SUM_PAID'] ?> ₽</div>
                                </td>

                                <td class="vgt-left-align">
                                    <div><?= ($order['PRICE'] - $order['SUM_PAID']) ?> ₽</div>
                                </td>
                                <td class="vgt-left-align">
                                    <span><?= $order['PAYED'] == 'N' ?  ($order['SUM_PAID'])!=0 ?"Оплачен частично":"Не оплачен" :"Оплачен" ?></span>
                                </td>
                            </tr>


                            <?
                        }
                        ?>
                        </tbody>
                    </table>

                    <div style="padding: 0px 25px;color:#253590; " class="mt-4">
                        <h6>Задолженгность по отгруженным товарам(дебиторская задолженность)</h6>
                        <div class="d-block">
                            <?= $userProfileOrder['DZ']['VALUE'] ?>
                        </div>
                        <h6>Просроченная дебиторская задолженность</h6>
                        <div class="d-block">
                            <?= $userProfileOrder['PDZ']['VALUE'] ?>
                        </div>

                        <h6>Кредитный лемит</h6>
                        <div class="d-block">
                            Не реализовано
                        </div>
                        <h6>Остаток кредитного лимита</h6>
                        <div class="d-block">
                            Не реализовано
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="kt-portlet kt-portlet--draggable" data-block="list" data-content="schedule_detail_block_list">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">График оплат</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#schedule_detail_block_list" class="btn btn-default btn-bold btn-upper btn-font-sm"
                   data-toggle="collapse" aria-expanded="true">
                    <i class="fa fa-angle-down pr-0"></i>
                </a></div>
        </div>
        <div class="collapse show" id="schedule_detail_block_list" style>
            <div class="kt-portlet__body">
                <div class="vgt-wrap">
                    <table class="vgt-table bordered ">

                        <thead>
                        <tr>
                            <th class="text-nowrap vgt-left-align " style="min-width: auto;width: auto;">
                                <span>Договор</span>
                            </th>
                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>
                                    Дата реализации
                                </span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Номер УПД</span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Сумма долга</span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>Сумма реализации</span>
                            </th>
                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>
                                    Дата оплаты
                                </span>
                            </th>

                            <th class="text-nowrap vgt-left-align" style="min-width: auto;width: auto;">
                                <span>
                                    Дней просрочки
                                </span>
                            </th>


                        </tr>
                        </thead>
                        <tbody>

                        <?
                        foreach ($arOrder as $order) { ?>
                            <?
                            $arr[] = $order['ID'];
                            $orderad = \Bitrix\Sale\Order::load($order['ID']);
                            $propertyCollection = $orderad->getPropertyCollection();
                            $property = $propertyCollection->getItemByOrderPropertyCode("NUMBER_UPD");
                            $num_cur = $property->getValue();
                            $property = $propertyCollection->getItemByOrderPropertyCode("TREATY");
                            $treaty =$property->getValue();

                            $property = $propertyCollection->getItemByOrderPropertyCode("DAYS_OVERDUE");
                            $days_overdue =$property->getValue();

                            $rsDocuments = CIBlockElement::GetList(
                                ['SORT' => 'ASC'],
                                [
                                    'IBLOCK_ID' => 3,
                                    'PROPERTY_ORDER_ID' => $order['ID'],
                                    'PROPERTY_OWNER_ID' => $userId
                                ],
                                false,
                                false,
                                [
                                    'ID',
                                    'ACTIVE_FROM',
                                    'NAME',
                                    'SORT',
                                    'PROPERTY_FILE',
                                    'PROPERTY_TYPE',
                                    'PROPERTY_GEN_TYPE'
                                ]
                            );
                            $genDocsPath = Option::get('redsign.b2bportal', 'generate_docs_path', '', SITE_ID);
                            while ($document = $rsDocuments->GetNext()) {

                                if (!empty($document['PROPERTY_GEN_TYPE_VALUE'])) {
                                    $filePath = CComponentEngine::MakePathFromTemplate($genDocsPath, [
                                        'SITE_DIR' => SITE_DIR,
                                        'DOCUMENT_ID' => $document['ID']
                                    ]);
                                } else {
                                    $filePath = CFile::GetPath($document['PROPERTY_FILE_VALUE']);
                                }



                                $documents[] = [
                                    'DATE' => $document['ACTIVE_FROM'] ?? '',
                                    'ID' => $document['ID'],
                                    'NAME' => $document['NAME'],
                                    'TYPE' => $document['PROPERTY_TYPE_ENUM_ID'],
                                    'FILE_PATH' => $filePath
                                ];
                            }
                            unset($document, $rsDocument);


//                            echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//                            print_r($documents);
//                            echo "</pre>";

                            if (isset($documents) && count($documents) > 0) {
                                $typeIds = array_unique(
                                    array_map(function ($document) {
                                        return $document['TYPE'];
                                    }, $documents)
                                );

                                $typeValues = array_fill_keys(
                                    $typeIds,
                                    []
                                );

                                $rsTypeValues = CIBlockPropertyEnum::GetList(
                                    [],
                                    [
                                        'ID' => $typeIds,
                                        'CODE' => 'TYPE',
                                        'IBLOCK_ID' => $arParams['DOCUMENTS_IBLOCK_ID'],
                                    ]
                                );

                                while ($value = $rsTypeValues->GetNext()) {
                                    $typeValues[$value['ID']] = $value;
                                }
                                unset($value, $rsTypeValues, $typeIds);

                                foreach ($documents as &$document) {
                                    $document['TYPE'] = $typeValues[$document['TYPE']];
                                }
                                unset($document, $typeValues);
                            }

                            $arResult['DOCUMENTS'] = $documents;
                            unset($documents);



                            ?>

                            <tr class>
                                <td class="vgt-left-align">
                                    <a href="/personal/orders/<?= $order['ID'] ?>/"><?= $treaty ?></a>
                                    <div class="d-block">
                                    </div>
                                </td>

                                <td class="vgt-left-align">
                                    <a href="/personal/orders/<?= $order['ID'] ?>/"><?= $order['DATE_INSERT'] ?></a>
                                </td>

                                <td class="vgt-left-align">
                                    <div>
                                        <?= $num_cur ?>
                                    </div>
                                </td>

                                <td class="vgt-left-align">
                                    <div><?= $order['SUM_PAID'] ?> ₽</div>
                                </td>

                                <td class="vgt-left-align">
                                    <div><?= ($order['PRICE'] - $order['SUM_PAID']) ?> ₽</div>
                                </td>
                                <td class="vgt-left-align">
                                    <span><?= $order['PAYED'] == 'N' ? "Не оплачен" : date ( 'd.m.Y' ,strtotime($order['DATE_PAYED'])) ?></span>
                                </td>

                                <td class="vgt-left-align">
                                    <span><?=$days_overdue?></span>
                                </td>
                                <td style="position: relative;left: -50%;top: 27px;    z-index: 1000;">
                                <button style="position: relative; background: none; border: none; color: #646c9a"
                                        data-toggle="collapse" data-target="#collapseExample_<?= $order['ID'] ?>"
                                        aria-expanded="false" aria-controls="collapseExample">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 13L12 16M12 16L15 13M12 16V8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                              stroke="#646c9a" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                </td>
                            </tr>


                            <?
                            foreach ($arResult['DOCUMENTS'] as $document) {
                                if ($document ['TYPE']['ID'] != 4) {
                                    continue;
                                }


                                ?>



                                <tr class="collapse" style="      border-top: 2px solid rgb(188, 190, 197);
    border-bottom: 2px solid rgb(188, 190, 197);background: #f0f8ff" id="collapseExample_<?= $order['ID'] ?>">
                                    <td>
                                        <?php
                                        if (!empty($document['DATE'])): ?>
                                            <?= $document['DATE'] ?>
                                        <?php
                                        endif; ?>
                                    </td>
                                    <td><?= $document['NAME'] ?></td>
                                    <td>
                                        <?php
                                        if (!empty($document['TYPE'])): ?>
                                            <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--<?= $document['TYPE']['XML_ID'] ?>">
							<?= $document['TYPE']['VALUE'] ?>
						</span>
                                        <?php
                                        endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                        if (!empty($document['FILE_PATH']) > 0): ?>
                                            <a href="<?= $document['FILE_PATH'] ?>" class="btn btn-primary btn-sm"
                                               target="_blank">
                                                <i class="flaticon2-download-2 pr-0"></i>
                                            </a>
                                        <?php
                                        endif; ?>
                                    </td>
                                    <td></td><td></td><td></td><td></td>
                                </tr>




                                <?
                            }
                            ?>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href='/exe/?export=xlsx&orders=<?=json_encode($arr)?>;' class="btn btn-outline-primary">
                            Сохранить в xls
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet kt-portlet--draggable" data-block="list" data-content="acts_detail_block_list">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title"> Акты сверки</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#acts_detail_block_list" class="btn btn-default btn-bold btn-upper btn-font-sm"
                   data-toggle="collapse" aria-expanded="true">
                    <i class="fa fa-angle-down pr-0"></i>
                </a>
            </div>
        </div>
        <div class="collapse show" id="acts_detail_block_list" style>
            <div class="kt-portlet__body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата запроса</th>
                        <th>Наименование договора поставки</th>
                        <th> Период (запрашиваемый)</th>
                        <th class="text-right">Скачать</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

//                    if($order['ID']){

//                    $order = \Bitrix\Sale\Order::load($order['ID']);
//
//                    $property = $propertyCollection->getItemByOrderPropertyCode("DATE_DELIVERY");
//                    $date_cur = $property->getValue();



                    foreach ($arOrder as $order) {
                        $rsDocuments = CIBlockElement::GetList(
                            ['SORT' => 'ASC'],
                            [
                                'IBLOCK_ID' => 3,
                                'PROPERTY_ORDER_ID' => $order['ID'],
                                'PROPERTY_OWNER_ID' => $userId
                            ],
                            false,
                            false,
                            ['ID', 'ACTIVE_FROM', 'NAME', 'SORT', 'PROPERTY_FILE', 'PROPERTY_TYPE', 'PROPERTY_GEN_TYPE']
                        );

                        while ($document = $rsDocuments->GetNext()) {
                            if (!empty($document['PROPERTY_GEN_TYPE_VALUE'])) {
                                $filePath = CComponentEngine::MakePathFromTemplate($genDocsPath, [
                                    'SITE_DIR' => SITE_DIR,
                                    'DOCUMENT_ID' => $document['ID']
                                ]);
                            } else {
                                $filePath = CFile::GetPath($document['PROPERTY_FILE_VALUE']);
                            }

                            $documents[] = [
                                'DATE' => $document['ACTIVE_FROM'] ?? '',
                                'ID' => $document['ID'],
                                'NAME' => $document['NAME'],
                                'TYPE' => $document['PROPERTY_TYPE_ENUM_ID'],
                                'FILE_PATH' => $filePath
                            ];
                        }


                        unset($document, $rsDocument);


                        if (isset($documents) && count($documents) > 0) {
                            $typeIds = array_unique(
                                array_map(function ($document) {
                                    return $document['TYPE'];
                                }, $documents)
                            );

                            $typeValues = array_fill_keys(
                                $typeIds,
                                []
                            );

                            $rsTypeValues = CIBlockPropertyEnum::GetList(
                                [],
                                [
                                    'ID' => $typeIds,
                                    'CODE' => 'TYPE',
                                    'IBLOCK_ID' => $arParams['DOCUMENTS_IBLOCK_ID'],
                                ]
                            );

                            while ($value = $rsTypeValues->GetNext()) {
                                $typeValues[$value['ID']] = $value;
                            }
                            unset($value, $rsTypeValues, $typeIds);

                            foreach ($documents as &$document) {
                                $document['TYPE'] = $typeValues[$document['TYPE']];
                            }
                            unset($document, $typeValues);
                        }


                        $arResult['DOCUMENTS'] = $documents;
                        unset($documents);

                        ?>

                        <?
                        foreach ($arResult['DOCUMENTS'] as $document) {
                            if ($document ['TYPE']['ID'] != 303 ) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if (!empty($document['DATE'])): ?>
                                        <?= $document['DATE'] ?>
                                    <?php
                                    endif; ?>
                                </td>
                                <td><?= $document['NAME'] ?></td>
                                <td>
                                    <?php
                                    if (!empty($document['TYPE'])): ?>
                                        <span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--<?= $document['TYPE']['XML_ID'] ?>">
							<?= $document['TYPE']['VALUE'] ?>
						</span>
                                    <?php
                                    endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php
                                    if (!empty($document['FILE_PATH']) > 0): ?>
                                        <a href="<?= $document['FILE_PATH'] ?>" class="btn btn-primary btn-sm"
                                           target="_blank">
                                            <i class="flaticon2-download-2 pr-0"></i>
                                        </a>
                                    <?php
                                    endif; ?>
                                </td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>


    <?php
} else {
    if ($arResult['ERRORS']) {
        if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS])) {
            $APPLICATION->AuthForm(Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_NEED_AUTH'), false, false, 'N', false);
        } else {
            echo '<div class="alert alert-danger">' .
                implode('<br>', $arResult['ERRORS']) .
                '</div>';
        }
    } else {
        $this->addExternalJS($templateFolder . '/js/component.js');

        $pagination = $arResult['NAV_RESULT'];
        $pagination['navPageValuePrefix'] = 'page-';
        $templateData['PAGINATION'] = $pagination;

        $sBlockId = 'balanceListTable' . $this->randString(5);
        $portlet = new Portlet();

        $body = $portlet->body(function () use ($sBlockId) {
            echo '<div id="' . $sBlockId . '_table"></div>';
        });

        $body->addModifier('fit');

        ?>
        <div id="<?= $sBlockId ?>_block"><?
            $portlet->render();
            ?></div><?

        //////////////////////////////////////////

        $arHeader = [];

        $arHeader[] = [
            'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_ID'),
            'field' => 'ID',
            'sortable' => false,
            'html' => false,
        ];

        // $arHeader[] = [
        // 	'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_PROFILE_NAME'),
        // 	'field' => 'PROFILE_NAME',
        // 	'sortable' => true,
        // 	'html' => false,
        // ];

        $arHeader[] = [
            'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_COMPANY_NAME'),
            'field' => 'NAME',
            'detail_page_url' => '/',
            'sortable' => true,
            'html' => false,
        ];

        $arHeader[] = [
            'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_TAXPAYER_CODE'),
            'field' => 'TAXPAYER_CODE',
            'sortable' => true,
            'html' => false,
        ];

//        $arHeader[] = [
//            'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_BALANCE'),
//            'field' => 'VALUE',
//            'sortable' => true,
//            'html' => false,
//        ];

        $arHeader[] = [
            'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_DATE_UPDATE'),
            'field' => 'DATE_UPDATE',
            'sortable' => true,
            'html' => false,
        ];

        // $arHeader[] = [
        // 	'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_ACTIONS'),
        // 	'field' => 'actions',
        // 	'sortable' => false,
        // 	'html' => false,
        // ];


        $arItems = [];


        if (!empty($arResult['ITEMS'])) {
            foreach ($arResult['ITEMS'] as $item) {
                $item['detail_page_url'] = "/";
                $arItemRow = [
                    'ID' => $item['ID'],
                    'NAME' => $item['COMPANY_NAME'],
                    'TAXPAYER_CODE' => $item['TAXPAYER_CODE'],
                    'DATE_UPDATE' => $item['DATE_UPDATE'] ? $item['DATE_UPDATE']->format('d.m.Y H:i:s') : '',
                    'VALUE' => $item['VALUE_FORMAT'] ? $item['VALUE_FORMAT'] : $item['VALUE'],
                    'detail_page_url' => '/personal/balance/?ID=' . $item['ID'] . '',
                    // 'actions' => '',
                ];

                $arItems[] = $arItemRow;
            }
        }

        $templateData['ITEMS_ROWS'] = $arItems;

        $arParams['ELEMENT_SORT_FIELD'] = 'ID';
        $arParams['ELEMENT_SORT_ORDER'] = 'ASC';

        ?>

        <script>
            (function () {

                <?php $messages = Loc::loadLanguageFile(__FILE__); ?>
                BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

                new BalanceListTable(
                        {
                            headers: <?=\Bitrix\Main\Web\Json::encode($arHeader)?>,
                            items: <?=\Bitrix\Main\Web\Json::encode($arItems)?>,

                            pagination: <?=\Bitrix\Main\Web\Json::encode($pagination)?>,
                        },
                        {
                            block: '<?=$sBlockId?>_block',
                            table: '<?=$sBlockId?>_table',
                            siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
                            pagination: {
                                perPageDropdown: <?=\Bitrix\Main\Web\Json::encode(
                                    $arParams['CATALOG_SORTER']['PERPAGE_DROPDOWN']
                                )?>,
                            },
                            sorting: {
                                initialSortBy: {
                                    field: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_FIELD'])?>',
                                    type: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_ORDER'])?>',
                                }
                            },
                            arParams: <?=\Bitrix\Main\Web\Json::encode($arParams)?>
                        }
                );

            }());
        </script>
        <?php
    }
}
