<footer>
    <strong>Feedback?</strong> <a href="mailto:simonhuang989@hotmail.com"> Send us a message here</a>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">//
    // <![CDATA[
    Stripe.setPublishableKey('lksdajSDFmn2345nv');
    // ]]>
</script>

<script>
    // This function is just used to display error messages on the page.
    // Assumes there's an element with an ID of "payment-errors".
    function reportError(msg) {
        // Show the error in the form:
        $('#payment-errors').text(msg).addClass('alert alert-error');
        // re-enable the submit button:
        $('#submitBtn').prop('disabled', false);
        return false;
    }

    $(document).ready(function() {
        // Watch for a form submission:
        $("#payment-form").submit(function(event) {
            // Flag variable:
            var error = false;
            // disable the submit button to prevent repeated clicks:
            $('#submitBtn').attr("disabled", "disabled");
            // Get the values:
            var ccNum = $('.card-number').val(),
                cvcNum = $('.card-cvc').val(),
                expMonth = $('.card-expiry-month').val(),
                expYear = $('.card-expiry-year').val();

            if (!Stripe.validateCardNumber(ccNum)) {
                error = true;
                reportError('The credit card number appears to be invalid.');
            }
            if (!Stripe.validateCVC(cvcNum)) {
                error = true;
                reportError('The CVC number appears to be invalid.');
            }
            if (!Stripe.validateExpiry(expMonth, expYear)) {
                error = true;
                reportError('The expiration date appears to be invalid.');
            }
            // Validate other form elements, if needed!

            // Check for errors:
            if (!error) {

                // Get the Stripe token:
                Stripe.createToken({
                    number: ccNum,
                    cvc: cvcNum,
                    exp_month: expMonth,
                    exp_year: expYear
                }, stripeResponseHandler);

            }
            // Prevent the form from submitting:
            return false;
        }); // Form submission
    }); // Document ready.

    // Function handles the Stripe response:
    function stripeResponseHandler(status, response) {
        // Check for an error:
        if (response.error) {
            reportError(response.error.message);
        } else { // No errors, submit the form:
            var f = $("#payment-form");
            // Token contains id, last4, and card type:
            var token = response['id'];

            // Insert the token into the form so it gets submitted to the server
            f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            // Submit the form:
            f.get(0).submit();
        }
    } // End of stripeResponseHandler() function.
</script>

<script>
    (function(){

        var links = $('#navContainer>nav>ul>li');
        var linksCount = links.length;

        for (var i=0;i<linksCount;i++){
            if (links.eq(i).children('a').html() == 'Donate'){
                links.eq(i).addClass('active');
            }
        }

    })();
</script>


<script type="text/javascript" src="./public_html/js/responsive_nav.js"></script>
<script type="text/javascript" src="./public_html/js/nested_nav.js"></script>

</body>
</html>