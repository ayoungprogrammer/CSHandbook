<footer>
    <strong>Feedback?</strong> <a href="mailto:feedback@thecshandbook.com"> Send us a message here</a>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script>
    (function(){

        var links = $('#navContainer>nav>ul>li');
        var linksCount = links.length;

        for (var i=0;i<linksCount;i++){
            if (links.eq(i).children('a').html() == 'Algorithms'){
                links.eq(i).addClass('active');
            }
        }

    })();
</script>

<script type="text/javascript" src="./public_html/vendor/prettify/prettify.js"></script>
<script>
    prettyPrint();
</script>

<script type="text/javascript" src="./public_html/vendor/typeahead/typeahead.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-50105859-2', 'thecshandbook.com');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

<script>
  (adsbygoogle = window.adsbygoogle || []).push({},{});
</script>

<script type="text/javascript" src="./public_html/js/responsive_table.js"></script>
<script type="text/javascript" src="./public_html/js/side_nav.js"> </script>
<script type="text/javascript" src="./public_html/js/responsive_nav.js"></script>
<script type="text/javascript" src="./public_html/js/nested_nav.js"></script>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</body>
</html>