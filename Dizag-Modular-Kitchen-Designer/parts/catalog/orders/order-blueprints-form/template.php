<?
enqueue_template_part_styles_scripts( __DIR__, "order-blueprints-form");
?>
<form class="order-blueprints-form modal fade" data-ajax-file-content-updater="refresh" id="order-blueprints-modal" tabindex="-1" enctype="multipart/form-data">
    
    <input type="hidden" id="BLOCKED_ELEMENT" name="BLOCKED_ELEMENT" value="#order-blueprints-modal-send-button">
    <input type="hidden" id="TEMPLATE_PART" name="TEMPLATE_PART" value="parts/catalog/orders/order-blueprints-action/template">
    <input type="hidden" id="action" name="action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER" name="TARGET_CONTEINER" value="#milling-collapse-content">
    <input type="hidden" id="order-blueprints-form-module-code" name="MODULE_CODE" value="">
    <input type="hidden" id="order-blueprints-form-component-code" name="COMPONENT_CODE" value="">
    <?/*<input type="hidden" id="DEPENDENT_FORM" name="DEPENDENT_FORM" value="#">*/?>
    <input type="hidden" name="MAX_FILE_SIZE" value="104857600"> <!-- 10MB -->
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title fw-bold">Добавить эскиз. <span id="order-blueprints-form-component-code-vasible"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-3">
                <!-- Поле загрузки файла -->
                <div class="file-upload-section w-100">
                    <input type="file" 
                        class="d-none" 
                        id="blueprint-files" 
                        name="BLUEPRINTS[]"
                        multiple>
                        
                    <input type="file" 
                        class="form-control" 
                        id="new-blueprint-files" 
                        multiple
                        accept=".jpg,.jpeg,.png,.pdf,.dwg,.dxf">
                    <div class="form-text">Поддерживаемые форматы: JPG, PNG, PDF, DWG, DXF, ZIP, RAR (макс. 10MB)</div>
                </div>

                <div class="files-preview w-100" id="files-preview">
                    <div class="selected-files-list" id="selected-files-list">
                        <!-- Сюда будут добавляться выбранные файлы -->
                    </div>
                </div>
            </div>

            <div id = "order-blueprints-form-modal-result"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary" id = "order-blueprints-modal-send-button">Сохранить</button>
            </div>
        </div>
    </div>
</form>