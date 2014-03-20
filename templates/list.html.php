<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>

<div class="banner container">
    <h1><?php echo $title?>  [<a href="./<?php echo $page.'&'?>=edit">edit</a>]</h1>
</div>
<div class="container">
    <main>

        <?php breadcrumbs($page); ?>

        <?php echo $body; ?>

    </main>



    <aside id="sideNav">
        <ul>
        </ul>
    </aside>


</div>
<?php require('listFooter.php'); ?>