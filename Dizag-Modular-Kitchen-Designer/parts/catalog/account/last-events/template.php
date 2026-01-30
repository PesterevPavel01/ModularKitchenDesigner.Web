<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderEventQueryHandler.php';
global $orderServiceUrl;

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';

$userName = isset($args['USER']) ? sanitize_text_field($args['USER']) : '';

if($role === '' || $userName === ''){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Некорректные данные пользователя',
    ]);

    return;
}

$Result = new BaseResult();

$OrderEventQueryHandler = new OrderEventQueryHandler($orderServiceUrl);

$Result = $OrderEventQueryHandler->Handle( $role === 'constructor' ? 'constructor' : $userName, ['PAGE_INDEX' => '0', 'PAGE_SIZE'=>'10' ] );

if(!$Result->isSuccess())
{        
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);
    
    return;
}

if(!empty($Result->data['items'])){
?>
    <div class="order-list-last-events" id="order-list-last-events">
        
        <div class="order-list-last-events-content d-flex flex-column align-items-start justify-content-start gap-2 m-0 ms-lg-3">

            <t2 class="title ps-2">Последнии события</t2>

            <ul class="events-section d-flex flex-column align-items-start gap-1 white-background m-0 p-4 w-100 shadow-lg shadow-lg-sm gap-3 rounded">

            <?foreach($Result->data['items'] as $item){

                $createdAt =  new DateTime($item['createdAt']);

                $Code = $item['orderCode'];
                
                $order_url = add_query_arg('Code', $Code, home_url('/order/'));?>

                <li class="parameter-item d-flex flex-column w-100 justify-content-start">

                    <a class="black" href="<?=esc_url($order_url)?>">

                        <strong>Заказ <?= esc_html($item['orderTitle'])?></strong>

                    </a>
                    <span class = "small-font p-0 m-0"><?= esc_html($createdAt->format('d.m.Y H:i:s'))?></span>

                    <small><?= esc_html($item['title'])?></small>

                </li>

            <?}?>
            </ul>

        </div>
    </div>
<?}?>