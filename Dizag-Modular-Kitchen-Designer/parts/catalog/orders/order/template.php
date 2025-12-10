<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order");
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';
?>
<?
global $orderServiceUrl;

$code = sanitize_text_field($args['ORDER_CODE']);

$login = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$Result = new BaseResult();

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

$Result = $OrderByCodeProcessor->Process($code);

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
?>

<block class="title-block d-flex flex-column w-100 justify-content-lg-between flex-lg-row align-items-lg-center gap-1 gap-lg-0">
    
    <a href="<?=home_url('/account/')?>" class="m-0 p-0 order-2 order-lg-1">
        <button class="btn btn-primary m-0 w-100 m-width-200 border">МОИ ЗАКАЗЫ</button>
    </a>

    <t1 class="title w-100 text-center text-lg-start order-1 order-lg-2">Заказ: <?=esc_html($order['title'])?></t1>

    <?// СТАТУС ЗАКАЗА?>
            
    <block class="panel-control d-flex justify-content-start justify-content-xl-end gap-2 order-3 col-12 col-lg-2" id = "order-submit-block">

        <?//загружаю через ajax после загрузки страницы, вызовом события submit формы #order-submit-reset-form в файле script.js?>
        
    </block>

    <?//КОНФИГУРАТОР //КНОПКА "НОВЫЙ МОЛУЛЬ" В МОБИЛЬНОЙ ВЕРСИИ?>

    <div class="catalog-add-new-module-button order-3 d-flex <?=$order['isCompleted'] ? 'd-none' : 'd-lg-none'?>">

        <?get_template_part("parts/catalog/forms/order-item-send-to-configurator-form/template", null, 
            [
                'ORDER_CODE' => $code,
                "IS_COMPLETED" => $order['isCompleted'],
                'USER' => $login,
                'ROLE' => $role,
            ]);?>
    
    </div>
    
</block> 

<block id = "catalog-order-item-list" class = "w-100">

    <div class="catalog-order-item-list-errors w-100" id = "catalog-order-item-list-errors"></div>

        <section class="catalog-oder-section d-flex flex-column justify-content-centr gap-2 w-100 p-1 p-lg-3 rounded white-background" id = catalog-oder-section>
            
            <?get_template_part("parts/catalog/orders/order-item-list/template",null,
            [
                'ORDER_CODE' =>  $code,
                'MODULES' =>  $order['modules'],
                'IS_COMPLETED' => $order['isCompleted'],
                'USER' => $login,
                'ROLE' => $role,
            ]);?>

            <?get_template_part("parts/catalog/orders/order-item-messenger/template",null,[]);?>

        </section>

</block>

<?if(!$order['isCompleted']){

    get_template_part("parts/catalog/forms/order-blueprints-form/template", null, 
        [
            'COMPONENT_TYPE' => 'milling',
            'USER' => $login,
            'ROLE' => $role,
        ]);

    get_template_part("parts/catalog/forms/configurator-blueprints-reset-form/template", null, 
        [
            'COMPONENT_TYPE' => 'milling',
            'USER' => $login,
            'ROLE' => $role,
        ]);

    get_template_part("parts/catalog/forms/order-blueprints-form/template", null, 
        [
            'COMPONENT_TYPE' => 'hinge',
            'USER' => $login,
            'ROLE' => $role,
        ]);

    get_template_part("parts/catalog/forms/configurator-blueprints-reset-form/template", null, 
        [
            'COMPONENT_TYPE' => 'hinge',
            'USER' => $login,
            'ROLE' => $role,
        ]);
}?>

<?get_template_part("parts/catalog/forms/order-submit-reset-form/template", null, 
[
    'ORDER_CODE' =>  $code,
    'USER' => $login,
    'ROLE' => $role,
]);
?>