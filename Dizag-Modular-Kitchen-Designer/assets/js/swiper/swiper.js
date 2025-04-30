const main_swiper =new Swiper('.main-swiper',{  

  speed:1000,
  loop: true,
  effect: 'fade',
  centeredSlides:true,

  fadeEffect: {
    crossFade: true
  },
/*
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  pagination: {
    el: '.swiper-pagination',
    type:'progressbar'
  },
*/
  Keyboard:{
    enabled: true,
    onlyInViewport: true,
  },

  grabCursor:true,

  autoplay:{
    delay:4000,
    stopOnLastSlide:false,
  },

  lazy:{
    loadPrevNext:true,
  },
    
    
});

const preview_slider=new Swiper('.slider',{  

  speed:8000,
  effect: 'fade',
  centeredSlides:true,

  fadeEffect: {
    crossFade: true
  },
/*
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  pagination: {
    el: '.swiper-pagination',
    type:'progressbar'
  },
*/
  Keyboard:{
    enabled: true,
    onlyInViewport: true,
  },

  grabCursor:true,

  autoplay:{
    delay:1000,
    stopOnLastSlide:false,
  },

  lazy:{
    loadPrevNext:true,
  },
    
});