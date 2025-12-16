
<?
$totalCount = isset($args['TOTAL_COUNT']) ? sanitize_text_field($args['TOTAL_COUNT']) : 0;

$totalPages = isset($args['TOTAL_PAGES']) ? sanitize_text_field($args['TOTAL_PAGES']) : 1;

$period = isset($args['PERIOD']) ? sanitize_text_field($args['PERIOD']) : null;

$ascending = isset($args['ASCENDING']) && $args['ASCENDING'] ? true : false;

$incompleteOnly = isset($args['INCOMPLETE_ONLY']) && $args['INCOMPLETE_ONLY'] ? true : false;

$customOnly = isset($args['CUSTOM_ONLY']) && $args['CUSTOM_ONLY'] ? true : false;

$page = isset($args['PAGE']) ? sanitize_text_field($args['PAGE']) : 0;

$nextPage = ($page < $totalPages - 1) ? ($page + 1) : $page;

$prevPage = ($page > 0) ? ($page-1) : $page;
?>
<div class="order-list-page-switcher-block d-flex flex-column flex-lg-row gap-1 gap-lg-2 w-100 justify-content-center justify-content-lg-start">

    <div class="order-list-page-switcher-controls d-flex gap-1 gap-lg-2 justify-content-center justify-content-lg-start">

        <form id = "" data-ajax-default-content-updater>

            <input type="hidden" data-no-reset="true" id="TEMPLATE_PART" name = "TEMPLATE_PART" value= "parts/catalog/account/customer-order-list/template">
            <input type="hidden" data-no-reset="true" id="action" name = "action" value="default_content_updater">
            <input type="hidden" data-no-reset="true" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#customer-account-order-list">
            <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#customer-account-content">
            <input type="hidden" name = "PAGE" value = <?=$prevPage?>>
            <input type="hidden" name = "PERIOD" value = <?=$period?>>
            <input type="hidden" name = "ASCENDING" value = <?=$ascending?>>
            <input type="hidden" name = "INCOMPLETE_ONLY" value = <?=$incompleteOnly?>>
            <input type="hidden" name = "CUSTOM_ONLY" value = <?=$customOnly?>>

            <button type = "submit" class = "btn-primary white-background d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100 <?=$page == 0 ? 'd-none':''?>"
                data-form-group="specification-item-change-button">

                <i class = "bi bi-caret-left-fill primary-dark pointer hover-white"              
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Предыдущая страница">
                </i>
                
            </button>

        </form>

        <div class="m-0 align-middle text-center">
            <div class="border rounded height-40 w-100 d-flex flex-column align-items-center justify-content-center p-2">
                стрстраница <?=$page + 1?> из <?=$totalPages == 0 ? 1 : $totalPages?>
            </div>
        </div>

        <form id = "" data-ajax-default-content-updater>

            <input type="hidden" data-no-reset="true" id="TEMPLATE_PART" name = "TEMPLATE_PART" value= "parts/catalog/account/customer-order-list/template">
            <input type="hidden" data-no-reset="true" id="action" name = "action" value="default_content_updater">
            <input type="hidden" data-no-reset="true" id="TARGET_CONTAINER"  name = "TARGET_CONTAINER" value="#customer-account-order-list">
            <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#customer-account-content">
            <input type="hidden" name = "PAGE" value = <?=$nextPage?>>
            <input type="hidden" name = "PERIOD" value = <?=$period?>>
            <input type="hidden" name = "ASCENDING" value = <?=$ascending?>>
            <input type="hidden" name = "INCOMPLETE_ONLY" value = <?=$incompleteOnly?>>
            <input type="hidden" name = "CUSTOM_ONLY" value = <?=$customOnly?>>

            <button type = "submit" class = "btn-primary white-background d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100 <?=$page >= ($totalPages - 1) ? 'd-none':''?>"
                data-form-group="specification-item-change-button">

                <i class = "bi bi-caret-right-fill primary-dark pointer hover-white"              
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Следующая страница">
                </i>
                
            </button>

        </form>

    </div>

    <div class="m-0 align-middle">

        <div class="height-40 text-center text-lg-start p-2">
            всего заказов: <?=$totalCount?>
        </div>

    </div>

</div>