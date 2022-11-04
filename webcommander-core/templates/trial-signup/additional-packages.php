<?php 
wcc_secure_redirect(); // No Direct Access Allowed
/**
* This page contains additional packages content
* @author Rabiul
* @since 1.0.0
*/
get_header();
unset($_SESSION['packages']);
?>
<!-- Promotional Popup Starts -->
<div class="promotional-popup js-promotional-popup" style="transform: translateY(-100%)">
    <div class="promotional-popup-contents">
        <span class="close-it" onclick="closePromotionalPopup(event)"><i class="fas fa-times"></i></span>
        <div class="left">
            <h2 class="title">Limited <br> time offer!!</h2>
            <p class="text">Pre-pay for the Success Pack today and unlock the Template Cultomisation Pack for free! <br>
                Use this coupon code at the checkout and save <strong>$1100</strong>
            </p>
            <br>
            <!-- <h4 class="coupon-wrap">
                <span>SAVE50 </span>
                <a href="#" class="">Copy</a>
            </h4> -->

        </div>
        <div class="right">
            <div class="icon"><img src="<?php echo get_template_directory_uri() .'/assets/img/techni.png' ?>" alt=""></div>
            <h2 class="title">Get free template customization pack </h2>
        </div>
    </div>
</div>
<!-- Promotional Popup Ends -->
<div class="page-heading">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">Value packs to enhance your business operation</h1>
            </div>
            <div class="col-md-12">
            <p>Our templates are designed by our creative in-house design team.<br>Browse through and choose from a variety of designs or just search for your preferred template type.</p>
            </div>
        </div>
    </div>
</div>
<div class="value-pack-area">
    <div class="container">
        <div class="row">
            <?php  
                /**
                 * Hook: wcc_provision_pcakages
                 * @hooked get_provision_packages
                 */
                do_action( 'wcc_provision_pcakages' );
            ?>
        </div>

        <div class="navs-of-lets-started"> 
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="prev-post">
                        <a href="<?php echo home_url('/template-library'); ?>" class="link prev-post link-style-1-indp">Previous</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="next-post">
                        <a href="<?php echo home_url('/payment-process'); ?>" class="link link-style-1-indp">Next</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
get_footer();