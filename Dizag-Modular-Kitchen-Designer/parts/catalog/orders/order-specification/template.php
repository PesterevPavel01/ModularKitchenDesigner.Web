<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-specification");
?>

<?
$arParams = isset($args['MODULES']) ? $args['MODULES'] : null;
$orderCode = $args['ORDER_CODE'];
?>

<p class="specification-title black p-1">Спецификация</p>

<div class="catalog-order-specification-list-conteiner h-100 white-background p-3 m-0 rounded">
    
    <ul class="catalog-order-specification-list d-table gap-2 w-100">
        
        <li class="catalog-order-specification-header w-100 d-table-row">

            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-4">Пленка</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Высота, мм</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Ширина, мм</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Количество</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Плита</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-3">Фрезеровка</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Кромка фасада</span>
            <span class="d-table-cell order-specification-cell dark fw-bold p-1">отверстие под петли</span>

        </li>

        <?foreach($args['MODULES'] as $module){?>

            <li class="catalog-order-specification-item w-100 d-table-row">
                
                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля membrane">
                    <input type="text" readonly value="SF-04 Мокко" class="membrane w-100 border rounded height-40" name="membrane" id = "order-item-specification-membrane"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="63 500,55">
                    <input type="text" readonly step="1" min="0" max="2000" value="63 500,55" class="height w-100 border rounded height-40" name="height" id = "order-item-specification-height"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля width">
                    <input type="text" readonly step="1" min="0" max="2000" value="0" class="order-item-specification-width w-100 border rounded height-40" name="order-item-specification-width" id = "order-item-specification-width"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля quantity">
                    <input type="text" readonly step="1" min="0" max="2000" value="<?=esc_html($module["quantity"])?>" class="order-item-specification-quantity w-100 border rounded height-40" name="order-item-specification-quantity" id = "order-item-specification-quantity"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля board">
                    <input type="text" readonly value="16" class="board w-100 border rounded height-40" name="board" id = "order-item-specification-board"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля milling">
                    <input type="text" readonly value="№18 Палермо" class="milling w-100 border rounded height-40" name="milling" id = "order-item-specification-milling"/>
                </div>

                <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="подпись поля corner">
                    <input type="text" readonly value="R-90°" class="corner w-100 border rounded height-40" name="corner" id = "order-item-specification-corner"/>
                </div>

                <div class="d-table-cell hinge catalog-order-specification-cell ps-1 pb-2 m-0 align-middle text-center">
                    <div class="specification-item-control-conteiner border rounded height-40 w-100 d-flex flex-column align-items-center justify-content-center p-2">
                        <i class = "bi bi-check-lg fs-3 primary">
                        </i>
                    </div>
                </div>

                <form class="d-table-cell catalog-order-specification-cell ps-1 m-0 align-middle text-center pb-2 pointer" data-ajax-default-content-updater>

                    <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#catalog-oder-content-conteiner">
                    <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/orders/facade-configurator/template">
                    <input type="hidden" id="action" name = "action" value="default_content_updater">
                    <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#catalog-order-item-redactor">
                    <?/*<input type="hidden" id="DEPENDENT_FORM"  name = "DEPENDENT_FORM" value="#approval-customer-section">*/?>
                    <input type="hidden" id="module-code" name = "MODULE_CODE" value=<?=esc_html($module["module"]["moduleCode"])?>>
                    <input type="hidden" id="order-code" name = "ORDER_CODE" value=<?=esc_html($orderCode)?>>
                    <input type="hidden" id="order-code" name = "QUANTITY" value=<?=esc_html($module["quantity"])?>>
                    <input type="hidden" name = "ACTIVATE_ELEMENT_GROUP" value="specification-item-change-button">
                    <input type="hidden" name = "MODULE" value="<?= ($module["module"] || !empty($module["module"]))? htmlspecialchars(json_encode($module["module"], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>">

                    <button type = "submit" id = "<?=esc_html($module["module"]["moduleCode"])?>" class = "specification-item-change-button btn-primary white-background d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40"
                        data-form-group="specification-item-change-button">
                        <i class = "bi bi-pencil-fill primary-dark pointer hover-white"                
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top"    
                            title="Редактировать элемент">
                        </i>
                    </button>

                </form>

                <div class="d-table-cell catalog-order-specification-cell ps-1 m-0 align-middle text-center pointer pb-2">

                    <button type = "button" class = "specification-item-remove-button btn-primary white-background w-100 d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40"
                        data-bs-toggle="modal"
                        data-bs-target="#remove-order-item-modal"
                        data-bs-item-code="<?=esc_html($module["module"]["moduleCode"])?>">
                        
                        <i class = "bi bi-x-lg primary-dark cursor hover-white"                    
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top"    
                            title="Удалить элемент">
                        </i>
                    </button>

                </div>
            </li>

        <?}?>

    </ul>

</div>

<?get_template_part("parts/catalog/orders/remove-order-item-form/template");?>