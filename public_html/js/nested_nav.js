(function(){
    if ($(window).width()>800){
        $('nav ul li').mouseenter(function(){
            var nestedNav =  $(this).find('ul');
            nestedNav.css({
                'margin-left': -parseInt(nestedNav.outerWidth()) / 2,
            });
            nestedNav.parent('div').css({
                'padding-top':15,
                'height':100
            });
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