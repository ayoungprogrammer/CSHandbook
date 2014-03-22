<footer>
    <strong>Feedback?</strong> <a href="mailto:simonhuang989@hotmail.com"> Send us a message here</a>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script>
    (function(){

        var links = $('#navContainer>nav>ul>li');
        var linksCount = links.length;

        for (var i=0;i<linksCount;i++){
            if (links.eq(i).children('a').html() == 'About'){
                links.eq(i).addClass('active');
            }
        }

    })();
</script>

<script type="text/javascript" src="./vendor/prettify/prettify.js"></script>

<script>
    prettyPrint();
</script>

<script>
    function resizeTable (){
        var windowWidth = $(window).width();
        var table = $('section table');
        if (windowWidth<700){
            if (!table.parent().is('div')){
                $('section table').wrap('<div></div>');
            }
            var tableWidth = $(window).width() - 70;
            console.log(tableWidth);
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
</script>

<script type="text/javascript" src="./public_html/js/side_nav.js"> </script>
<script type="text/javascript" src="./public_html/js/responsive_nav.js"></script>
<script type="text/javascript" src="./public_html/js/nested_nav.js"></script>


</body>
</html>