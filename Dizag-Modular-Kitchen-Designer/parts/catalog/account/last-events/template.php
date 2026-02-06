<?

if($args['ROLE'] === 'constructor')
    enqueue_template_part_styles_scripts( __DIR__ . "/constructor-style", "last-event","last-event-constructor-css");

if($args['ROLE'] === 'customer')
    enqueue_template_part_styles_scripts( __DIR__ . "/customer-style", "last-event","last-event-customer-css");

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

$Result = $OrderEventQueryHandler->Handle( $role === 'constructor' ? 'constructor' : $userName, ['PAGE_INDEX' => '0', 'PAGE_SIZE'=>'20' ] );

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
<div class="order-list-last-events fixed-height-container mb-1" id="order-list-last-events">
    
    <div class="order-list-last-events-content d-flex flex-column align-items-start justify-content-start gap-2 m-0">
        
        <div class="last-events-scrollbar-conteiner white-background rounded shadow-lg shadow-lg-sm w-100 p-4 pe-0 h-100 ">

            <small class="checkbox_label text-start primary-dark m-0 p-2">СОБЫТИЯ:</small>

            <div class="scrollbar-content">

                <div class="w-100 overflow-auto h-100">
                    
                    <ul class="d-flex flex-column align-items-start gap-1 m-0 p-0 w-100 gap-3">
                        
                        <?foreach($Result->data['items'] as $item){
                        
                            $createdAt = new DateTime($item['createdAt']);
                            $Code = $item['orderCode'];
                            $order_url = add_query_arg('Code', $Code, home_url('/order/')); ?>
                            
                            <li class="parameter-item d-flex flex-column w-100 justify-content-start">

                                <a class="black text-decoration-none" href="<?= esc_url($order_url) ?>">
                                    <strong>Заказ <?= esc_html($item['orderTitle']) ?></strong>
                                </a>
                                
                                <span class="small-font p-0 m-0 text-muted"><?= esc_html($createdAt->format('d.m.Y H:i:s')) ?></span>
                                <small class="text-muted"><?= esc_html($item['title']) ?></small>
                            
                            </li>

                        <?};?>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>
<?}?>