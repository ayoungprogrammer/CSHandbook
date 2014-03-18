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

        $('<li></li>').appendTo('#sideNav>ul');
        $('<h5></h5>',{
            text: algs[i],
            class: 'inactive'
        }).appendTo('#sideNav>ul>li:last-child');




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
    var currentActive = 0;


    var listItems = $('#sideNav>ul>li');
    var subListItems =  $('#sideNav>ul>li>ul>li');

    var navItems = new Array();
    var itemsHeight = new Array();

    var listIndex = 0,
        subListIndex = 0,
        listLength = algs.length,
        subListLength = subAlgs.length;


    while (!(listIndex == listLength && subListIndex == subListLength)){
        if (listIndex == listLength){
            navItems.push(subListItems.eq(subListIndex));
            itemsHeight.push(subAlgsHeight[subListIndex]);
            subListIndex++;
        }
        else if (subListIndex == subListLength){
            navItems.push(listItems.eq(listIndex).children('h5'));
            itemsHeight.push(algsHeight[listIndex]);
            listIndex++;
        }
        else{
            if (subAlgsHeight[subListIndex] > algsHeight[listIndex]){
                navItems.push(listItems.eq(listIndex).children('h5'));
                itemsHeight.push(algsHeight[listIndex]);
                listIndex++;
            }
            else{
                navItems.push(subListItems.eq(subListIndex));
                itemsHeight.push(subAlgsHeight[subListIndex]);
                subListIndex++;
            }
        }
    }

    $('#sideNav>ul>li:first-child>h5').addClass("active");
    $('#sideNav>ul>li:first-child').addClass("current");


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
//        for (var i=0;i<navItems.length;i++){
//            console.log(navItems[i]);
//            console.log(itemsHeight[i]);
//        }

        if (currentScroll >= itemsHeight[currentActive+1]){
//            console.log('wtf');
            navItems[currentActive].removeClass();
            navItems[currentActive].addClass('inactive');
            navItems[currentActive].parents('li').removeClass();
            currentActive++;
            navItems[currentActive].removeClass();
            navItems[currentActive].addClass('active');
            navItems[currentActive].parents('li').addClass('current');

        }
        else if (currentScroll <= (itemsHeight[currentActive]-100)
            && currentActive > 0){
            navItems[currentActive].removeClass();
            navItems[currentActive].addClass('inactive');
            navItems[currentActive].parents('li').removeClass();
            currentActive--;
            navItems[currentActive].removeClass();
            navItems[currentActive].addClass('active');
            navItems[currentActive].parents('li').addClass('current');
        }


    })
    listItems.children('h5').click(function() {
        $('html, body').animate({
            scrollTop: algsHeight[$(this).parent().index()]-90
        }, 1000);
    });
    subListItems.click(function() {
        console.log($(this).index());
        $('html, body').animate({
            scrollTop: subAlgsHeight[$(this).index('#sideNav>ul>li>ul>li')]-90
        }, 1000);
    });
})();

