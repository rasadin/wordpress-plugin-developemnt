<?php 
$_SESSION[ 'payment_done' ] = false;
wcc_secure_redirect(); // No Direct Access Allowed
/**
* This file contains the payment scuccess invoice contents
* @author Rabiul
* @since 1.0.0
*/
get_header();
?>
<div class="page-heading payment-sucess">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title title-success">Welcome to WebCommander! </h1>
            </div>
        </div>
        <p>You’re all signed up! You’ll soon recieve an email with your receipt and the next steps to get your website online fast!</p>
    </div>
</div>
<div class="container container-sm">
    <div class="signup-process steps" id="congratulations" data-url="template_step" data-id="congratulations">
        <div class="process-container">
            <div class="process-content congratulations" id="order_details">
                <?php  
                    /**
                     * Invoice Details Hook
                     * @hooked invocie_details
                     */
                    do_action( 'wcc_invoice_details' );

                    /**
                     * Template Information
                     * @hooked invoice_template_info
                     */
                    do_action( 'wcc_invoice_template_information' );

                    /**
                     * Web Commander Login URL
                     * @hooked login_url_link
                     */
                    do_action( 'wcc_success_login_url' );
                ?>
            </div>
        </div>
    </div>  
</div>
<?php 
unset($_SESSION['user_data']);
get_footer();