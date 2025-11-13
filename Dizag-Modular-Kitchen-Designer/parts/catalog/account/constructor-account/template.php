<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "constructor-account");//подключаю файл <style class="css"></style>
?>

<div  class="navigation-block update-trigger gap-2 d-flex justify-content-start align-items-center">
    <button type="button" class="ajax-update-button customer-order-list-on btn btn-primary  m-0 active"
        data-bs-toggle="tooltip" 
        data-bs-placement="top"    
        title="ЗАКАЗЫ">
        <span class="bi bi-journals"></span>
    </button>
    <button class="ajax-update-button customer-approval-list-on btn btn-primary m-0"
        data-bs-toggle="tooltip" 
        data-bs-placement="top"    
        title="КЛИЕНТЫ">
        <span class="bi bi-people-fill"></span>
    </button>
</div>

<div class="account-swiper">
    <div class="swiper-wrapper slider">
        <section class="customer-section m-0 swiper-slide">
            <?get_template_part("parts/catalog/account/customer-account/template");?>
        </section>

        <form class="approval-customer-section m-0 swiper-slide" id = "approval-customer-section" data-ajax-default-content-updater="refresh">
            
            <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#approval-customer-list">
            <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/account/approval-customer-list/template">
            <input type="hidden" id="action" name = "action" value="default_content_updater">
            <input type="hidden" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#approval-customer-list">

            <div class="approval-customer-list-section d-flex flex-column align-items-center justify-content-center w-100 gap-3" id = "approval-customer-list-section">
                <div class="customer-list-title-conteiner d-flex w-100 align-items-center justify-content-start gap-1">
                    <t2 class="title ps-2">Новые клиенты</t2>
                </div> 
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