<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderByCodeProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/modules/ModuleProvider.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemQuantityClient.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderItemCreator.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/OrderApprovalWorkflowLoaderProcessor.php';

global $orderServiceUrl;
global $moduleServiceUrl;
global $approvalServiceUrl;

$errors = 0;

$Result = new BaseResult();

$current_user = wp_get_current_user();

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";

$orderCode = sanitize_text_field($args['ORDER_CODE']);

$moduleCode = sanitize_text_field($args['MODULE_CODE']);

$OrderApprovalWorkflowLoaderProcessor = new OrderApprovalWorkflowLoaderProcessor($approvalServiceUrl);

$Result = $OrderApprovalWorkflowLoaderProcessor->Process(sanitize_text_field($orderCode));

if(!$Result->isSuccess())
{

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => $Result->ErrorMessage,
            'MESSAGE' => $Result->data
        ]);

    $errors++;

    return;
}

$workflows = $Result->data;

if(!empty($workflows) && !$moduleCode ){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => "У заказа запущен процесс согласования",
        'MESSAGE' => "Не удалось добавить новый модуль!"
    ]);

    $errors++;
}

if($moduleCode && !empty($workflows))
{
    $moduleWorkflow = [];

    $moduleWorkflow = array_filter($workflows, function($item) use ($moduleCode)
        {
            return $item['orderItem']['module']['moduleCode'] === $moduleCode;
        }
    );

    $moduleWorkflow = reset($moduleWorkflow);  

    if(!empty($moduleWorkflow) && $moduleWorkflow['isCompleted']){

        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => "У модуля завершен процесс согласования",
            'MESSAGE' => "Невозможно изменить модуль!"
        ]);

        $errors++;
    }

}
?>

<?
if(!isset($args['MEMBRANE']) || trim($args['MEMBRANE']) === '' || $args['MEMBRANE'] === "0"){
    
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Пленка - обязательное поле!',
    ]);

    $errors++;
}

if(!isset($args['LENGTH']) || trim($args['LENGTH']) === ''){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Высота - обязательное поле!',
    ]);

    $errors++;
}

if(!isset($args['WIDTH']) || trim($args['WIDTH']) === ''){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Ширина - обязательное поле!',
    ]);

    $errors++;
}

if(!isset($args['QUANTITY']) || trim($args['QUANTITY']) === ''){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Количество - обязательное поле!',
    ]);

    $errors++;
}

if(isset($args['QUANTITY']) && trim($args['QUANTITY']) === '0'){

    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Количество не может быть меньше 1!',
    ]);

    $errors++;
}

if(!isset($args['CORNER']) || trim($args['CORNER']) === '' || $args['CORNER'] === "0"){
    
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Кромка - обязательное поле!',
    ]);

    $errors++;
}

if(!isset($args['MILLING']) || trim($args['MILLING']) === '' || $args['MILLING'] === "0"){
        
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => 'Внимание! Фрезеровка - обязательное поле!',
    ]);

    $errors++;
}

if($errors === 0)
{
    $ModuleProvider = new ModuleProvider($moduleServiceUrl, $user);

    $arParams = $args;

    if($arParams['MILLING'] === "CUSTOM_MILLING")
        $arParams['MILLING'] = $arParams['CUSTOM_MILLING_COMPONENT_CODE'];

    if($arParams['HINGE'] === "CUSTOM_HINGE")
        $arParams['HINGE'] = $arParams['CUSTOM_HINGE_COMPONENT_CODE'];

    if(!$moduleCode)
    {
        $Result = $ModuleProvider->Create($arParams);

        if(!$Result->isSuccess())
        {

            get_template_part("parts/catalog/errors/default-error-message/template", null, 
                [
                    'TITLE' => $Result->ErrorMessage,
                    'MESSAGE' => $Result->data
                ]);

            $errors++;
        }

        if($Result->isSuccess()){

            $arParams['MODULE_CODE'] = sanitize_text_field($Result->data['moduleCode']);

            $moduleCode = sanitize_text_field($Result->data['moduleCode']);

            $OrderItemCreator = new OrderItemCreator($orderServiceUrl, $user);

            $Result = $OrderItemCreator->Execute($orderCode, $moduleCode, absint(sanitize_text_field($arParams['QUANTITY'])));

            if(!$Result->isSuccess())
            {
                if(trim($Result->data) === 'Order is completed!'){

                            
                    get_template_part("parts/catalog/errors/default-error-message/template", null, 
                    [
                        'TITLE' => 'Новые модули не могут быть добавлены, т.к. заказ завершен!',
                    ]);
                    
                }else{?>
                        
                    <?get_template_part("parts/catalog/errors/default-error-message/template", null, 
                        [
                            'TITLE' => $Result->ErrorMessage,
                            'MESSAGE' => $Result->data
                        ]);?>

                <?}

                $errors++;
            }
        }

    }else{

        $OrderItemQuantityClient = new OrderItemQuantityClient($orderServiceUrl, $user);
    
        $Result = $OrderItemQuantityClient->Execute($orderCode, $moduleCode, absint(sanitize_text_field($arParams['QUANTITY'])));

        if(!$Result->isSuccess()){

            get_template_part("parts/catalog/errors/default-error-message/template", null, 
            [
                'TITLE' => $Result->ErrorMessage,
                'MESSAGE' => $Result->data
            ]);

            $errors++;
        }

        //Повторно проверяем наличие ошибок, они могли появиться
        if($errors === 0)
        {
            if($Result->isSuccess())
                $Result = $ModuleProvider->Update($arParams);

            if(!$Result->isSuccess())
            {
                get_template_part("parts/catalog/errors/default-error-message/template", null, 
                [
                    'TITLE' => $Result->ErrorMessage,
                    'MESSAGE' => $Result->data
                ]);

                $errors++;
            }
        }
    }
}

if ($errors !== 0 && isset($GLOBALS['set_template_data']) && is_callable($GLOBALS['set_template_data'])) {

    $GLOBALS['set_template_data']('ERRORS', true);

}
else{

    $OrderByCodeProcessor = new OrderByCodeProcessor($orderServiceUrl);

    $Result = $OrderByCodeProcessor->Process($orderCode);

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

    if($orderCode && $role !=='constructor' && trim($user) !== trim($order['userName']) ){

        get_template_part("parts/catalog/errors/default-error-message/template", null, 
        [
            'TITLE' => 'У пользователя нет необходимых прав!'
        ]);

        return;
    }

    $activeOrderItem = array_filter($order['modules'], function($item) use ($moduleCode)
        {
            return $item['module']['moduleCode'] === $moduleCode;
        });

    $activeOrderItem = reset($activeOrderItem);
  
    get_template_part("parts/catalog/orders/facade-configurator/template",null,
    [
        'ORDER_CODE' =>  $orderCode,
        'MODULE' =>  $activeOrderItem['module'],
        'QUANTITY' => $activeOrderItem['quantity'],
        'MODULE_CODE' => $moduleCode,
        'IS_COMPLETED' => $order['isCompleted'],
        'USER' => $user,
        'ROLE' => $role,
    ]);

}