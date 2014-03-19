<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>

<div class="banner container">
    <h1><?php echo $title?></h1>
    <div>
      [<a href="./<?php echo $page.'&'?>=edit">edit</a>]
    </div>
</div>
<div class="container">
    <main>

        <?php echo $body ?>

    </main>



    <aside id="sideNav">
        <ul>
        </ul>
    </aside>


</div>
<?php require('listFooter.php'); ?>