<?php require('indexHeader.php'); ?>
<?php require('nav.php'); ?>

<?php

// Set the Stripe key:
// Uses STRIPE_PUBLIC_KEY from the config file.
echo '<script type="text/javascript">Stripe.setPublishableKey("' . STRIPE_PUBLIC_KEY . '");</script>';

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Stores errors:
    $errors = array();

    // Need a payment token:
    if (isset($_POST['stripeToken'])) {

        $token = $_POST['stripeToken'];

        // Check for a duplicate submission, just in case:
        // Uses sessions, you could use a cookie instead.
        if (isset($_SESSION['token']) && ($_SESSION['token'] == $token)) {
            $errors['token'] = 'You have apparently resubmitted the form. Please do not do that.';
        } else { // New submission.
            $_SESSION['token'] = $token;
        }

    } else {
        $errors['token'] = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
    }

    // Set the order amount somehow:
    $amount = 2000; // $20, in cents

    // Validate other form data!

    // If no errors, process the order:
    if (empty($errors)) {

        // create the charge on Stripe's servers - this will charge the user's card
        try {

            // Include the Stripe library:
            require_once('includes/stripe/lib/Stripe.php');

            // set your secret key: remember to change this to your live secret key in production
            // see your keys here https://manage.stripe.com/account
            Stripe::setApiKey(STRIPE_PRIVATE_KEY);

            // Charge the order:
            $charge = Stripe_Charge::create(array(
                    "amount" => $amount, // amount in cents, again
                    "currency" => "usd",
                    "card" => $token,
                    "description" => $email
                )
            );

            // Check that it was paid:
            if ($charge->paid == true) {

                // Store the order in the database.
                // Send the email.
                // Celebrate!

            } else { // Charge was not paid!
                echo '<div class="alert alert-error"><h4>Payment System Error!</h4>Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction. You can try again or use another card.</div>';
            }

        } catch (Stripe_CardError $e) {
            // Card was declined.
            $e_json = $e->getJsonBody();
            $err = $e_json['error'];
            $errors['stripe'] = $err['message'];
        } catch (Stripe_ApiConnectionError $e) {
            // Network problem, perhaps try again.
        } catch (Stripe_InvalidRequestError $e) {
            // You screwed up in your programming. Shouldn't happen!
        } catch (Stripe_ApiError $e) {
            // Stripe's servers are down!
        } catch (Stripe_CardError $e) {
            // Something else that's not the customer's fault.
        }

    } // A user form submission error occurred, handled below.

} // Form submission.

?>
<section class="info container">

    <section class="banner container">

    </section>
    <main>
        <article>
            <h2>Donation</h2>
            <hr/>
            <br/>
            <div class="donateInfo">
                <p><em>The CS Handbook was created by two university students as an outside of school project.</em></p>
                <p>We're accepting donations so if you have some spare change please feel free to help us
                   out with our server maintenance fees and university education!</p>
            </div>
            <section>
               <!--PAYPAL-->
               <h3>PayPal</h3>
               <div class="donateButton">
                   <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

                       <?php // Show PHP errors, if they exist:
                       if (isset($errors) && !empty($errors) && is_array($errors)) {
                           echo '<div class="alert alert-error"><h4>Error!</h4>The following error(s) occurred:<ul>';
                           foreach ($errors as $e) {
                               echo "<li>$e</li>";
                           }
                           echo '</ul></div>';
                       }?>

                       <div id="payment-errors"></div>


                       <input type="hidden" name="cmd" value="_s-xclick">
                       <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
                       <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                       <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                   </form>
               </div>

               <br/><br/>

               <!--STRIPE.JS-->
               <h3>Pay with Card</h3>
               <div class="donateButton">
                   <!--
                   <form id="stripeForm" action="buy.php" method="POST">
                       <script
                           src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                           data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
                           data-amount="2000"
                           data-name="The CS Handbook"
                           data-description="2 widgets ($20.00)"
                           data-image="/128x128.png">
                       </script>
                   </form>
                   -->
                   <form action="donate.html.php" method="POST" id="payment-form">



                       <span class="help-block">You can pay using: Mastercard, Visa, American Express, JCB, Discover, and Diners Club.</span>

                       <div class="alert alert-info"><h4>JavaScript Required!</h4>For security purposes, JavaScript is required in order to complete an order.</div>

                       <label>Card Number</label>
                       <input type="text" size="20" autocomplete="off" class="card-number input-medium">
                       <span class="help-block">Enter the number without spaces or hyphens.</span>
                       <label>CVC</label>
                       <input type="text" size="4" autocomplete="off" class="card-cvc input-mini">
                       <label>Expiration (MM/YYYY)</label>
                       <input type="text" size="2" class="card-expiry-month input-mini">
                       <span> / </span>
                       <input type="text" size="4" class="card-expiry-year input-mini">

                       <button type="submit" class="btn" id="submitBtn">Submit Payment</button>

                   </form>
               </div>
            </section>

        </article>
    </main>
</section>

<?php require('donateFooter.php'); ?>