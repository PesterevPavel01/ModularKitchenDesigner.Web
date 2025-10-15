<?
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderRemovalProcessor.php';

global $orderServiceUrl;

$OrderRemovalProcessor = new OrderRemovalProcessor($orderServiceUrl);

if(!$args["ORDER_CODE"]){
    print_r('параметер "ORDER_CODE" не найден!');
    print_r("<br><br>");      
}

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$result = $OrderRemovalProcessor->Process($orderCode);
/*
if(!$result->isSuccess())
{?>
    <p class="error-message"><?=$result->ErrorMessage?></p>
    <?return;
}*/
?>
<p class="error-message black w-100 p-1 text-center">Выполнено!</p>