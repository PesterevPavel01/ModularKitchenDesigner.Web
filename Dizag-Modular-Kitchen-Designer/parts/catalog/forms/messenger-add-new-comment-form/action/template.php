<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/messages/command/AddNewMessage.php';

global $orderServiceUrl;

$moduleCode = isset($args['MODULE_CODE']) ? sanitize_text_field($args['MODULE_CODE']) : "";

if($moduleCode === "")
    return;

$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

if($orderCode === "")
    return;

$errors = 0;

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

$message = isset($args['TEXT']) ? sanitize_text_field($args['TEXT']) : "";

$Result = new BaseResult();

$addNewMessage = new AddNewMessage($orderServiceUrl);

$Result = $addNewMessage->Execute($orderCode,$moduleCode, $user, $message);

if(!$Result->isSuccess())
{
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => $Result->ErrorMessage,
        'MESSAGE' => $Result->data
    ]);

    $errors++;
}

if ($errors !== 0 && isset($GLOBALS['set_template_data']) && is_callable($GLOBALS['set_template_data'])) {

    $GLOBALS['set_template_data']('ERRORS', true);

}

