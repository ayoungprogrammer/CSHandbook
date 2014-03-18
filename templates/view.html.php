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
        <article>
        <p id="breadcrumbs">
            <a href="#">Breadcrumb1</a>
            <a href="#">Breadcrumb1</a>
            <a href="#">Breadcrumb1</a>
            This page
        </p>
        <?php echo $body?>


        </article>

    </main>
</div>
<?php require('viewFooter.php'); ?>