(function (){
    var algs = new Array();
    var algsHeight = new Array();
    var index =0;

    while ($('h3').eq(index).html()!=null){
        var currentAlg = $('h3').eq(index);
        algs[index] = currentAlg.html();
        algsHeight[index] = currentAlg.offset().top;

        index++;
    }

    for (var i=0; i<index; i++){
        if (i==0){
            $('<li></li>', {
                text: algs[i],
                class: 'active'
            }).appendTo('#sideNav ul');
        }
        else{
            $('<li></li>', {
                text: algs[i],
                class: 'inactive'
            }).appendTo('#sideNav ul');
        }
    }

    //SCROLL ACTIVITY
    var sideBar = $('#sideNav')
    var initialPos = sideBar.offset().top;
    var currentActive = -1;
    $('#sideNav li:first-child').addClass("active");
    $(window).scroll(function(){
        var currentScroll = $(window).scrollTop() + 100;
        if (currentScroll >= initialPos){
            sideBar.css({
                position: 'fixed',
                top: '100px',
            });
        }
        else {
            sideBar.css({
                position: 'absolute',
                top: '20px'
            });
        }

        if (currentScroll >= algsHeight[currentActive+1]){
            console.log(currentActive);
            $('#sideNav li').eq(currentActive).removeClass();
            $('#sideNav li').eq(currentActive).addClass('inactive');
            currentActive++;
            $('#sideNav li').eq(currentActive).removeClass();
            $('#sideNav li').eq(currentActive).addClass("active");
        }
        else if (currentScroll <= (algsHeight[currentActive]-200)
            && currentActive > 0){
            console.log(currentActive);
            $('#sideNav li').eq(currentActive).removeClass();
            $('#sideNav li').eq(currentActive).addClass('inactive');
            currentActive--;
            $('#sideNav li').eq(currentActive).removeClass();
            $('#sideNav li').eq(currentActive).addClass("active");
        }


    })
    $("#sideNav li").click(function() {
        $('html, body').animate({
            scrollTop: algsHeight[$(this).index()]-90
        }, 1000);
    });
})();

