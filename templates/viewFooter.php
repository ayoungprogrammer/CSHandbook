<footer>
    <strong>Feedback?</strong> <a href="mailto:simonhuang989@hotmail.com"> Send us a message here</a>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="../vendor/prettify/prettify.js"></script>
<script>
    prettyPrint();
</script>

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
<script type="text/javascript" src="./public_html/js/responsiveNav.js"></script>
<script type="text/javascript" src="./public_html/js/nestedNav.js"></script>

</body>
</html>