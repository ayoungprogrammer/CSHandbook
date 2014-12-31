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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50105859-2', 'thecshandbook.com');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

<script type="text/javascript" src="./public_html/js/responsive_nav.js"></script>
<script type="text/javascript" src="./public_html/js/nested_nav.js"></script>

<script type="text/javascript" src="./public_html/vendor/typeahead/typeahead.js"></script>

</body>
</html>