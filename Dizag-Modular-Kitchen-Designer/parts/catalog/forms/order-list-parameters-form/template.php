<?
enqueue_template_part_styles_scripts( __DIR__, "order-list-parameters-form");
$role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : '';
?>

<form class="order-list-parameters-form" id = "order-list-parameters-form" data-ajax-default-content-updater="refresh">
        
        <div class="order-list-parameters-form-content d-flex flex-column align-items-start justify-content-start gap-2 m-0">

            <input type="hidden" data-no-reset="true" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#customer-account-content">
            <input type="hidden" data-no-reset="true" id="TEMPLATE_PART" name = "TEMPLATE_PART" value= "parts/catalog/account/customer-order-list/template">
            <input type="hidden" data-no-reset="true" id="action" name = "action" value="default_content_updater">
            <input type="hidden" data-no-reset="true" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#customer-account-order-list">
            <input type="hidden" data-no-reset="true" id="ROLE"  name = "ROLE" value="<?=$role?>">

            <?/*<t2 class="title ps-2">Параметры</t2>*/?>

            <ul class="parameters-section d-flex flex-column align-items-start justify-content-start gap-1 white-background m-0 p-4 pe-0 w-100 shadow-lg shadow-lg-sm">

                <?if($role === 'constructor'){?>

                    <li class="parameter-item d-flex w-100 justify-content-start pb-2 pe-4">
                        <div class="d-flex flex-column align-items-start w-100">
                            <small class="checkbox_label text-start primary-dark m-0 p-0 ps-1">ПОИСК:</small>
                            <input type="number" class ="w-100 m-0 border" name = "TITLE_PATTERN" step="1" min="0" placeholder="Введите номер заказа">
                        </div>
                    </li>
                    
                <?}?>

                <li class="parameter-item d-flex w-100 justify-content-start">
                    <div class="approval-orders-only d-flex align-items-center w-100 gap6">
                        <small class="checkbox_label primary-dark">Период, дн.</small>
                        <input type="number" name = "PERIOD" step="1" min="0" max="100" value="30" class="period border" id = "catalog-order-list-period"/>
                    </div>
                </li>

                <li class="parameter-item-active d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "INCOMPLETE_ONLY" type="checkbox" id="catalog-order-list-incomplete-only">
                    <small class="checkbox_label">только активные заказы</small>
                </li>

                <li class="parameter-item-approval d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "CUSTOM_ONLY" type="checkbox" id="catalog-order-list-custom-only">
                    <small class="checkbox_label">только нестандартные</small>
                </li>

                <li class="parameter-item-sort d-flex align-items-center w-100 gap6justify-content-start gap6">
                    <input class="custom-checkbox border-primary" name = "ASCENDING" type="checkbox" id="catalog-order-list-ascending">
                    <small class="checkbox_label">сначала старые заказы</small>
                </li>

                <?if($role === 'constructor'){
                    
                    get_template_part("/parts/catalog/forms/order-list-parameters-form/statuses-filter/template");

                    get_template_part("/parts/catalog/forms/order-list-parameters-form/clients-filter/template");

                }
                ?>

                <div class="w-100 pt-2 pe-4">
                    <button type="submit" class="custom-btn white p-2 border normal-font">
                        <span class="btn_label">ПРИМЕНИТЬ</span>
                        <span class="bi bi-arrow-repeat"></span>
                    </button>
                </div>

            </ul>

        </div>

    </form>