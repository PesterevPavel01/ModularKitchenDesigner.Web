<?//необходимо получить список заказов, которые находятся на согласовании у конструктора
enqueue_template_part_styles_scripts( __DIR__, "approval-form");//подключаю файл <style class="css"></style>
?>

<div class="approval-modal-form modal fade" id="approve-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="title">Согласование: <span id="customer-name"></span></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start m-0 gap-2">
                <input type="hidden" id="customer-login" value="">
                <p class="m-0">Введите код клиента из 1с:</p>
                <input type="text" class="form-control" id="customer-code" placeholder="код">
                <!-- Дополнительные поля формы -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Внести</button>
            </div>
        </div>
    </div>
</div>