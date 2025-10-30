<?
require_once get_template_directory() . '/core/services/processors/catalog/user/UserPasswordProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/UserRegistrationProcessor.php';
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/PermissionProcessor.php';

$inputParameter = isset($args['PARAMETER']) ? $args['PARAMETER'] : null;

global $clientServiceUrl;

$current_user = wp_get_current_user();

$login = $current_user->user_login;

if($inputParameter){
    
    $UserPasswordProcessor = new UserPasswordProcessor();

    $password = $UserPasswordProcessor->Process();
    
    $customerResult = new BaseResult();

    $UserRegistrationProcessor = new UserRegistrationProcessor($clientServiceUrl);

    $roles = $current_user->roles;

    if($current_user){
    
        if(in_array('constructor',$roles))
            $role = 'constructor';
        elseif(in_array('customer',$roles))
            $role = 'customer';
    }

    $customerResult = $UserRegistrationProcessor->Process($login, $password, $role);

    if(!$customerResult->isSuccess())
    {?>
        <p><?=esc_html($customerResult->ErrorMessage)?></p>
        <?return;
    }
}

$Result = new BaseResult();

$PermissionProcessor = new PermissionProcessor($clientServiceUrl);

$Result = $PermissionProcessor->Process($current_user->user_login);

if(!$Result->isSuccess())
{
    if($Result->ErrorMessage === "User not found!")
    {?>
        <p class="error-message black p-3">У пользователя нет необходимых прав, обратитесь к администратору!</p>
        <block class = "permission-request-section p-3" id = "permission-request-section">
            <button type="submit" class = "custom-btn black ajax-update-button" id = "permission-request-btn" type="submit">
                <input type = "hidden" id="value" name="PARAMETER" value="<?=esc_attr($current_user->user_login)?>">
                <label>Отправить запрос</label>
            </button>
        </block>
    <?
    }
}else{
    ?>
        <p class="black">Заявка на получение прав в обработке!</p>
    <?
}

?>