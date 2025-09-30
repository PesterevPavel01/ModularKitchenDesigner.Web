<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "customer-account");//подключаю файл <style class="css"></style>
?>

<section class="customer-order-list d-flex flex-column align-items-start gap20 flex-lg-row w-100 catalog_content_update">

    <?get_template_part("parts/catalog/account/customer-order-list/template", null,                 
        [
            'PARAMETER' =>  [
                'PERIOD' => 30,
                'ASCENDING' => false,
                'INCOMPLETE_ONLY' => false,
                'CUSTOM_ONLY' => false
            ]
        ]);
    ?>

    <section class="order-list-parameters-section flex-column align-items-start justify-content-start gap20 m-0  order-1 order-lg-2">
        
        <t2 class="title">Параметры</t2>

        <ul class="parameters-section d-flex flex-column align-items-start justify-content-start gap10 white-background m-0 " id = "catalog-order-list-ajax-trigger-conteiner">

            <input type="hidden" id="catalog-order-list-template_part_to_update" value=<?="parts/catalog/account/customer-order-list/template"?>>
            <input type="hidden" id="catalog-order-list-html_block_to_update" value=<?="customer-account-oder-list-section"?>>

            <li class="parameter-item d-flex w-100 justify-content-start">
                <div class="approval-orders-only d-flex align-items-center w-100 gap6">
                    <span class="checkbox_label">Период, дн.</span>
                    <input type="number" step="1" min="0" max="100" value="30" class="period" name="period" id = "catalog-order-list-period"/>
                </div>
            </li>

            <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="catalog-order-list-incomplete-only">
                <span class="checkbox_label">только активные заказы</span>
            </li>

            <li class="parameter-item-approval d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="catalog-order-list-custom-only">
                <span class="checkbox_label">только на согласовании</span>
            </li>

            <li class="parameter-item-sort d-flex align-items-center w-100 gap6justify-content-start gap6">
                <input class="custom-checkbox border-primary" type="checkbox" id="catalog-order-list-ascending">
                <span class="checkbox_label">сначала старые заказы</span>
            </li>

            <button class="btn btn-primary w-100 catalog-ajax-button" id = "order-list-parameters-button">
                <span class="btn_label">Применить</span>
                <span class="bi bi-arrow-repeat"></span>
            </button>

        </ul>

        <t2 class="title">Последняя активность</t2>

        <ul class="new-comments-block d-flex flex-column align-items-start justify-content-start w-100 gap10 white-background m-0">
            
            <li class="parameter-item-active d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title"           
                    data-bs-toggle="tooltip" 
                    data-bs-placement="right"
                    title="<?=htmlspecialchars("Номер заказа: 18.09.2025 9:59:56.303272 какой-то еще текст, "
                    . "который содержится в названии заказа или дополнительная информация о заказе, которую нужно "
                    . "показывать пользователю")?>">
                    заказ 18.09.2025</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>
            <li class="parameter-item-active d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title"           
                    data-bs-toggle="tooltip" 
                    data-bs-placement="right"
                    title="<?="Номер заказа: 18.09.2025 9:59:56.303272 какой-то еще текст, "
                    ."который содержится в названии заказа или дополнительная информация о заказе, которую нужно "
                    ."показывать пользователю"?>">
                    заказ 18.09.2025</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

            <li class="parameter-item-approval d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title"           
                    data-bs-toggle="tooltip" 
                    data-bs-placement="right"
                    title="<?="Номер заказа: 18.09.2025 9:59:56.303272 какой-то еще текст, "
                    ."который содержится в названии заказа или дополнительная информация о заказе, которую нужно "
                    ."показывать пользователю"?>">
                    заказ 18.09.2025</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

            <li class="parameter-item-sort d-flex align-items-center w-100 justify-content-between gap6">
                <span class="order-title"           
                    data-bs-toggle="tooltip" 
                    data-bs-placement="right"
                    title="<?="Номер заказа: 18.09.2025 9:59:56.303272 какой-то еще текст, "
                    ."который содержится в названии заказа или дополнительная информация о заказе, которую нужно "
                    ."показывать пользователю"?>">
                    заказ 18.09.2025</span>
                <button class="btn btn-primary">
                    <span class="btn_label">Смотреть</span>
                </button>
            </li>

        </ul>

    </section>

</section>