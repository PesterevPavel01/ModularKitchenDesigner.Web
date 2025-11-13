
$(document).ready(RemoveOrderItemModalInit);

function RemoveOrderItemModalInit(){
    
    var removeModal = $('#remove-order-item-modal');

    removeModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        clearRemoveOrderItemModal(removeModal);
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var moduleCode = button.getAttribute('data-bs-module-code');
        var orderCode = button.getAttribute('data-bs-order-code');

        //console.log(moduleCode);
        //console.log(orderCode);
        // Заполняем поля формы с помощью jQuery
        removeModal.find('input[name="MODULE_CODE"]').val(moduleCode);
        removeModal.find('input[name="ORDER_CODE"]').val(orderCode);
        removeModal.find('#remove-order-item-title').text(moduleCode);
    });
}

// Функция для очистки модального окна
function clearRemoveOrderItemModal(modal) {
    modal.find('#remove-order-item-result').empty();    
    modal.find('#remove-order-item-code').val('');          
    modal.find('.alert').remove();       
    modal.find('.error-message').remove();      
    modal.find('.active').removeClass("active"); 

    //console.log('.success: ' + modal.find('.success'))

    modal.find('.success').removeClass("success");     
}