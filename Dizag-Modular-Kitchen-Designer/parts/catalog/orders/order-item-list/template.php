<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-list");
?>
<?
$modules = isset($args['MODULES']) ? $args['MODULES'] : null;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$activeModuleCode = isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args['ACTIVE_MODULE_CODE']) : null;

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
?>

<div class="catalog-order-item-list-errors w-100" id = "catalog-order-item-list-errors"></div>

<section class="catalog-oder-section d-flex flex-column justify-content-centr gap-2 w-100 p-1 p-lg-3 rounded">

    <div class="catalog-oder-content-conteiner d-flex flex-column gap20 w-100" id = "catalog-oder-content-conteiner">

        <div class="catalog-oder-content d-flex flex-column flex-lg-row">

            <div class="catalog-order-specification-section d-flex flex-column align-items-start justify-content-start gap-2 p-o p-lg-2 m-0 col-12 col-lg-9 order-2 order-lg-1"

                id = "catalog-order-specification-section">
                <?
                    get_template_part("parts/catalog/orders/order-specification/template", null,
                    [
                        'MODULES' => $args['MODULES'],
                        'ORDER_CODE' => sanitize_text_field($args['ORDER_CODE']),
                        'ACTIVATE_ELEMENT_GROUP' => 'specification-item-change-button',
                        'ACTIVE_MODULE_CODE' => sanitize_text_field($args['ACTIVE_MODULE_CODE']),
                        'IS_COMPLETED' => sanitize_text_field($args['IS_COMPLETED']),
                        'USER' => $user,
                        'ROLE' => $role,
                    ]);
                ?>
            </div>

            <div class="catalog-order-item-redactor d-none d-lg-flex gap-2 gap-lg-0 col-12 col-lg-3 p-2 order-1 order-lg-2">

                <div class="order-item-redactor-content w-100" id = "order-item-redactor-content">

                    <?/*При загрузке страницы конфигуратор загрузится через AJAX вызовом события submit формы в файле ../Order/script.js*/ ?>
                    <?if($activeModuleCode) 
                        get_template_part("parts/catalog/orders/facade-configurator/template", null,
                        [
                            'MODULE' => $module,
                            'ORDER_CODE' => sanitize_text_field($args['ORDER_CODE']),
                            'QUANTITY' => $quantity,
                            'ACTIVATE_ELEMENT_GROUP' => 'specification-item-change-button',
                            'IS_COMPLETED' => sanitize_text_field($args['IS_COMPLETED']),
                            'USER' => $user,
                            'ROLE' => $role,
                        ]);?>

                </div>
                
            </div>

        </div>

    </div>
    
    <div class ="w-100 d-none d-lg-flex" id ="catalog-order-messenger-errors"></div>

    <div class="order-item-messenger d-none d-lg-block">

        <div class="messenger-section-title d-flex w-100 align-items-center gap-1">

            <p class="massenger-title black p-1 m-0">Комментарии</p>

            <div id = "catalog-order-item-message-counter"></div>

            <div class="d-flex align-items-center collapse-btn  collapsed" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#catalog-messenger-collapse"
                data-bs-custom-toggle="tooltip" 
                title="Свернуть">

                <i class="bi bi-chevron-down collapse-icon transition-all"></i>

            </div>

        </div>
        
        <div class="order-item-massenger-section align-items-start justify-content-start gap-2 m-0 w-100 collapse" id="catalog-messenger-collapse">

            <div class="order-messanger-block w-100" id = "catalog-order-item-messenger"></div>

        </div>

    </div>

</section>