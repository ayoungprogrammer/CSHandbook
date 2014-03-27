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

        var logoLink = $('#navContainer div a');
        var logo = $('#logo');
        var logoHover = $('#logoHover');
        logoLink.mouseenter(function(){
            logo.animate({'opacity': 0},100);
            logoHover.animate({'opacity': 1},400);
        });
        logoLink.mouseleave(function(){
            logo.animate({'opacity': 1},400);
            logoHover.animate({'opacity': 0},100);
        });
    })();
</script>
<script type="text/javascript" src="./public_html/js/responsive_nav.js"></script>
<script type="text/javascript" src="./public_html/js/nested_nav.js"></script>

</body>
</html>