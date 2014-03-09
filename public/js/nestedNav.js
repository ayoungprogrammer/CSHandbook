(function(){
    if ($(window).width()>700){

        $('nav ul li').mouseenter(function(){
            var nestedNav =  $(this).find('ul');
            nestedNav.css({
                'margin-left': -parseInt(nestedNav.outerWidth()) / 2,
            });
            nestedNav.parent('div').css('padding-top', 5);
        });
    }
    else{
        $('nav ul div').hide();
        $('nav ul li').on('click', function(){
            var targetItem = $(this);
            targetItem.children('div').slideToggle();
            targetItem.siblings('li').children('div').slideUp();
        });
    }
})();