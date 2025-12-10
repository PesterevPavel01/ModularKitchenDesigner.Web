<?
if (function_exists('enqueue_template_part_styles_scripts')) {
    enqueue_template_part_styles_scripts(__DIR__, "customer-account");
}
?>

<?
$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
?>
<section class="customer-account-content d-flex flex-column align-items-start flex-lg-row w-100 gap-2 gap-lg-0" id = "customer-account-content">

    <div class="customer-account-order-list col-12 col-lg-9 order-2 order-lg-1" id = "customer-account-order-list">

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

    <?get_template_part("parts/catalog/forms/order-list-parameters-form/template", null,                 
        [
            'ROLE' => $role
        ]);

    if( $role == 'customer')
        get_template_part("parts/catalog/forms/remove-order-form/template");
    ?>

</section>