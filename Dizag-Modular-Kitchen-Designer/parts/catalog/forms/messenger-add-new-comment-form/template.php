<?$moduleCode = isset($args['MODULE_CODE']) ? sanitize_text_field($args['MODULE_CODE']) : "";

if($moduleCode === ""){

    return;
}

$orderCode = isset($args['ORDER_CODE']) ? sanitize_text_field($args['ORDER_CODE']) : "";

if($orderCode === ""){
    return;
}

$user = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

?>
<form class="order-item-new-message-panel d-flex w-100 m-0 p-0" data-ajax-default-content-updater>

    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/forms/messenger-add-new-comment-form/action/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#catalog-order-item-mesenger">
    <input type="hidden" data-no-reset="true" name= "DEPENDENT_FORM" value="#catalog-order-item-messenger-reset-form">
    <input type="hidden" data-no-reset="true" name="ERROR_CONTAINER" value="#catalog-order-messenger-errors">
    <input type="hidden" name = "MODULE_CODE" value=<?=esc_html($args['MODULE_CODE'])?>>
    <input type="hidden" name = "ORDER_CODE" value=<?=esc_html($args['ORDER_CODE'])?>>
    <input type="hidden" name = "IS_COMPLETED" value=<?=sanitize_text_field($args['IS_COMPLETED'])?>>
    <input type="hidden" data-no-reset="true" name="USER" value="<?=esc_html($args['USER'])?>">
    <input type="hidden" data-no-reset="true" name="ROLE" value="<?=esc_html($args['ROLE'])?>">

    <ul class="d-flex flex-column w-100 gap-1 m-0 p-0" id = "123">

        <li class="component-panel-controls w-100">
            <div class="w-100 m-0">
                <textarea class="form-control mini-font" name="TEXT" id="comment" rows="3" placeholder="Новый комментарий."></textarea>
            </div>
        </li>

        <li class="component-panel-controls d-flex flex-column w-100 gap-1">
            <div class="w-100 m-0 d-flex justify-content-end">

                <button type="submit" class="btn btn-primary d-flex">Добавить</button>

            </div>
        </li>
    </ul>
</form>