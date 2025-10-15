
$(document).ready(ApprovalCustomerInit);

function ApprovalCustomerInit()
{  
    ApprovalCustomerModalInit();
}

function ApprovalCustomerModalInit(){
    
    var approveModal = $('#approve-customer-modal');

    approveModal.off('show.bs.modal').on('show.bs.modal', function (event) {

        ClearApprovalCustomerModal(approveModal);

        var button = event.relatedTarget;

        var userId = button.getAttribute('data-bs-login');
        var userName = button.getAttribute('data-bs-name');

        approveModal.find('#approval-customer-name').text(userName);  // текстовое поле       // текстовое поле
        approveModal.find('#approval-customer-login').val(userId);    // hidden input
    });
}

// Функция для очистки модального окна
function ClearApprovalCustomerModal(modal) {
    modal.find('#result-ajax-request').empty();    
    modal.find('#customer-code').val('');          
    modal.find('.alert').remove();                 // Удаляем все алерты (если есть)
    modal.find('.error-message').remove();         // Удаляем сообщения об ошибках
}