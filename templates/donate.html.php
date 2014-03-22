<?php require('indexHeader.php'); ?>
<?php require('nav.php'); ?>

<section class="info container">

    <section class="banner container">

    </section>
    <main>
       <article>
            <h2>Donation</h2>
            <hr/>
            <p>
                Blurb
            </p>
           <section>
               <div class="donateButton">
                   <form action="" method="POST">
                       <script
                           src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                           data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
                           data-amount="2000"
                           data-name="Demo Site"
                           data-description="2 widgets ($20.00)"
                           data-image="/128x128.png">
                       </script>
                   </form>
               </div>
               <div class="donateButton">
                   <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                       <input type="hidden" name="cmd" value="_s-xclick">
                       <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
        ">
                       <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                       <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                   </form>
               </div>
           </section>

       </article>
    </main>
</section>

<?php require('indexFooter.php'); ?>