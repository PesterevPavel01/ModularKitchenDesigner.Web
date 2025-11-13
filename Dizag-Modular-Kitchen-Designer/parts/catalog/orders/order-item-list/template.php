<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-list");
?>
<?
$modules = isset($args['MODULES']) ? $args['MODULES'] : null;

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
<section class="catalog-oder-section d-flex flex-column justify-content-centr gap-2 w-100 p-3 rounded">

    <div class="catalog-oder-content-conteiner d-flex flex-column gap20 w-100" id = "catalog-oder-content-conteiner">

        <div class="catalog-oder-content d-flex">

            <div class="catalog-order-specification-section d-flex flex-column align-items-start justify-content-start gap-2 p-2 m-0 col-9"
                id = "catalog-order-specification-section">
                <?
                    get_template_part("parts/catalog/orders/order-specification/template", null,
                    [
                        'MODULES' => $args['MODULES'],
                        'ORDER_CODE' => sanitize_text_field($args['ORDER_CODE']),
                        'ACTIVATE_ELEMENT_GROUP' => 'specification-item-change-button',
                        'ACTIVE_MODULE_CODE' => sanitize_text_field($args['ACTIVE_MODULE_CODE'])
                    ]);
                ?>
            </div>

            <div class="catalog-order-item-redactor d-flex col-3 p-2">

                    <div class="order-item-redactor-content w-100" id = "order-item-redactor-content">

                        <?get_template_part("parts/catalog/orders/facade-configurator/template", null,
                        [
                            'MODULE' => $module,
                            'ORDER_CODE' => sanitize_text_field($args['ORDER_CODE']),
                            'QUANTITY' => $quantity,
                            'ACTIVATE_ELEMENT_GROUP' => 'specification-item-change-button',
                        ]);?>

                    </div>
                
            </div>

        </div>

    </div>

    <block class="order-messanger-block w-100">

        <?get_template_part("parts/catalog/orders/order-item-messenger/template", null,
        [
            'MODULE' => $module
        ]);?>
        
    </block>

</section>