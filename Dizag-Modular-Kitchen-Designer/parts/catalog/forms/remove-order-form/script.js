
$(document).ready(RemoveOrderItemModalInit);

function RemoveOrderItemModalInit(){
    
    var removeModal = $('#remove-order-modal');

    removeModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        clearRemoveOrderModal(removeModal);
        
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var orderCode = button.getAttribute('data-bs-code');
        var orderTitle = button.getAttribute('data-bs-title');
        var user = button.getAttribute('data-bs-order-user');

        var parameters = button.getAttribute('data-bs-parameters');
        
        try {
            var arParams = JSON.parse(parameters);
            console.log('Parsed:', arParams);
        } catch (e) {
            console.error('Parse error:', e);
        }
        // Заполняем поля формы с помощью jQuery
        removeModal.find('#remove-order-code').val(orderCode);
        removeModal.find('#remove-order-title').text(orderTitle);

        removeModal.find('input[name="USER"]').val(user);

        removeModal.find('input[name="PERIOD"]').val(arParams.PERIOD);
        removeModal.find('input[name="ASCENDING"]').val(arParams.ASCENDING);
        removeModal.find('input[name="INCOMPLETE_ONLY"]').val(arParams.INCOMPLETE_ONLY);
        removeModal.find('input[name="CUSTOM_ONLY"]').val(arParams.CUSTOM_ONLY);

    });
}

// Функция для очистки модального окна
function clearRemoveOrderModal(modal) {
    modal.find('#remove-order-result').empty();    
    modal.find('#remove-order-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках

    modal.find('.success').removeClass("success");  
}