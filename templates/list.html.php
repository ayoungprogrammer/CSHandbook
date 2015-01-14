<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>

<!--
<div class="vertadbox">
  <ins class="adsbygoogle"
       style="display:inline-block;width:160px;height:600px"
       data-ad-client="ca-pub-3675316136020357"
       data-ad-slot="3512112222"></ins>
</div>-->

<div class="container">
    
    <div class="banner">
        <h1><?php echo $title?>  

            <?php if($GLOBALS['cfg']['env']=='stage'): ?>

            [<a href="./<?php echo $page.'&'?>=edit">edit</a>]

            <?php endif; ?>

        </h1>
    </div>
    
    <?php breadcrumbs($page); echo '<hr/>';?>


    <main>
        <div class="horzadbox">
          <!--<p><b>Advertisement:</b></p>-->
          <!-- CS Handbook Leaderboard -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:728px;height:90px"
               data-ad-client="ca-pub-3675316136020357"
               data-ad-slot="7523509425"></ins>
      </div>
        <?php echo $body; ?>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <div class="endadbox">
          <!-- CS Handbook End -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:300px;height:250px"
               data-ad-client="ca-pub-3675316136020357"
               data-ad-slot="7395961422"></ins>
        </div>
        <div class="addthis_container">
            <div class="addthis_native_toolbox">
                
            </div>
        </div>
    </main>

    <aside id="sideNav">
        <ul>
        </ul>
    </aside>


</div>
<?php require('listFooter.php'); ?>