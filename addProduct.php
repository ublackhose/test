<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$ar_res = CCatalogProduct::GetByIDEx($_REQUEST['id']);


$sale = null;

if (strlen($ar_res["DISCOUNT_PRICE_PERCENT_FORMATED"])) {
    $sale = '<td class="sale-order-detail-order-item-properties text-right">
                                ' . $ar_res['DISCOUNT_PRICE_PERCENT_FORMATED'] . '
                            </td>';
} else {
    $sale = '                        <td class="sale-order-detail-order-item-properties text-right">
                                <strong class="bx-price"></strong>
                            </td>';
}


foreach ($ar_res['PRICES'] as $ar_re) {
    if($ar_re['CURRENCY']=="RUB"){
        $price = $ar_re['PRICE'];
    }
}



echo '<tr data-id = ' . $ar_res['PRODUCT']['ID'] . ' data-price = "' . $price . '" data-artnumber = "'.$ar_res['PROPERTIES']['CML2_ARTICLE']['VALUE'].'">

<td class="sale-order-detail-order-item-properties" style=" min-width: 360px;"> 
                            <div style="max-width: 275px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-block">
                                        <div class="mb-2"><span class="mr-2">
                                        <a
                                                        href="' . $ar_res['DETAIL_PAGE_URL'] . '"
target="_blank">' . $ar_res['NAME'] . '</a></span>

</div>
</div>
</div>
</div>    </td>


            <td class="sale-order-detail-order-item-properties text-right"> 
                            <div class="text-nowrap">' . $price . ' ₽</div>  
                        </td>
                        ' . $sale . '
            
            <td class="sale-order-detail-order-item-properties">
                            <div data-entity="quantity-block"
                                 class="product-amount form-inline d-inline-block mw-100">
                                <div class="form-group">
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <button onclick="clickMin(this)" type="button" 
                                                    class="btn btn-outline-secondary btn-sm">
                                                -
                                            </button>
                                        </div>
                                        <input type="number" min="1" max="100" step="1" tabindex="2"
                                               value="' . 1 . '"
                                               class="product-amount-field form-control form-control-sm">
                                        <div   class="input-group-append">
                                            <button onclick="clickPlus(this)" type="button" class="btn btn-outline-secondary btn-sm">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </td>  
                        
                        <td class="sale-order-detail-order-item-properties text-right">
                            <strong class="bx-quantity">'.$ar_res['PRODUCT']['QUANTITY'].'</strong>
                        </td>
          
                        <td class="sale-order-detail-order-item-properties text-right">  
                            <div class="font-weight-bold text-nowrap sum_price">' . $price . ' ₽</div> 
                        </td>
                        
                        <td class="sale-order-detail-order-item-properties text-right">   
                            <div class="dropdown position-static"><a
                                        data-toggle="dropdown"
                                        data-boundary="viewport"
                                        role="button"
                                        href="#"
                                        class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                        aria-expanded="false"><i
                                            class="la la-ellipsis-h"></i></a>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end"
                                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(526px, -200px, 0px);">

                                    <ul class="kt-nav">
                                        <li class="kt-nav__item"><a onclick="deletetr(this)" data-target="#modalImportFile" data-toggle="modal"
                                                                    href="#" class="kt-nav__link"><i
                                                        class="kt-nav__link-icon flaticon2-trash"></i> <span
                                                        class="kt-nav__link-text" data-id = ' . $ar_res['ID'] . '>Удалить</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                       
</tr>';
