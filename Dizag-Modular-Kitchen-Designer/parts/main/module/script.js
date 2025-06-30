
$(document).ready(function() {

    let $quantityLi =  $('.quantity');

    $quantityLi.each(function() {
        
        $currentLi = $(this);
        
        $quantityInput = $currentLi.find('#quantity');
        
        $quantityInput.on('change input', function() {
            quantityChange();
        });

        $quantityInput.on('input', function() {

            var quantityValue = $(this).val();

            $selectedElement = $(this).closest('.block-module-list');

            if (quantityValue > 0) 
                $selectedElement.addClass('selected'); // Меняем цвет рамки на зеленый
            else 
                $selectedElement.removeClass('selected'); // Возвращаем стандартный цвет рамки
        });

    });
});
   
function quantityChange() {

    //очистка отчета по стоимости и спецификации при изменении выбора модулей или их количества
    const $section = $('.custom-kitchen-order-section');
    
    if ($section.length) {
        $section.empty();
    } else {
        console.warn('Блок .custom-kitchen-order-section не найден');
    }
}