<?
enqueue_template_part_styles_scripts( __DIR__, "order-blueprints-form", 'blueprints-modal-js');

$componentType = isset($args['COMPONENT_TYPE']) ? sanitize_text_field($args['COMPONENT_TYPE']) : "";

if($componentType === "")
    get_template_part("parts/catalog/errors/default-error-message/template", null, 
    [
        'TITLE' => "Не указан тип компонента!"
    ]);

    $login = isset($args['USER']) ? sanitize_text_field($args['USER']) : "";

    $role = isset($args['ROLE']) ? sanitize_text_field($args['ROLE']) : "";
?>

<form class="order-blueprints-form modal fade" data-ajax-file-content-updater="refresh" id="order-<?=$componentType?>-blueprints-modal" tabindex="-1" enctype="multipart/form-data">
    
    <input type="hidden" data-no-reset="true" name="BLOCKED_ELEMENT" value="#order-<?=$componentType?>-blueprints-modal-send-button">
    <input type="hidden" data-no-reset="true" name="TEMPLATE_PART" value="parts/catalog/forms/order-blueprints-form/action/template">
    <input type="hidden" data-no-reset="true" name="action" value="default_content_updater">
    <input type="hidden" data-no-reset="true" name="TARGET_CONTAINER" value="#<?=$componentType?>-collapse-content">
    <input type="hidden" name="COMPONENT_CODE" value="">
    <input type="hidden" name="COMPONENT_TYPE" value=<?=$componentType?>>
    <?/*<input type="hidden" id="DEPENDENT_FORM" name="DEPENDENT_FORM" value="#">*/?>
    <input type="hidden" data-no-reset="true" name="MAX_FILE_SIZE" value="104857600"> <!-- 10MB -->
    <input type="hidden" data-no-reset="true" name="USER" value="<?= $login?>">
    <input type="hidden" data-no-reset="true" name="ROLE" value="<?= $role?>">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title fw-bold">Добавить эскиз. <span class = "component-code-vasible"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-3">
                <!-- Поле загрузки файла -->
                <div class="file-upload-section w-100">
                    <input type="file" 
                        class="d-none" 
                        name="BLUEPRINTS[]"
                        multiple>
                        
                    <input type="file" 
                        class="form-control" 
                        name = "NEW_BLUEPRINTS[]"
                        multiple
                        accept=".jpg,.jpeg,.png,.pdf,.dwg,.dxf">

                    <div class="form-text">Поддерживаемые форматы: JPG, PNG, PDF, DWG, DXF, ZIP, RAR (макс. 10MB)</div>
                </div>

                <div class="files-preview w-100">
                    <div class="selected-files-list">
                        <!-- Сюда будут добавляться выбранные файлы -->
                    </div>
                </div>
            </div>

            <div class = "order-blueprints-form-modal-result"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary" id = "order-<?=$componentType?>-blueprints-modal-send-button">Сохранить</button>
            </div>
        </div>
    </div>
</form>