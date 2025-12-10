<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/messages/queries/GetMessagesByOrderCode.php';

global $orderServiceUrl;

$moduleCode = isset($args['MODULE_CODE']) ? sanitize_text_field($args['MODULE_CODE']) : "";

$errors = 0;

if($moduleCode === ""){

    get_template_part("parts/catalog/forms/messenger-reset-message-counter-form/template",null,
    [
        'MESSEGE_COUNTER_VALUE' => ""
    ]);

    return;

}else{

    $orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

    if($orderCode === ""){
    
        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => 'Параметер "Код заказа" не найден!'
        ]);

        $errors ++;
    }

    if($errors === 0)
    {
        $Result = new BaseResult();

        $getMessagesByOrderCode = new GetMessagesByOrderCode($orderServiceUrl);

        $Result = $getMessagesByOrderCode->Execute($orderCode);

        if(!$Result->isSuccess())
        {
            get_template_part("parts/catalog/errors/default-error-message/template", null, 
            [
                'TITLE' => $Result->ErrorMessage,
                'MESSAGE' => $Result->data
            ]);
            
            $errors ++;

        }
    }

    if($errors === 0){        

        $messages = [];

        $messages = array_filter($Result->data, function($item) use ($moduleCode)
            {
                return $item['moduleCode'] === $moduleCode;
            }
        );

        $user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

        $role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

        get_template_part("parts/catalog/orders/order-item-messenger-content/template", null,
        [
            'MASSAGES' => $messages,
            'MODULE_CODE' => $moduleCode,
            'ORDER_CODE' => $orderCode,
            'USER' => $user, 
            'ROLE' => $role,
            'IS_COMPLETED' => $args['IS_COMPLETED']
        ]);  

        get_template_part("parts/catalog/forms/messenger-reset-message-counter-form/template",null,
        [
            'MESSEGE_COUNTER_VALUE' => count($messages),
        ]);
    }
    
}

if ($errors !== 0 && isset($GLOBALS['set_template_data']) && is_callable($GLOBALS['set_template_data'])) {

    $GLOBALS['set_template_data']('ERRORS', true);

}
?>