
$(document).ready(RemoveOrderModalInit);

function RemoveOrderModalInit(){
    
    var removeModal = $('#remove-order-modal');

    removeModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        clearRemoveOrderModal(removeModal);
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var orderCode = button.getAttribute('data-bs-code');
        var orderTitle = button.getAttribute('data-bs-title');

        // Заполняем поля формы с помощью jQuery
        removeModal.find('#remove-order-code').val(orderCode);
        removeModal.find('#remove-order-title').text(orderTitle);
    });
}

// Функция для очистки модального окна
function clearRemoveOrderModal(modal) {
    modal.find('#remove-order-result').empty();    
    modal.find('#remove-order-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках
}