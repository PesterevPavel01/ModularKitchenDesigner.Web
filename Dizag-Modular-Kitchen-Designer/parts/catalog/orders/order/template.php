<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order");
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';
?>
<?
global $orderServiceUrl;

$current_user = wp_get_current_user();

$login = $current_user->user_login;

$roles = $current_user->roles;

if(in_array('customer', $roles))
    $role = 'customer';
elseif(in_array('constructor', $roles))
    $role = 'constructor';
else
    $role = null;


$code = sanitize_text_field($args['ORDER_CODE']);

$Result = new BaseResult();

$OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

$Result = $OrderByCodeProcessor->Process($code);

if(!$Result->isSuccess())
{?>
    <p><?=$Result->ErrorMessage?></p>
    <?return;
}

$order = $Result->data[0];

if($code && !in_array('constructor', $roles) && $login != $order['userName'] ){
    ?><p class="error-message black">У пользователя нет необходимых прав!</p><?
    return;
}
?>

<block class="title-block d-flex flex-column w-100 justify-content-between w-100 flex-lg-row align-items-lg-center">
    
    <a href="<?=home_url('/account/')?>" class="m-0 p-0">
        <button class="btn btn-primary m-0 m-width-200">МОИ ЗАКАЗЫ</button>
    </a>

    <t2 class="title w-100">Заказ: <?=esc_html($order['title'])?></t2>
            
    <block class="panel-control d-flex justify-content-start justify-content-xl-end gap-2" id = "order-submit-block">

        <?//загружаю через ajax после загрузки страницы?>
        <?/*get_template_part("parts/catalog/orders/order-submit-form/template",null,
        [
            'ORDER_CODE' =>  $code,
            'ACTIVE' => ($order['modules'] || !empty($order['modules'])) ? true : false,
            'USER' => $login,
            'ROLE' => $role,
        ]);*/?>
        
    </block>

</block> 

<block id = "catalog-order-item-list" class = "w-100">

    <?get_template_part("parts/catalog/orders/order-item-list/template",null,
    [
        'ORDER_CODE' =>  $code,
        'MODULES' =>  $order['modules'],
        'ACTIVE_MODULE_CODE' => isset($args['ACTIVE_MODULE_CODE']) ? sanitize_text_field($args['ACTIVE_MODULE_CODE']) : null,
        'IS_COMPLETED' => $order['isCompleted'],
        'USER' => $login,
        'ROLE' => $role,
    ]);?>

</block> 

<?
    if(!$order['isCompleted']){

        get_template_part("parts/catalog/orders/order-blueprints-form/template", null, 
            [
                'COMPONENT_TYPE' => 'milling'
            ]);

        get_template_part("parts/catalog/orders/configurator-blueprints-reset-form/template", null, 
            [
                'COMPONENT_TYPE' => 'milling'
            ]);

        get_template_part("parts/catalog/orders/order-blueprints-form/template", null, 
            [
                'COMPONENT_TYPE' => 'hinge'
            ]);

        get_template_part("parts/catalog/orders/configurator-blueprints-reset-form/template", null, 
            [
                'COMPONENT_TYPE' => 'hinge'
            ]);
    }?>
    
    <?get_template_part("parts/catalog/orders/order-submit-reset-form/template", null, 
    [
        'ORDER_CODE' =>  $code,
        'USER' => $login,
        'ROLE' => $role,
    ]);
    ?>