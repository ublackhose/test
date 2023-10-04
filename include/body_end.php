<div class="modal fade" id="change-profile-data-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Направить заявку на изменение реквизитов или платежных данных </h5>
                <h5 class="modal-title modal-title-success" style="display: none;">Ваша заявка на изменение данных успешно отправлена!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">?</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" method="post" action="/personal/companies/38/?clear_cache=Y&amp;_r=1325" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label class="col-12 col-md-4 text-right" for="sale-personal-profile-detail-name">
                            Название:<span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8 text-right">
                            <input class="form-control" type="text" name="NAME" maxlength="50" id="sale-personal-profile-detail-name" value="ООО (test)">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-20">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-20">
                            Направление деятельности компании:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_20" id="sppd-property-20" value="Продажа ">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-8">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-8">
                            Наименование организации:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_8" id="sppd-property-8" value="ООО (test)">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-textarea" id="spppi-property-id-9">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-9">
                            Юридический адрес:
                        </label>
                        <div class="col-12 col-md-8">
                            <textarea class="form-control" type="text" name="ORDER_PROP_9" id="sppd-property-9" rows="4" cols="40">Существует</textarea>
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-10">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-10">
                            ИНН:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_10" id="sppd-property-10" value="21412124">
                        </div>
                    </div>
                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-11">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-11">
                            КПП:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_11" id="sppd-property-11" value="124123124124">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-16">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-16">
                            Индекс:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_16" id="sppd-property-16" value="6161616">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-text" id="spppi-property-id-17">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-17">
                        Город:
                        </label>
                        <div class="col-12 col-md-8">
                            <input class="form-control" type="text" name="ORDER_PROP_17" id="sppd-property-17" value="Москва">
                        </div>
                    </div>

                    <div class="form-group row sale-personal-profile-detail-property-location" id="spppi-property-id-18">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-18">
                            Местоположение:
                            <span class="sale-personal-profile-req">*</span>
                        </label>
                        <div class="col-12 col-md-8">
                            <div class="location-block-wrapper">
                                <div id="sls-15020" class="bx-sls ">
                                    <div class="dropdown-block bx-ui-sls-input-block">
                                        <span class="dropdown-icon"></span>
                                        <input type="text" autocomplete="off" name="ORDER_PROP_18" value="2639" class="dropdown-field" placeholder="Введите название ..." style="display: none;">
                                        <div class="bx-ui-sls-container" style="margin: 0px; padding: 0px; border: none; position: relative;">
                                            <input type="text" disabled="disabled" autocomplete="off" class="bx-ui-sls-route" style="padding: 0px; margin: 0px;">
                                            <input type="text" autocomplete="off" value="2639" class="bx-ui-sls-fake" placeholder="Введите название ..." title="Новосибирск, Новосибирская область, Сибирь, Россия">
                                        </div>
                                        <div class="dropdown-fade2white"></div>
                                        <div class="bx-ui-sls-loader"></div>
                                        <div class="bx-ui-sls-clear" title="Отменить выбор" style="display: block;"></div>
                                        <div class="bx-ui-sls-pane" style="overflow: hidden auto; display: none;">
                                            <div class="bx-ui-sls-variants"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row sale-personal-profile-detail-property-textarea" id="spppi-property-id-19">
                        <label class="col-12 col-md-4 text-right" for="sppd-property-19">
                        Адрес доставки:
                        </label>
                        <div class="col-12 col-md-8">
                            <textarea class="form-control" type="text" name="ORDER_PROP_19" id="sppd-property-19" rows="10" cols="30"></textarea>
                        </div>
                    </div>
                    <div class="form-group row" style="display: flex; align-items: center; justify-content: center;">
                        <button class="btn btn-primary text-nowrap btn-colored--5867dd">отправить заявку на изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>