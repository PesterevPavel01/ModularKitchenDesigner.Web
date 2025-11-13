<?
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/PermissionProcessor.php';

global $clientServiceUrl;

$current_user = wp_get_current_user();

$roles = $current_user->roles;

if($current_user){

    if(in_array('constructor',$roles) || in_array('customer', $roles)){

        $Result = new BaseResult();

        $PermissionProcessor = new PermissionProcessor($clientServiceUrl);
    
        $Result = $PermissionProcessor->Process($current_user->user_login);

        if($Result->isSuccess() && in_array('customer', $Result->data["roles"]) && $Result->data["externalId"] != "none"){
            ?>
                <section class="section-custormer-account account-trigger-form">
                    <?get_template_part("parts/catalog/account/customer-account/template", null, ['ROLE' => 'customer']);?>
                </section>
            <?
        }
        elseif($Result->isSuccess() && in_array('constructor', $Result->data["roles"]) && $Result->data["externalId"] != "none"){
            ?>
                <section class="section-constructor-account account-trigger-form">
                    <?get_template_part("parts/catalog/account/constructor-account/template", null, ['ROLE' => 'constructor']);?>
                </section>
            <?
        }else{
        ?>
            <form class="permission-request-section  <?/*ajax-update-trigger*/?> flex-column gap40" data-ajax-default-content-updater="refresh">
                
                <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#permission-request-section-content">
                <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/account/permission-request">
                <input type="hidden" id="action" name = "action" value="default_content_updater">
                <input type="hidden" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#permission-request-section-content">

                <div class="permission-request-section-content" id = "permission-request-section-content">
                    <?get_template_part("parts/catalog/account/permission-request",null,
                        [
                            'PARAMETER' =>  null,
                        ]);?>
                </div>
            </form>
        <?
        }
    }else
    {
        ?><p class="error-message black">У пользователя нет необходимых прав, обратитесь к администратору!</p><?
    }

}?>