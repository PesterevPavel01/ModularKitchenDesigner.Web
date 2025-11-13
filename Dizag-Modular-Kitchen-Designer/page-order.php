<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/PermissionProcessor.php';
require_once get_template_directory() . '/core/services/processors/catalog/orders/CreateOrderProcessor.php';

global $clientServiceUrl;
global $orderServiceUrl;

$current_user = wp_get_current_user();

if($current_user && is_user_logged_in()){

    $roles = $current_user->roles;

    if(in_array('constructor',$roles) || in_array('customer', $roles)){
    
        $Code = isset($_GET['Code']) ? sanitize_text_field(wp_unslash($_GET['Code'])) : '';

        if($Code === ''){
            
            $CreateOrderProcessor = new CreateOrderProcessor($orderServiceUrl);
            
            $Result = $CreateOrderProcessor->Process([
                'userName' => $current_user->user_login
            ]);

            if(!$Result->isSuccess()){
                ?><p class="error-message black"><?=esc_html($Result->ErrorMessage)?></p><?
                return;
            }

            $order_url = add_query_arg('Code', $Result->data["code"], home_url('/order/'));

            wp_redirect($order_url);

            exit;
        }    
    }
}

get_header(); 
the_content();
?>

<header>
    <?get_template_part("parts/navigation/preloader")?>
    <?get_template_part("parts/navigation/navbar")?>
</header>

<main class = "white-background">

    <section class="section-content flex-column gap40 mx-width-1380 m-auto">
        
        <?
        if(!is_user_logged_in())
        {
            get_template_part("parts/navigation/authorization",null,
            [
                'ERROR_MESSAGE' => "Для получения доступа необходимо",
            ]);
            return;
        }

        if($current_user && is_user_logged_in()){

            if(!in_array('constructor',$roles) && !in_array('customer', $roles)){

                $Result = new BaseResult();

                $PermissionProcessor = new PermissionProcessor($clientServiceUrl);
            
                $Result = $PermissionProcessor->Process(sanitize_user($current_user->user_login));
                
                if(!$Result->isSuccess() || !in_array('customer', $Result->data["roles"]) || $Result->data["externalId"] == "none"){
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
                }else
                {
                    ?><p class="error-message black">У пользователя нет необходимых прав, обратитесь к администратору!</p><?
                }
                return;
            }

        }
        
        if (!empty($Code)) {?>

            <section id = "catalog-section-order" class="section-order d-flex flex-column align-items-start gap-3 w-100 catalog_content_update">
            
                <?get_template_part("parts/catalog/orders/order/template",null,
                [
                    'ORDER_CODE' =>  $Code
                ]);?>

            </section>

            <?get_template_part("parts/catalog/orders/remove-order-item-form/template");?>
            
        <?}?>
        
    </section>

</main>

<?php get_footer();?>