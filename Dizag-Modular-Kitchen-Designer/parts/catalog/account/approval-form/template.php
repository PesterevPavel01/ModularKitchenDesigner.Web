<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "approval-form");//подключаю файл <style class="css"></style>
?>

<form class="approval-modal-form  modal fade" data-ajax-default-content-updater="refresh" id="approve-customer-modal" tabindex="-1" <?/*onsubmit = "return save_сhanges(event)"*/?>>
    
    <input type="hidden" id="BLOCKED_ELEMENT" name = "BLOCKED_ELEMENT" value = "#approve-customer-modal">
    <input type="hidden" id="TEMPLATE_PART" name = "TEMPLATE_PART" value = "parts/catalog/account/approval-action/template">
    <input type="hidden" id="action" name = "action" value="default_content_updater">
    <input type="hidden" id="TARGET_CONTEINER"  name = "TARGET_CONTEINER" value="#result-ajax-request">
    <input type="hidden" id="DEPENDENT_FORM"  name = "DEPENDENT_FORM" value="#approval-customer-section">
    <input type="hidden" id="approval-customer-login" name = "CUSTOMER_LOGIN" value="">
    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title">Согласование: <span id="approval-customer-name"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <p class="m-0">Введите код клиента из 1с:</p>
                <input type="text" class="form-control" id="customer-code" name = "CUSTOMER_CODE" placeholder="код">
                <!-- Дополнительные поля формы -->
                <p class="result-ajax-request w-100" id = 'result-ajax-request'>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Внести</button>
            </div>
        </div>
    </div>
</form>