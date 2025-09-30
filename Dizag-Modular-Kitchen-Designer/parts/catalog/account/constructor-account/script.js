$(document).ready(AccountInit);

function  AccountInit()
{
    let $AccountSection = $('.account-trigger-form');

    let $triggerForms = $AccountSection.find('.update-trigger');

    $triggerForms.each(function() {

        let $updateButtons = $(this).find('.ajax-update-button');

        $updateButtons.each(function() {
            $(this).off('click').on('click', function(e) {
                Select($(this), $updateButtons);
            });
        });
    }); 
    setTimeout(function() {
        SwiperInit();
    }, 100);
    
}


function Select($currentBtn, $updateButtons)
{
    $currentBtn.toggleClass('active');

    if(!$updateButtons)
        return;
    if ($updateButtons.length > 0) {
        $updateButtons.each(function() {
            if (!$(this).is($currentBtn))
                $(this).removeClass('active');
        });
    }
}

function SwiperInit($updateButtons) {
    // Проверяем существование элемента
    if ($('.account-swiper').length === 0) {
        console.warn('Swiper element not found');
        return;
    }

    // Удаляем предыдущий экземпляр Swiper если существует
    if (typeof swiper !== 'undefined') {
        swiper.destroy(true, true);
    }

    swiper = new Swiper('.account-swiper', {  
        speed: 100,
        effect: 'fade', // ДОБАВИТЬ ЭТО
        fadeEffect: {
            crossFade: true // ДОБАВИТЬ ЭТО
        },
        centeredSlides: true,
        simulateTouch: false, // Отключаем свайп если не нужно

        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },

        grabCursor: false,

        // Отключаем lazy loading если не нужен
        lazy: false
    });

        // Ручное управление кнопками
        $('.customer-order-list-on').off('click').on('click', function() {
            swiper.slideTo(0);
            updateButtonStates(0);
        });
    
        $('.customer-approval-list-on').off('click').on('click', function() {
            swiper.slideTo(1);
            updateButtonStates(1);
        });
    
        function updateButtonStates(activeIndex) {
            $('.ajax-update-button').removeClass('active');
            $('.ajax-update-button').eq(activeIndex).addClass('active');
        }
}