<?
print_r($args);
?>

<?get_template_part("parts/catalog/orders/order-item-list/template",null,
    [
        'ORDER_CODE' =>  esc_http($args['MODULE_CODE']),
        'MODULES' =>  $order['modules']
    ]);?>