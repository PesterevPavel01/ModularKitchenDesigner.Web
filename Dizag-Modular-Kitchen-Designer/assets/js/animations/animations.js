// Гамбургер
$(document).ready(function() {
    var hamb = $('#hamb');
    var popup = $('#popup');
    var body = $('body');

    hamb.on('click', hambHandler);
    navbarInit();
});

function hambHandler(e){

    e.preventDefault();
    
    popup.classList.toggle('open');
    hamb.classList.toggle('active');
    body.classList.toggle('noscroll');
    //animItem.classList.remove('_disable');
}

function navbarInit(){

    if ($(window).width() <= '800'){
        let $navbar=$('.navbar-collapse');
        let $popupPanel=$('.popup-nav-panel');
        $popupPanel.append($navbar);
    }

}


