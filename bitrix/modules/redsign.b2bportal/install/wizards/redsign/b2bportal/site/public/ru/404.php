<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");

$APPLICATION->SetPageProperty("off_portlet", "Y");
?>

<div class="kt-portlet">
    <div class="kt-portlet__body">

        <div class="b-404">
            <div class="b-404__in text-center">
                <div class="b-404__title kt-font-brand">404</div>
                <div class="b-404__text">Страница не найдена</div>
                <div class="b-404__link"><a class="btn btn-primary" href="<?=SITE_DIR?>">Вернуться на главную</a></div>
            </div>
        </div>

    </div>
</div>

<style>
.b-404 {
    margin-top: 70px;
    margin-bottom: 70px;
}
.b-404__title {
    font-size: 200px;
    margin-top: 50px;
    line-height: 160px;
}
.b-404__text {
    font-size: 30px;
    padding: 35px 0;
}
</style>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
