
$(document).ready(ApprovalInit);

function ApprovalInit()
{  
    ApprovalModalInit();
}

function ApprovalModalInit(){
    
    var approveModal = $('#approve-modal');

    approveModal.off('show.bs.modal').on('show.bs.modal', function (event) {
        // Получаем кнопку, вызвавшую модальное окно
        var button = event.relatedTarget;
        // Получаем данные из атрибутов data-bs-*
        var userId = button.getAttribute('data-bs-login');
        var userName = button.getAttribute('data-bs-name');

        // Заполняем поля формы с помощью jQuery
        approveModal.find('#customer-name').text(userName);  // текстовое поле       // текстовое поле
        approveModal.find('#customer-login').val(userId);            // hidden input
    });
}

function saveChanges() {
    let $approveModal = $('#approve-modal');
    let $customerId = $approveModal.find('#customer-login').val();
    let $customerCode = $approveModal.find('#customer-code').val();
    
    let cleanedCode = $customerCode.replace(/\s/g, '');
    let isValid = cleanedCode.length >= 11;
    
    // Проверка и вывод сообщения
    isValid ? console.log($customerCode) : console.error('Ошибка');
    
    if (!isValid) return false;
    
    // Логика сохранения
    // ...
    return true;
}