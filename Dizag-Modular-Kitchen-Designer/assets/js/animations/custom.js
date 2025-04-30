
  (function ($) {
  
  "use strict";

    // PRE LOADER
    $(window).on('load',function(){
      $('.preloader').delay(100).slideUp('slow'); // set duration in brackets    
    });
  
    // NAVBAR
    $(".navbar").headroom();
    
  })(window.jQuery);
