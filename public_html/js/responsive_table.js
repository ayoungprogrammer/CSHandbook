function resizeTable (){
    var windowWidth = $(window).width();
    var table = $('section table');
    if (windowWidth<700){
        if (!table.parent().is('div')){
            $('section table').wrap('<div></div>');
        }
        var tableWidth = $(window).width() - 70;
        //console.log(tableWidth);
        $('section div').css('width', tableWidth);
    } else {
        if (!table.parent().is('div')){
            //$('section table').unwrap('<div></div>');
        }
    }
}
(function(){
    resizeTable();
})();
$(window).resize(function(){
    resizeTable();
});