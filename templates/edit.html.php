<?php require('viewHeader.php'); ?>
<?php require('nav.php'); ?>



<link type="text/css" rel="stylesheet" href="/vendor/prettify/desert.css"/>

<div class="banner container">
     <h1><?php echo $title ?></h1>
     <div>

     </div>
</div>
<div class="container">
    <main>
        
        <form action = "../save/<?php echo $page ?>" method="post">
            <textarea name="content" rows = "20" cols = "100"><?php echo $body ?></textarea>
            <input type="submit" />
        </form>
        


    </main>
</div>
<?php require('viewFooter.php'); ?>