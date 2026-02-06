<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "constructor-account");//подключаю файл <style class="css"></style>

$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
$userName = isset($args['USER']) ? sanitize_text_field($args['USER']) : '';
?>

<div  class="catalog-navbar navigation-block update-trigger gap-2 d-flex justify-content-start align-items-center p-0 m-1 w-100">

    <div class="catalog-nav-link switch-button customer-order-list-on m-0 active m-0 pointer user-select-none">

        <div class="d-flex">
            <?/*<span class="bi bi-journals"></span>*/?>
            <t2 class="p-0 m-0">ЗАКАЗЫ</t2>
        </div>

    </div>

    <div class="catalog-nav-link switch-button customer-approval-list-on m-0 p-1 pointer user-select-none">
        <div class="d-flex">
            <?/*<span class="bi bi-people-fill"></span>*/?>
            <t2 class="p-0 m-0">КЛИЕНТЫ</t2>
        </div>
    </div>

</div>

<div class="account-swiper">
    <div class="swiper-wrapper slider h-100">
        <section class="customer-section m-0 p-0 swiper-slide h-100">
            <?get_template_part("parts/catalog/account/customer-account/template", null,
                [
                    'ROLE' => $role,
                    'USER' => $userName
                ]);?>
        </section>

        <form class="approval-customer-section m-0 swiper-slide h-100" id = "approval-customer-section" data-ajax-default-content-updater="refresh">
            
            <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#approval-customer-list">
            <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/account/approval-customer-list/template">
            <input type="hidden" id="action" name = "action" value="default_content_updater">
            <input type="hidden" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#approval-customer-list">

            <div class="approval-customer-list-section d-flex flex-column align-items-center justify-content-center w-100 gap-3 h-100" id = "approval-customer-list-section">
                <div class="approval-customer-list d-flex flex-column align-items-start justify-content-start w-100" id = "approval-customer-list">
                    <?get_template_part("parts/catalog/account/approval-customer-list/template");?>
                </div>
            </div>

        </form>
    </div>
</div>

<?get_template_part("parts/catalog/account/approval-form/template");?>
<?get_template_part("parts/catalog/account/remove-customer-form/template");?>
<??>