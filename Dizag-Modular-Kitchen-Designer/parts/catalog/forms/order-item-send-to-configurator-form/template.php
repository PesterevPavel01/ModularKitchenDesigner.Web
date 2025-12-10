<?enqueue_template_part_styles_scripts( __DIR__, "order-item-send-to-configurator-form");?>

<?
    $moduleCode = isset($args['MODULE_CODE']) ? sanitize_text_field($args['MODULE_CODE']) : "";
    $quantity = isset($args['QUANTITY']) ? sanitize_text_field($args['QUANTITY']) : "";
    $module = isset($args['MODULE']) ? $args['MODULE'] : "";
    $active = isset($args['ACTIVE']) ? sanitize_text_field($args['ACTIVE']) : "";
?>

<form class="d-lg-table-cell  w-100 m-0 p-0" id="order-item-send-to-configurator-form-<?= $moduleCode?>" data-ajax-default-content-updater>

    <input type="hidden" data-no-reset="true" name = "BLOCKED_ELEMENT" value = "#catalog-oder-section">
    <input type="hidden" data-no-reset="true" name = "TEMPLATE_PART" value = "parts/catalog/orders/facade-configurator/template">
    <input type="hidden" data-no-reset="true" name = "action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER" value="#order-item-redactor-content">
    <input type="hidden" data-no-reset="true" name = "TARGET_CONTAINER_MOBILE" value="#order-item-redactor-content-mobile">
    <input type="hidden" data-no-reset="true" name= "DEPENDENT_FORM" value="#catalog-order-item-messenger-reset-form">
    <input type="hidden" name = "MODULE_CODE" value=<?= $moduleCode?>>
    <input type="hidden" data-no-reset="true" name = "ORDER_CODE" value=<?= $args['ORDER_CODE']?>>
    <input type="hidden" name = "QUANTITY" value=<?= $quantity?>>
    <input type="hidden" data-no-reset="true" name = "ACTIVATE_ELEMENT_GROUP" value="specification-item-change-button">
    <input type="hidden" name = "IS_COMPLETED" value=<?= $args['IS_COMPLETED']?>>
    <input type="hidden" name = "MODULE" value="<?= $module?>">
    <input type="hidden" data-no-reset="true" name="USER" value="<?= $args['USER']?>">
    <input type="hidden" data-no-reset="true" name="ROLE" value="<?= $args['ROLE']?>">

    <button type = "submit" id = "<?= $moduleCode?>" class = "d-none <?=$active?> btn-primary white-background d-lg-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100"
        data-form-group="specification-item-change-button">

        <i class = "bi bi-pencil-fill primary-dark pointer hover-white"              
            data-bs-toggle="tooltip" 
            data-bs-placement="top"    
            title="Редактировать элемент">
        </i>
        
    </button>

    <?if($moduleCode !== ""){?>

        <button type = "button" class = "btn-primary white-background d-flex d-lg-none flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100" modal-button-trigger
            data-bs-toggle="offcanvas" 
            data-bs-target="#catalog-order-item-redactor-modal"
            data-bs-current-form="#order-item-send-to-configurator-form-<?= $moduleCode?>">

            <?if($moduleCode !== ""){?>

                <i class = "bi bi-pencil-fill primary-dark pointer hover-white"              
                    data-bs-toggle="tooltip" 
                    data-bs-placement="top"    
                    title="Редактировать элемент">
                </i>

            <?}else{?>

                НОВЫЙ МОДУЛЬ
                
            <?}?>

        </button>

    <?}else{?>

        <button type = "button" class = "btn-primary white-background d-flex d-lg-none flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40 w-100" modal-button-trigger
            data-bs-toggle="offcanvas" 
            data-bs-target="#catalog-order-item-redactor-modal"
            data-bs-current-form="#order-item-send-to-configurator-form-<?= $moduleCode?>">
            НОВЫЙ МОДУЛЬ
        </button>

    <?}?>

</form>