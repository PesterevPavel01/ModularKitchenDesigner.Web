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

}

$Result = new BaseResult();

$PermissionProcessor = new PermissionProcessor($clientServiceUrl);

$Result = $PermissionProcessor->Process($current_user->user_login);

if(!$Result->isSuccess())
{
    if($Result->ErrorMessage === "User not found!")
    {?>
        <input type="hidden" id="action" value=<?=$args["ACTION"]?>>
        <input type="hidden" id="template_part_to_update" value=<?=$args["TEMPLATE_PART_TO_UPDATE"]?>>
        <input type="hidden" id="html_block_to_update" value=<?=$args['HTML_BLOCK_TO_UPDATE_CLASS']?>>
        <input type="hidden" id="sub-action" value=<?=$args['PARAMETERS']['ACTION']?>>
        <p class="error-message black">У пользователя нет необходимых прав, обратитесь к администратору!</p>
        <block class = "permission-request-section" id = "permission-request-section">
            <div class = "custom-btn black ajax-update-button" id = "permission-request-btn" type="submit">
                <input type = "hidden" id="value" value="<?=$current_user->user_login?>">
                <label>Отправить запрос</label>
            </div>
        </block>
    <?
    }
}else{
    ?>
        <p class="black">Заявка на получение прав в обработке!</p>
    <?
}

?>