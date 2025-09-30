<?php
require_once get_template_directory() . '/core/Result.php';
require_once get_template_directory() . '/core/services/processors/catalog/user/PermissionProcessor.php';

get_header(); ?>

<header>
    <?get_template_part("parts/navigation/preloader")?>
    <?get_template_part("parts/navigation/navbar")?>
</header>
<main>

    <section class="section-content white-background flex-column gap40">

    <?$current_user = wp_get_current_user();

    $roles = $current_user->roles;

    if($current_user && is_user_logged_in()){

        if(!in_array('constructor',$roles) && !in_array('customer', $roles)){

            $Result = new BaseResult();

            $PermissionProcessor = new PermissionProcessor($clientServiceUrl);
        
            $Result = $PermissionProcessor->Process($current_user->user_login);

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

    }elseif(!is_user_logged_in())
    {
        get_template_part("parts/navigation/authorization",null,
        [
            'ERROR_MESSAGE' => "Для получения доступа необходимо",
        ]);
        return;
    }?>

    <?php
    // В файле page-order.php или шаблоне
    $Code = isset($_GET['Code']) ? sanitize_text_field($_GET['Code']) : '';

    if (!empty($Code)) {
        print_r('Код заказа: ' . esc_html($Code));
        print_r("<br><br>");
    }else

    global $clientServiceUrl;

    print_r('Новый заказ');
    print_r("<br><br>");
    ?>

        <p class="black">Страница в разработке</p>
    </section>
</main>
<?php get_footer();?>


<?