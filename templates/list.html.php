<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>

<div class="banner container">
    <h1><?php echo $title?></h1>
    <div>
      [<a href="./edit/<?php echo $page?>">edit</a>]
    </div>
</div>
<div class="container">
    <main>

        <?php echo $body ?>

    </main>



    <nav id="sideNav">
        <ul>
        </ul>
    </nav>


</div>
<?php require('listFooter.php'); ?>