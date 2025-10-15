<?
if (function_exists('enqueue_template_part_styles_scripts')) {
    enqueue_template_part_styles_scripts(__DIR__, "customer-account");
}
?>

<?
$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
?>
<section class="customer-account-content d-flex flex-column align-items-start gap-3 flex-lg-row w-100" id = "customer-account-content">

    <div class="customer-account-order-list w-100" id = "customer-account-order-list">
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

    <form class="order-list-parameters-form d-flex flex-column align-items-start justify-content-start gap-3 m-0  order-1 order-lg-2" id = "order-list-parameters-form" data-ajax-default-content-updater="refresh">
        
        <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#customer-account-content">
        <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value= "parts/catalog/account/customer-order-list/template">
        <input type="hidden" id="action" name = "action" value="default_content_updater">
        <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#customer-account-order-list">
        <input type="hidden" id="ROLE"  name = "TARGET_CONTEINER" value="<?=$role?>">

        <t2 class="title ps-2">Параметры</t2>

        <ul class="parameters-section d-flex flex-column align-items-start justify-content-start gap10 white-background m-0 p-4">

            <li class="parameter-item d-flex w-100 justify-content-start">
                <div class="approval-orders-only d-flex align-items-center w-100 gap6">
                    <span class="checkbox_label">Период, дн.</span>
                    <input type="number" name = "PERIOD" step="1" min="0" max="100" value="30" class="period" id = "catalog-order-list-period"/>
                </div>
            </li>

            <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" name = "INCOMPLETE_ONLY" type="checkbox" id="catalog-order-list-incomplete-only">
                <span class="checkbox_label">только активные заказы</span>
            </li>

            <li class="parameter-item-approval d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" name = "CUSTOM_ONLY" type="checkbox" id="catalog-order-list-custom-only">
                <span class="checkbox_label">только на согласовании</span>
            </li>

            <li class="parameter-item-sort d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" name = "ASCENDING" type="checkbox" id="catalog-order-list-ascending">
                <span class="checkbox_label">сначала старые заказы</span>
            </li>

            <button type="submit" class="btn btn-primary w-100 mt-2">
                <span class="btn_label">Применить</span>
                <span class="bi bi-arrow-repeat"></span>
            </button>

        </ul>
    </form>

    <?
    if( $role == 'customer')
        get_template_part("parts/catalog/orders/remove-order-form/template");
    ?>

</section>