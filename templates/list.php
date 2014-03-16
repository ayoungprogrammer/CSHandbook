<?php require('listHeader.php'); ?>
<?php require('nav.php'); ?>

<div class="banner container">
    <h1>Fundamentals</h1>
    <div>
        These are algorithms that every programmer should know.
        Whether you're an beginner or expert. No Excuses.
    </div>
</div>
<div class="container">
    <main>
        <article>
            <h3>{{alg name}}</h3>
            <hr/>
            <section class="description">
                Compute the greatest common divisor of
                two non-negative integers p and q as follows:
                If q is 0, the answer is p. If not, divide p by q
                and take the remainder r. The answer is the
                greatest common divisor of q and r.
            </section>
            <br/>
        </article>

    </main>



    <nav id="sideNav">
        <ul>
        </ul>
    </nav>


</div>
<?php require('listFooter.php'); ?>