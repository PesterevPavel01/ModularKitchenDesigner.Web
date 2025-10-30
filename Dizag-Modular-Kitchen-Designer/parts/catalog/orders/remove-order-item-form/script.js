
$(document).ready(RemoveOrderItemModalInit);

function RemoveOrderItemModalInit(){
    
    var removeModal = $('#remove-order-item-modal');

    removeModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        clearRemoveOrderItemModal(removeModal);
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var orderItemCode = button.getAttribute('data-bs-item-code');
        var orderCode = button.getAttribute('data-bs-code');

        console.log(orderItemCode);
        // Заполняем поля формы с помощью jQuery
        removeModal.find('input[name="ORDER_ITEM_CODE"]').val(orderItemCode);
        removeModal.find('input[name="ORDER_CODE"]').val(orderCode);
        removeModal.find('#remove-order-item-title').text(orderItemCode);
    });
}

// Функция для очистки модального окна
function clearRemoveOrderItemModal(modal) {
    modal.find('#remove-order-item-result').empty();    
    modal.find('#remove-order-item-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках
}