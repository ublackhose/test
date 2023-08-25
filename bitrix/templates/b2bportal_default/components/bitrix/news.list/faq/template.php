<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>




<div class="widget-content">
    <div class="widget-items" data-role="items">

        <?
        foreach ($arResult["ITEMS"] as $arItem): ?>


        <?
        $this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
        );
        $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
        );
        ?>


        <div class="kt-portlet" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="collapse show" id="">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div data-v-62b00543="" class="vgt-wrap vgt-responsive-static">
                        <div class="vgt-inner-wrap">
                            <div class="vgt-responsive" style="max-height: 700px;">
                                <table class="vgt-table bordered ">
                                    <tbody>
                                    <tr class="">

                                        <td class="vgt-left-align">
                                            <div>
                                                <div data-v-62b00543="" class="d-flex align-items-center">
                                                    <div data-v-62b00543="" class="d-block">
                                                        <div data-v-62b00543="" class="mb-2">
                                                            <span data-v-62b00543=""
                                                                  class="mr-2">Вопрос:                        <?
                                                                if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                                                                    <?= $arItem["NAME"] ?>
                                                                <?
                                                                endif; ?>
                                                            </span>
                                                        </div>
                                                        <div data-v-62b00543="">
                                                            <span data-v-62b00543="" class="mr-3">Ответ:  <?
                                                                if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                                                                    <?= $arItem["PREVIEW_TEXT"]; ?>
                                                                <?
                                                                endif; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?
    endforeach; ?>

</div>
</div>






