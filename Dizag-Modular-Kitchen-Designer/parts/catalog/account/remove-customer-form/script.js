
$(document).ready(RemoveCustomerInit);

function RemoveCustomerInit()
{  
    RemoveCustomerModalInit();
}

function RemoveCustomerModalInit(){
    
    var removeModal = $('#remove-customer-modal');

    removeModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        clearRemoveCustomerModal(removeModal);
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var userId = button.getAttribute('data-bs-login');
        var userName = button.getAttribute('data-bs-name');

        // Заполняем поля формы с помощью jQuery
        removeModal.find('#remove-customer-name').text(userName);
        removeModal.find('#remove-customer-login').val(userId);
    });
}

// Функция для очистки модального окна
function clearRemoveCustomerModal(modal) {
    modal.find('#remove-customer-result').empty();    
    modal.find('#customer-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках
}