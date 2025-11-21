<form class="catalog-order-specification-cell w-100 m-0 p-0" data-ajax-default-content-updater>

<input type="hidden" name = "BLOCKED_ELEMENT" value = "#catalog-oder-content-conteiner">
<input type="hidden" name = "TEMPLATE_PART" value = "parts/catalog/orders/facade-configurator/template">
<input type="hidden" name = "action" value="default_content_updater">
<input type="hidden" name = "TARGET_CONTAINER" value="#order-item-redactor-content">
<input type="hidden" name= "DEPENDENT_FORM" value="#order-item-facade-configurator-form">
<input type="hidden" name = "ORDER_CODE" value=<?= $args['ORDER_CODE']?>>
<input type="hidden" name = "QUANTITY" value=<?= $args['QUANTITY']?>>
<?//<input type="hidden" name = "ACTIVATE_ELEMENT_GROUP" value="specification-item-change-button">?>
<input type="hidden" name = "IS_COMPLETED" value=<?= $args['IS_COMPLETED']?>>
<input type="hidden" name = "MODULE" value="<?= $args['MODULE']?>">
<input type="hidden" data-no-reset="true" name="USER" value="<?= $args['USER']?>">
<input type="hidden" data-no-reset="true" name="ROLE" value="<?= $args['ROLE']?>">

<button type = "submit" class = "btn-primary white-background d-flex flex-column align-items-center justify-content-center p-2 pointer hover-white border rounded height-40"
    data-form-group="specification-item-change-button">
    <i class = "bi bi-copy primary-dark pointer hover-white"                
        data-bs-toggle="tooltip" 
        data-bs-placement="top"    
        title="Добавить копированием">
    </i>
</button>

</form>