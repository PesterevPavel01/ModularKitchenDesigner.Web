<?
require_once get_template_directory() . '/core/services/processors/catalog/user/UserPasswordProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/AuthorizationProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/CustomerRoleSetterProcessor.php';

global $clientServiceUrl;

$customer_code = sanitize_text_field($args['CUSTOMER_CODE']);
$cleaned_external_id = preg_replace('/\s+/', '', $customer_code);
    
    // Валидация
$is_valid = strlen($cleaned_external_id) >= 9;

if (!$is_valid){
    print_r('Код должен содержать не менее 9 символов');
    return;
}

$UserPasswordProcessor = new UserPasswordProcessor();

$password = $UserPasswordProcessor->Process();   

$current_user = wp_get_current_user();

$login = $current_user->user_login;

$AuthorizationProcessor = new AuthorizationProcessor($clientServiceUrl);

$tokenResult = $AuthorizationProcessor->Process($login, $password);

if(!$tokenResult->isSuccess())
{?>
    <p class="error-message"><?=$tokenResult->ErrorMessage?></p>
    <?return;
}

$CustomerRoleSetterProcessor = new CustomerRoleSetterProcessor($clientServiceUrl);


if(!$args["CUSTOMER_LOGIN"]){
    print_r('параметер "CUSTOMER_LOGIN" не найден!');
    print_r("<br><br>");      
}

$result = $CustomerRoleSetterProcessor->Process(sanitize_text_field($args["CUSTOMER_LOGIN"]), $cleaned_external_id, $tokenResult->data);

if(!$result->isSuccess())
{?>
    <p class="error-message"><?=$result->ErrorMessage?></p>
    <?return;
}
?>
<p class="error-message black w-100 p-1 text-center">Выполнено!</p>