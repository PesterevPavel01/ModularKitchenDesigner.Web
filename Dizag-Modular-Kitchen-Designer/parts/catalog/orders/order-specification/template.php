<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-specification");
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';

global $orderServiceUrl;
?>

<?
$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$activeModuleCode = isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args['ACTIVE_MODULE_CODE']) : null;

if(isset($args['MODULES']) && $args['MODULES']){

    if(!is_array($args['MODULES'])){

        $modules = json_decode($moduleJson = stripslashes($args['MODULES']), true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            $modules = [];

            echo 'Ошибка декодирования JSON: ' . json_last_error_msg();
            
            return;
        }

    }else{

        $modules = $args['MODULES'];
    }

    $isCompleted = sanitize_text_field($args['IS_COMPLETED']);

}else{

    $Result = new BaseResult();

    $OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

    $Result = $OrderByCodeProcessor->Process($orderCode);

    if(!$Result->isSuccess())
    {
        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);

        return;
    }

    $order = $Result->data[0];

    $modules = $order['modules'];

    $isCompleted = sanitize_text_field($order['isCompleted']);

}

$module = [];

$quantity = null;

if($activeModuleCode){

    $module = array_filter($modules, function($item) use ($activeModuleCode)
    {
        return $item['module']['moduleCode'] === $activeModuleCode;
    });

    $module = reset($module);

    $quantity = $module['quantity'];

    $module = empty($module) ? null : $module['module'];

}

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

<p class="d-none d-lg-block specification-title black p-3 p-lg-1 m-0">Спецификация</p>

<div class="catalog-order-specification-list-conteiner h-100 background-lg-white pt-3 p-lg-3 m-0 rounded w-100 shadow-sm">
    
    <?if(!$modules){?>

        <p class="error-message black">Необходимо добавить фасады, используя конфигуратор!</p>

    <?}else{?>

        <ul class="catalog-order-specification-list d-flex flex-column d-lg-table gap-2 w-100 p-0 m-0">
            
            <li class="catalog-order-specification-header w-100 d-none d-lg-table-row">

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

            <?foreach($modules as $moduleItem){?>

                <?$module = $moduleItem['module'];?>

                <?$components = $module['components'];?>

                <li class="catalog-order-specification-item w-100 d-flex flex-column d-lg-table-row white-background shadow-lg shadow-lg-none p-3 p-lg-0">

                    <span class="d-table-cell d-lg-none order-specification-cell dark fw-bold p-1 w-100 pb-lg-2">Пленка</span>

                    <?
                    $membrane = array_filter($components, function($item) use ($membraneCode)
                        {
                            return $item['componentTypeCode'] === $membraneCode;
                        }
                    );

                    $membrane = reset($membrane);
                    ?>
                        
                    <div class="d-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= !empty($membrane)? esc_html($membrane['componentTitle']) : 'Нет данных'?>">
                        <input type="text" readonly value="<?=esc_html($membrane['componentTitle'])?>" class="membrane w-100 border rounded height-40" name="membrane"/>
                    </div>

                    <span class="d-table-cell d-lg-none order-specification-cell dark fw-bold p-1 w-100">Высота, мм</span>

                    <?
                    $length = array_filter($module['moduleNumericParameters'], function($item)
                        {
                            return $item['type'] === "Высота";
                        }
                    );

                    $length = reset($length);
                    ?>

                    <div class="d-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?= !empty($length)? esc_html($length['value']): 'Нет данных'?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?= !empty($length)? esc_html($length['value']): ''?>" class="length w-100 border rounded height-40" name="length"/>
                    </div>

                    <span class="d-table-cell d-lg-none order-specification-cell dark fw-bold p-1 w-100">Ширина, мм</span>

                    <?if(!empty($module))
                    {
                        $width = array_filter($module['moduleNumericParameters'], function($item)
                            {
                                return $item['type'] === "Ширина";
                            }
                        );

                        $width = reset($width);

                    }?>

                    <div class="d-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?=!empty($width)? $width['value']: 'Нет данных'?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?= !empty($width)? $width['value']: ''?>" class="order-item-specification-width w-100 border rounded height-40" name="order-item-specification-width"/>
                    </div>

                    <span class="d-table-cell d-lg-none order-specification-cell dark fw-bold p-1 w-100">Количество</span>

                    <div class="d-table-cell catalog-order-specification-cell ps-1 align-middle text-center pb-2"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="<?=esc_html($moduleItem["quantity"])?>">
                        <input type="text" readonly step="1" min="0" max="2000" value="<?=esc_html($moduleItem["quantity"])?>" class="order-item-specification-quantity w-100 border rounded height-40" name="order-item-specification-quantity"/>
                    </div>

                    <?$area = !empty($width) && !empty($length)? (double)$width['value']/1000 * (double)$length['value']/1000 *  (double)$moduleItem["quantity"] : null;
                    
                    if($area)
                     $totalArea += $area;
                    ?> 

                    <div class="d-none d-lg-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
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
                    
                    <div class="d-none d-lg-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
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

                    <div class="d-none d-lg-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
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

                    <div class="d-none d-lg-table-cell catalog-order-specification-cell pb-lg-2 ps-1 align-middle text-center"
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

                    <div class="d-none d-lg-table-cell hinge catalog-order-specification-cell pb-lg-2 ps-1 m-0 align-middle text-center">
                        <div class="specification-item-control-conteiner border rounded height-40 w-100 d-flex flex-column align-items-center justify-content-center p-2">
                            <i class = "<?=!empty($hinge) ? 'bi-check-lg fs-3 primary' : "bi-x-lg"?> bi">
                            </i>
                        </div>
                    </div>
                    
                    <div class="order-specification-item-controls d-flex flex-row w-100">
                    
                        <?if(!$isCompleted){?>

                            <div class="d-table-cell pb-lg-2 ps-1 m-0 align-middle text-center pointer col-4">

                                <?$newModule = $module;
                                $newModule["moduleCode"] = null;

                                get_template_part("parts/catalog/forms/order-item-add-by-copying-form/template", null, 
                                [
                                    'ORDER_CODE' => sanitize_text_field($orderCode),
                                    'QUANTITY' => sanitize_text_field($moduleItem["quantity"]),
                                    "IS_COMPLETED" => $isCompleted,
                                    "MODULE" => ($newModule || !empty($newModule))? htmlspecialchars(json_encode($newModule, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : "",
                                    'USER' => $user,
                                    'ROLE' => $role,
                                ]);?>

                            </div>

                        <?}?>

                        <div class="d-table-cell pb-lg-2 ps-1 m-0 align-middle text-center pointer col-4">

                            <?get_template_part("parts/catalog/forms/order-item-send-to-configurator-form/template", null, 
                            [
                                'MODULE_CODE' => esc_html($module["moduleCode"]),
                                'ORDER_CODE' => sanitize_text_field($orderCode),
                                'QUANTITY' => sanitize_text_field($moduleItem["quantity"]),
                                "IS_COMPLETED" => $isCompleted,
                                "MODULE" => ($module || !empty($module))? htmlspecialchars(json_encode($module, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') : "",
                                'USER' => $user,
                                'ROLE' => $role,
                                'ACTIVE' => $module["moduleCode"] === $activeModuleCode ? "active" : "" 
                            ]);?>

                        </div>

                        <?if(!$isCompleted){?>

                            <div class="d-table-cell catalog-order-specification-cell pb-lg-2 ps-1 m-0 align-middle text-center pointer col-4">

                                <button type = "button" class = "specification-item-remove-button btn-primary white-background w-100 d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#remove-order-item-modal"
                                    data-bs-module-code="<?=esc_html($module["moduleCode"])?>"
                                    data-bs-order-code="<?=esc_html($orderCode)?>"
                                    data-bs-order-user="<?=esc_html($user)?>"
                                    data-bs-order-role="<?=esc_html($role)?>">
                                    
                                    <i class = "bi bi-x-lg primary-dark cursor hover-white"                    
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top"    
                                        title="Удалить элемент">
                                    </i>
                                    
                                </button>

                            </div>

                        <?}?>

                    </div>
                    
                </li>

            <?}?>
            
            <?if($totalArea !== 0){?>

                <li class="white-background d-flex d-lg-table-row gap-2 gap-lg-0 p-2 p-lg-0">

                    <div class="d-flex flex-column ps-lg-2 pb-lg-4 justify-content-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="Итоговая площадь заказа">
                        <strong type="text" class="d-none d-lg-table-cell text-center text-lg-start w-100 align-items-center align-items-lg-start">ВСЕГО</strong>
                        <strong type="text" class="d-lg-table-cell d-lg-none text-center text-lg-start w-100 align-items-center p-2 p-lg-0 align-items-lg-start">ИТОГОВАЯ ПЛОЩАДЬ:</strong>
                    </div>

                    <div class="d-none d-lg-table-cell"></div>
                    <div class="d-none d-lg-table-cell"></div>
                    <div class="d-none d-lg-table-cell"></div>

                    <div class="d-lg-table-cell d-flex flex-column ps-lg-2 pb-lg-4 justify-content-center"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="Итоговая площадь заказа">
                        <strong class="text-center text-lg-start w-100 align-items-center align-items-lg-start"><?=number_format($totalArea, 2, ',', ' ')?></strong>
                    </div>

                </li>

            <?}?>

        </ul>
    <?}?>

</div>