(function (){
    var algs = new Array();
    var index =0;

    while ($('h3').eq(index).html()!=null){
        algs[index] = $('h3').eq(index).html();
        index++;
    }
    console.log(algs);
    for (var i=0; i<index; i++){
        $('<li></li>', {
            text: algs[i]
        }).appendTo('#sideNav ul');
    }
})();

var sideBar = $('#sideNav')
var initialPos = sideBar.offset().top;
$(window).scroll(function(){
    var currentScroll = $(window).scrollTop();
    console.log(currentScroll);
    if (currentScroll >= (initialPos - 100)){
        sideBar.css({
            position: 'fixed',
            top: '100px'
        });
    } else {
        sideBar.css({
            position: 'absolute',
            top: '20px'
        });
    }
})