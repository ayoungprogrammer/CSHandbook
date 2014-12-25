<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>


<div class="adbox">
    <p>Ad:<br></p>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- CS Handbook Ad1 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:300px;height:600px"
             data-ad-client="ca-pub-3675316136020357"
             data-ad-slot="5128446222"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
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

    <main>
        <?php echo $body; ?>
    </main>

    <aside id="sideNav">
        <ul>
        </ul>
    </aside>


</div>
<?php require('listFooter.php'); ?>