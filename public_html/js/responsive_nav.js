$(document).ready(function() {
    var pull 		= $('#pull');
    menu 		= $('nav ul');
    menuHeight	= menu.height();

    $('nav>ul>li:first-child>a').on('click', function(e){
        e.preventDefault();
    });
    if ($(window).width() < 700){
        menu.hide();
    }
    $(pull).on('click', function(e) {

        console.log(menu.css("height"));
        if (menu.css("display")=="none"){
            menu.slideDown();

        }
        else{
            menu.slideUp();

        }
    });
    $(window).resize(function(){
        var w = $(window).width();
        if(w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });
    $(window).resize(function(){
        var w = $(window).width();
        if(w < 700) {
            menu.slideUp(0);
        }
    });
});