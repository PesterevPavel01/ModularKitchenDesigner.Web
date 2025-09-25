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
            <?get_template_part("parts/catalog/account/customer-order-list/template");?>
        </section>

        <section class="approval-section m-0 swiper-slide">
            <?get_template_part("parts/catalog/account/approval-customer-list/template");?>
        </section>
    </div>
</div>