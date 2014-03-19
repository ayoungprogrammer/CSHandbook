<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>





<div class="banner container">
     <h1><?php echo $title ?></h1>
     <div>

     </div>
</div>
<div class="container">
    <main>
        
        <form action = "./<?php echo $page.'&' ?>=submit" method="post">
            <textarea name="content" rows = "20" cols = "100"><?php echo $body ?></textarea>
            <input type="submit" />
        </form>
        


    </main>
</div>
<?php require('listFooter.php'); ?>