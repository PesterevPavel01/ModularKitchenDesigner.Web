
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

        // Заполняем поля формы с помощью jQuery
        removeModal.find('#remove-order-code').val(orderCode);
        removeModal.find('#remove-order-title').text(orderTitle);

        removeModal.find('input[name="USER"]').val(user);
        
        $('<input>', {
            type: 'hidden',
            name: 'SUCCESS_CONTAINERS[]',
            value: '#remove-btn-' + orderCode // Значение из HTML
        }).appendTo(removeModal);

    });
}

// Функция для очистки модального окна
function clearRemoveOrderModal(modal) {

    modal.find('#remove-order-result').empty();    
    modal.find('#remove-order-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках

    modal.find('input[name="SUCCESS_CONTAINERS[]"]').each(function() {

        if ($(this).val().startsWith('#remove-btn-')) {
            $(this).remove();
        }

    });

    modal.find('.success').removeClass("success");  
}