
$(document).ready(function() {

    let $quantityLi =  $('.quantity');

    $quantityLi.each(function() {
        
        $currentLi = $(this);
        
        $quantityInput = $currentLi.find('#quantity');
        
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