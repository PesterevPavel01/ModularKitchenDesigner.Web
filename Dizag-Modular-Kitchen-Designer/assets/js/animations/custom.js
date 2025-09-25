
  (function ($) {
    "use strict";
    
    // PRE LOADER
    $(window).on('load',function(){
      $('.preloader').delay(100).slideUp('slow'); // set duration in brackets    
    });
  
    
  })(window.jQuery);
  
  $(document).ready(function() {
    // NAVBAR
    $(".headroom").headroom();
  });