<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>


<div class="vertadbox">
    <!--<p><b>Advertisement:</b></p>-->
        <!-- CS Handbook Skyscraper -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:160px;height:600px"
             data-ad-client="ca-pub-3675316136020357"
             data-ad-slot="3512112222"></ins>
    </div>    

<div class="container">
    
    <div class="banner">
        <h1><?php echo $title?>  

            <?php if($GLOBALS['cfg']['env']=='stage'): ?>

            [<a href="./<?php echo $page.'&'?>=edit">edit</a>]

            <?php endif; ?>

        </h1>
    </div>
    
    <?php breadcrumbs($page); echo '<hr/>';?>

    <div class="horzadbox">
        <!--<p><b>Advertisement:</b></p>-->
        <!-- CS Handbook Leaderboard -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-3675316136020357"
             data-ad-slot="7523509425"></ins>
        
    </div>

    <main>
        <?php echo $body; ?>
    </main>

    <aside id="sideNav">
        <ul>
        </ul>
    </aside>


</div>
<?php require('listFooter.php'); ?>