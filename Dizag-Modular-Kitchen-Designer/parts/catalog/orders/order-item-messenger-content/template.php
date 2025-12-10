<?
enqueue_template_part_styles_scripts( __DIR__, "catalog-order-item-messenger");
?>
<?
$moduleCode = isset($args['MODULE_CODE']) ? sanitize_text_field($args['MODULE_CODE']) : "";

if($moduleCode === ""){
    return;
}

$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

if($orderCode === ""){
  
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Параметер "Код заказа" не найден!'
    ]);

    return;
}

$messages = isset($args['MASSAGES']) ? $args['MASSAGES'] : [];
?>

<ul class="transition-all order-item-message-list w-100 white-background rounded p-0 p-lg-2 m-0 shadow-sm">

    <div class="order-item-message-list-content p-2 p-lg-0 m-0 d-flex flex-column w-100 gap-1">
    
        <?foreach($messages as $message){

            $constructor = array_filter($message['senderRoles'], function($item)
                {
                    return $item === 'constructor';
                }
            );

            if(empty($constructor)){

                $customer = array_filter($message['senderRoles'], function($item)
                {
                    return $item === 'customer';
                });

                if(empty($customer)){

                    get_template_part("parts/catalog/errors/default-error-message/template", null, 
                    [
                        'TITLE' => 'Не найдена роль отправителя у сообщения!'
                    ]);
                
                    return;
                }

                $role = "Клиент";

            }else{
            
                $role = "Конструктор";

            }
            
            $dateString = $message['createdAt'];
            $date = DateTime::createFromFormat('Y-m-d\TH:i:s.u', $dateString);
            $formattedDate = $date->format('d.m.Y H:i:s');

            ?>
            <li class="order-item-message d-flex w-100 m-0">

                <ul class="d-flex flex-column w-100 border border-secondary rounded p-1" id = "123">
    
                    <li class="component-panel-controls w-100">
                        <span class = "small-font p-0 m-0"><?=$formattedDate?></span>
                        <span class = "small-font"><?=$role?>:</span>
                    </li>
                    <li class="component-panel-controls d-flex flex-column w-100 gap-1">
                        <span class="w-100 black mini-font"><?=$message['text']?></span>
                    </li>

                </ul>

            </li>

        <?}
        
        if(!$args['IS_COMPLETED']){

            $user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

            $role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

            get_template_part("parts/catalog/forms/messenger-add-new-comment-form/template", null,
                [
                    'MODULE_CODE' => $moduleCode,
                    'ORDER_CODE' => $orderCode,
                    'USER' => $user, 
                    'ROLE' => $role
                ]);
        }?>

    </div>
</ul>
