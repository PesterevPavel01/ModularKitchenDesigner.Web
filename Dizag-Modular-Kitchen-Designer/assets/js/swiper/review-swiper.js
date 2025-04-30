"use strict"
//==========================================

//! ============== 1 вариант SWIPER ==============
const review_swiper = new Swiper('.review-swiper', {

    //! Основные настройки 
    direction: 'horizontal', // 'vertical', 'horizontal'
    loop: true, // true - круговой слайдер, false - слайдер с конечными положениями
    speed: 500, // скорость переключения слайдов
    spaceBetween: 20, // расстояние между слайдами
    
    //! Пагинация (точки)
    pagination: {
        el: '.swiper-pagination',
        clickable: true, // true - Пагинация становится кликабельной
    },

    //! Кнопки вперед и назад 
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    //! Автоматическое перелистывание
    autoplay:{
        delay:2000,
        stopOnLastSlide:false,
      },
});

if ($(window).width() <= '450'){
    review_swiper.params.slidesPerView='1';
}
else{
    review_swiper.params.slidesPerView='5';
}