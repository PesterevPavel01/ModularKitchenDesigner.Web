<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-specification");
?>

<?

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$arParams = isset($args['MODULES']) ? $args['MODULES'] : null;

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$activeModuleCode = isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args["ACTIVE_MODULE_CODE"]) : "";

$order_page = get_page_by_path('order');

$order_page_id = $order_page->ID;

$membraneCode = get_field('membrane', $order_page_id);

$boardCode = get_field('board', $order_page_id);

$millingCode = get_field('milling', $order_page_id);

$cornerCode = get_field('corner', $order_page_id);

$cornerTopCode = get_field('corner-top', $order_page_id);

$cornerBottomCode = get_field('corner-bottom', $order_page_id);

$cornerLeftCode = get_field('corner-left', $order_page_id);

$cornerRightCode = get_field('corner-right', $order_page_id);

$hingeCode = get_field('hinge', $order_page_id);
?>

<p class="specification-title black p-1 m-0">Спецификация</p>

<div class="catalog-order-specification-list-conteiner h-100 white-background p-3 m-0 rounded w-100">
    
    <?if(!$args['MODULES']){?>

        <p class="error-message black">Необходимо добавить фасады, используя конфигуратор!</p>

    <?}else{?>

        <ul class="catalog-order-specification-list d-table gap-2 w-100 p-0 m-0">
            
            <li class="catalog-order-specification-header w-100 d-table-row">

                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-4">Пленка</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Высота, мм</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Ширина, мм</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Количество</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Площадь, м2</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Плита</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-3">Фрезеровка</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1 col-1">Кромка фасада</span>
                <span class="d-table-cell order-specification-cell dark fw-bold p-1">отверстие под петли</span>

            </li>

            <?$totalArea = 0;?>

            <?foreach($args['MODULES'] as $moduleItem){?>

                <?$module = $moduleItem['module'];?>

                <?$components = $module['components'];?>

                <li class="catalog-order-specification-item w-100 d-table-row">

                    <?
                    $membrane = array_filter($components, function($item) use ($membraneCode)
                        {
                            return $item['componentTypeCode'] === $membraneCode;
                        }
                    );

                    $membrane = reset($membrane);
                    ?>
                        
                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= !empty($membrane)? esc_html($membrane['componentTitle']) : 'Нет данных'?>">
                        <input type="text" readonly value="<?=esc_html($membrane['componentTitle'])?>" class="membrane w-100 border rounded height-40" name="membrane"/>
                    </div>

                    <?
                    $length = array_filter($module['moduleNumericParameters'], function($item)
                        {
                            return $item['type'] === "Высота";
                        }
                    );

                    $length = reset($length);
                    ?>

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= !empty($length)? esc_html($length['value']): 'Нет данных'?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?= !empty($length)? esc_html($length['value']): ''?>" class="length w-100 border rounded height-40" name="length"/>
                    </div>

                    <?if(!empty($module))
                    {
                        $width = array_filter($module['moduleNumericParameters'], function($item)
                            {
                                return $item['type'] === "Ширина";
                            }
                        );

                        $width = reset($width);

                    }?>

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?=!empty($width)? $width['value']: 'Нет данных'?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?= !empty($width)? $width['value']: ''?>" class="order-item-specification-width w-100 border rounded height-40" name="order-item-specification-width"/>
                    </div>

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?=esc_html($moduleItem["quantity"])?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?=esc_html($moduleItem["quantity"])?>" class="order-item-specification-quantity w-100 border rounded height-40" name="order-item-specification-quantity"/>
                    </div>

                    <?$area = !empty($width) && !empty($length)? (double)$width['value']/1000 * (double)$length['value']/1000 *  (double)$moduleItem["quantity"] : null;
                    
                    if($area)
                     $totalArea += $area;
                    ?> 

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?=$area ? number_format($area, 2, ',', ' ') : 'Нет данных'?>">
                        <input type="text" readonly value="<?= $area ?  number_format($area, 2, ',', ' ') : ''?>" class="order-item-specification-area w-100 border rounded height-40" name="order-item-specification-width"/>
                    </div>

                    <?
                    $board = [];

                    $board = array_filter($components, function($item) use ($boardCode)
                        {
                            return $item['componentTypeCode'] === $boardCode;
                        });

                    $board = reset($board);       
                    ?>
                    
                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= empty($board) ? 'Нет данных' : esc_html($board['componentTitle'])?>">
                        <input type="text" readonly value="<?= empty($board) ? "" : esc_html($board['componentTitle'])?>" class="board w-100 border rounded height-40" name="board"/>
                    </div>

                    <?
                    $milling = [];

                    $milling = array_filter($components, function($item) use ($millingCode)
                        {
                            return $item['componentTypeCode'] === $millingCode;
                        });

                    $milling = reset($milling);
                    ?>

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= empty($milling) ? 'Нет данных' : esc_html($milling['componentTitle'])?>">
                        <input type="text" readonly value="<?= empty($milling) ? '' : esc_html($milling['componentTitle'])?>" class="milling w-100 border rounded height-40" name="milling"/>
                    </div>

                    <?
                    $cornerTop = [];
                    $cornerTop = array_filter($components, function($item) use ($cornerTopCode)
                        {
                            return $item['componentTypeCode'] === $cornerTopCode;
                        });

                    $cornerBottom = [];
                    $cornerBottom = array_filter($components, function($item) use ($cornerBottomCode)
                        {
                            return $item['componentTypeCode'] === $cornerBottomCode;
                        });

                    $cornerLeft = [];
                    $cornerLeft = array_filter($components, function($item) use ($cornerLeftCode)
                        {
                            return $item['componentTypeCode'] === $cornerLeftCode;
                        });

                    $cornerRight = [];
                    $cornerRight = array_filter($components, function($item) use ($cornerRightCode)
                        {
                            return $item['componentTypeCode'] === $cornerRightCode;
                        });

                    if(!empty($cornerTop) || !empty($cornerBottom) || !empty($cornerLeft) || !empty($cornerRight)){

                        $cornerTitle = 'mix';

                    }else{

                        $corner = [];

                        $corner = array_filter($components, function($item) use ($cornerCode)
                        {
                            return $item['componentTypeCode'] === $cornerCode;
                        }
                        );

                        $corner = reset($corner);

                        $cornerTitle = empty($corner) ? 'Нет данных' : esc_html($corner['componentTitle']);
                    }
                    ?>    

                    <div class="d-table-cell catalog-order-specification-cell ps-1 pb-2 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= $cornerTitle ?>">
                        <input type="text" readonly value=<?= $cornerTitle ?> class="corner w-100 border rounded height-40" name="corner"/>
                    </div>

                    <?
                    $hinge = [];

                    $hinge = array_filter($components, function($item) use ($hingeCode)
                        {
                            return $item['componentTypeCode'] === $hingeCode;
                        }
                    );

                    $hinge = reset($hinge);?>

                    <div class="d-table-cell hinge catalog-order-specification-cell ps-1 pb-2 m-0 align-middle text-center">
                        <div class="specification-item-control-conteiner border rounded height-40 w-100 d-flex flex-column align-items-center justify-content-center p-2">
                            <i class = "<?=!empty($hinge) ? 'bi-check-lg fs-3 primary' : "bi-x-lg"?> bi">
                            </i>
                        </div>
                    </div>

                    <form class="d-table-cell catalog-order-specification-cell ps-1 m-0 align-middle text-center pb-2 pointer" data-ajax-default-content-updater>

                        <input type="hidden" name = "BLOCKED_ELEMENT" value = "#catalog-oder-content-conteiner">
                        <input type="hidden" name = "TEMPLATE_PART" value = "parts/catalog/orders/facade-configurator/template">
                        <input type="hidden" name = "action" value="default_content_updater">
                        <input type="hidden" name = "TARGET_CONTAINER" value="#order-item-redactor-content">
                        <input type="hidden" name = "MODULE_CODE" value=<?=esc_html($module["moduleCode"])?>>
                        <input type="hidden" name = "ORDER_CODE" value=<?=esc_html($orderCode)?>>
                        <input type="hidden" name = "QUANTITY" value=<?=esc_html($moduleItem["quantity"])?>>
                        <input type="hidden" name = "ACTIVATE_ELEMENT_GROUP" value="specification-item-change-button">
                        <input type="hidden" name = "IS_COMPLETED" value=<?=sanitize_text_field($args['IS_COMPLETED'])?>>
                        <input type="hidden" name = "MODULE" value="<?= ($module || !empty($module))? htmlspecialchars(json_encode($module, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : ""?>">
                        <input type="hidden" data-no-reset="true" name="USER" value="<?=$user?>">
                        <input type="hidden" data-no-reset="true" name="ROLE" value="<?=$role?>">

                        <button type = "submit" id = "<?=esc_html($module["moduleCode"])?>" class = "<?=$module["moduleCode"] === $activeModuleCode ? "active" : "" ?> btn-primary white-background d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40"
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
                            data-bs-module-code="<?=esc_html($module["moduleCode"])?>"
                            data-bs-order-code="<?=esc_html($orderCode)?>">
                            
                            <i class = "bi bi-x-lg primary-dark cursor hover-white"                    
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"    
                                title="Удалить элемент">
                            </i>
                        </button>

                    </div>
                    <??>
                </li>

            <?}?>
            
            <?if($totalArea !== 0){?>
                <div class="ps-2 pb-4 align-start text-start"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Итоговая площадь заказа">
                    <strong type="text" class="d-table-cell w-100 align-items-start">ВСЕГО</strong>
                </div>
                <div class="d-table-cell"></div>
                <div class="d-table-cell"></div>
                <div class="d-table-cell"></div>
                <div class="d-table-cell catalog-order-specification-cell ps-2 pb-4 align-start text-start"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Итоговая площадь заказа">
                    <strong class="w-100 align-items-start"><?=number_format($totalArea, 2, ',', ' ')?></strong>
                </div>
            <?}?>
        </ul>
    <?}?>

</div>