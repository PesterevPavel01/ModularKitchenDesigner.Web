<?
if (function_exists('enqueue_template_part_styles_scripts')) {
    enqueue_template_part_styles_scripts(__DIR__, "customer-account");
}
?>

<?
$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
?>
<section class="customer-account-content d-flex flex-column align-items-start flex-lg-row w-100" id = "customer-account-content">

    <div class="customer-account-order-list col-12 col-lg-9" id = "customer-account-order-list">

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

    <form class="order-list-parameters-form order-1 order-lg-2 col-12 col-lg-3" id = "order-list-parameters-form" data-ajax-default-content-updater="refresh">
        
        <div class="order-list-parameters-form-content d-flex flex-column align-items-start justify-content-start gap-2 m-0 ms-3">

            <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#customer-account-content">
            <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value= "parts/catalog/account/customer-order-list/template">
            <input type="hidden" id="action" name = "action" value="default_content_updater">
            <input type="hidden" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#customer-account-order-list">
            <input type="hidden" id="ROLE"  name = "ROLE" value="<?=$role?>">

            <t2 class="title ps-2">Параметры</t2>

            <ul class="parameters-section d-flex flex-column align-items-start justify-content-start gap-1 white-background m-0 p-4 w-100 shadow-sm">

                <li class="parameter-item d-flex w-100 justify-content-start">
                    <div class="approval-orders-only d-flex align-items-center w-100 gap6">
                        <small class="checkbox_label">Период, дн.</small>
                        <input type="number" name = "PERIOD" step="1" min="0" max="100" value="30" class="period" id = "catalog-order-list-period"/>
                    </div>
                </li>

                <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "INCOMPLETE_ONLY" type="checkbox" id="catalog-order-list-incomplete-only">
                    <small class="checkbox_label">только активные заказы</small>
                </li>

                <li class="parameter-item-approval d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "CUSTOM_ONLY" type="checkbox" id="catalog-order-list-custom-only">
                    <small class="checkbox_label">только на согласовании</small>
                </li>

                <li class="parameter-item-sort d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "ASCENDING" type="checkbox" id="catalog-order-list-ascending">
                    <small class="checkbox_label">сначала старые заказы</small>
                </li>

                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <span class="btn_label">Применить</span>
                    <span class="bi bi-arrow-repeat"></span>
                </button>

            </ul>

        </div>

    </form>

    <?
    if( $role == 'customer')
        get_template_part("parts/catalog/orders/remove-order-form/template");
    ?>

</section>