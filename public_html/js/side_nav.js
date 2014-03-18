(function (){
    var algs = new Array();
    var algsHeight = new Array();
    var headings = $('h2');

    var subAlgs = new Array();
    var subAlgsHeight = new Array();
    var subHeadings = $('h3');

    for (var i=0;i<headings.length;i++){
        var currentAlg = headings.eq(i);
        algs[i] = currentAlg.html();
        algsHeight[i] = currentAlg.offset().top;
    }
    algsHeight.push(100000);
    for (var i=0;i<subHeadings.length;i++){
        var currentAlg = subHeadings.eq(i);
        subAlgs[i]=currentAlg.html();
        subAlgsHeight[i]=currentAlg.offset().top;
    }

    var subHeadingIndex=0;

    for (var i=0; i<headings.length; i++){
        if (i==0){
            $('<li></li>', {
                text: algs[i],
                class: 'active'
            }).appendTo('#sideNav>ul');
        }
        else{
            $('<li></li>', {
                text: algs[i],
                class: 'inactive'
            }).appendTo('#sideNav>ul');
        }
        $('<ul></ul>').appendTo('#sideNav>ul>li:last-child');
        while (subAlgsHeight[subHeadingIndex]<algsHeight[i+1] && subHeadingIndex<subHeadings.length){
            $('<li></li>', {
                text: subAlgs[subHeadingIndex],
                class: 'inactive'
            }).appendTo('#sideNav>ul>li:last-child>ul');
            subHeadingIndex++;
        }
    }

    //SCROLL ACTIVITY
    var sideBar = $('#sideNav');
    var initialPos = sideBar.offset().top;
    var currentActive = -1;
    var subCurrentActive = -1;
    $('#sideNav>ul>li:first-child').addClass("active");

    var listItems = $('#sideNav>ul>li');
    var subListItems =  $('#sideNav>ul>li>ul>li');
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
            listItems.eq(currentActive).removeClass();
            listItems.eq(currentActive).addClass('inactive');
            currentActive++;
            listItems.eq(currentActive).removeClass();
            listItems.eq(currentActive).addClass("active");
        }
        else if (currentScroll <= (algsHeight[currentActive]-200)
            && currentActive > 0){
            listItems.eq(currentActive).removeClass();
            listItems.eq(currentActive).addClass('inactive');
            currentActive--;
            listItems.eq(currentActive).removeClass();
            listItems.eq(currentActive).addClass("active");
        }

        if (currentScroll >= subAlgsHeight[subCurrentActive+1]){
            subListItems.eq(subCurrentActive).removeClass();
            subListItems.eq(subCurrentActive).addClass('inactive');
            subCurrentActive++;
            subListItems.eq(subCurrentActive).removeClass();
            subListItems.eq(subCurrentActive).addClass("active");
        }
        else if (currentScroll <= (algsHeight[subCurrentActive]-200)
            && subCurrentActive > 0){
            subListItems.eq(subCurrentActive).removeClass();
            subListItems.eq(subCurrentActive).addClass('inactive');
            subCurrentActive--;
            subListItems.eq(subCurrentActive).removeClass();
            subListItems.eq(subCurrentActive).addClass("active");
        }


    })
    listItems.click(function() {
        $('html, body').animate({
            scrollTop: algsHeight[$(this).index()]-90
        }, 1000);
    });
    subListItems.click(function() {
        $('html, body').animate({
            scrollTop: algsHeight[$(this).index()]-90
        }, 1000);
    });
})();

