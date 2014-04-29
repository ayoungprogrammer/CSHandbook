<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>


    

<div class="container">
    
    <div class="banner">
        <h1><?php echo $title?>  [<a href="./<?php echo $page.'&'?>=edit">edit</a>]</h1>
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