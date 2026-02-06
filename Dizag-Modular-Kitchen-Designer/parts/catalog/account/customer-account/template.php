<?
if (function_exists('enqueue_template_part_styles_scripts')) {
    enqueue_template_part_styles_scripts(__DIR__, "customer-account");
}
?>

<?
$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
$userName = isset($args['USER']) ? sanitize_text_field($args['USER']) : '';
?>

<section class="customer-account-content d-flex flex-column align-items-start flex-lg-row w-100 flex-grow-1 gap-2 gap-sm-0 <?=(trim($role) === 'customer') ? "pt-2":""?>" id = "customer-account-content">

    <div class="customer-account-order-list col-12 col-lg-9 order-2 order-lg-1 h-100" id = "customer-account-order-list">

        <?get_template_part("parts/catalog/account/customer-order-list/template", null,                 
            [
                'PERIOD' => 30,
                'ASCENDING' => false,
                'INCOMPLETE_ONLY' => false,
                'CUSTOM_ONLY' => false,
                'ROLE' => $role
            ]);
        ?>
        
    </div>

    <div class="customer-account-additional-content d-flex flex-column ps-sm-2 order-1 order-lg-2 col-12 col-lg-3 order-1 order-lg-2 gap-2">

        <?if($role == 'customer'){?>
        
            <div class="add-new-order">

                <a href="<?=home_url('/order/')?>">

                    <div class="custom-btn black m-0 w-100"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top"    
                        title="Добавить новый заказ">
                        Новый заказ
                    </div>

                </a>
            </div>
        
        <?}?>

        <?get_template_part("parts/catalog/forms/order-list-parameters-form/template", null,                 
            [
                'ROLE' => $role,
                'USER' => $userName
            ]);?>

        <div class="last-events-section" id = "last-events-section">

            <?get_template_part("parts/catalog/account/last-events/template", null,                 
                [
                    'ROLE' => $role,
                    'USER' => $userName
                ]);?>

        </div>

    </div>

    <?if( $role == 'customer')
        get_template_part("parts/catalog/forms/remove-order-form/template");
    ?>

    <?get_template_part("parts/catalog/account/last-events/reset-last-events-form/template", null,                 
        [
            'ROLE' => $role,
            'USER' => $userName
        ]);?>
    

</section>