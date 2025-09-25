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

        if($Result->isSuccess() && in_array('customer', $Result->data["roles"])){
            ?>
                <section class="section-custormer-account account-trigger-form">
                    <?get_template_part("parts/catalog/account/customer-account/template");?>
                </section>
            <?
        }
        elseif($Result->isSuccess() && in_array('constructor', $Result->data["roles"])){
            ?>
                <section class="section-constructor-account account-trigger-form">
                    <?get_template_part("parts/catalog/account/constructor-account/template");?>
                </section>
            <?
        }else{
        ?>
            <section class="permission-request-section ajax-update-trigger flex-column gap40">
                <?get_template_part("parts/catalog/account/permission-request",null,
                    [
                        'ACTION' => 'content_update',
                        'PARAMETER' =>  null,
                        'TEMPLATE_PART_TO_UPDATE' => "parts/catalog/account/permission-request",
                        'HTML_BLOCK_TO_UPDATE_CLASS' => 'permission-request-section',
                    ]);?>
            </section>
        <?
        }
    }else
    {
        ?><p class="error-message black">У пользователя нет необходимых прав, обратитесь к администратору!</p><?
    }

}?>