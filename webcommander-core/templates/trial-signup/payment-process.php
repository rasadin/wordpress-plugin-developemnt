<?php 
wcc_secure_redirect(); // No Direct Access Allowed
/**
* This page contains payment process content
* @author Rabiul
* @since 1.0.0
*/
get_header();

?>
<style>
    .paymnet-loader {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100000;
        background: rgba(82, 222, 151, 0.9);
        transform: scale(0);
    }
    .paymnet-loader-inner {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    .paymnet-loader span {
        display: block;
        width: 100%;
        font-size: 36px;
        color: #fff;
        line-height: 1;
        text-align: center;
    }
    .paymnet-loader .loader-circle {
        position: relative;
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #fff;
        margin-bottom: 20px;
        z-index: 0;
        -webkit-animation: rotate 1s infinite;
        animation: rotate 1s infinite;
    }
    .paymnet-loader .loader-circle::before {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #f9f9f9;
        top: 0px;
        left: 0px;
        z-index: 10;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
<!-- Payment Loader -->
<div class="paymnet-loader js-payment-loader">
    <div class="paymnet-loader-inner">
        <span class="loader-circle"></span>
        <span>Payment Processing</span>
    </div>
</div>
<!-- Payment Loader Ends -->

<div class="page-heading">
	<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">Finalise your purchase</h1>
            </div>
            <div class="col-md-8 offset-md-2">
                <p>Just one more step! Put in your payment information and start using WebCommander </p>
            </div>
        </div>
    </div>
</div>
<div class="finalise-area">
        <div class="container">
            <div class="js-payment-message"></div>
            
            <div class="row payment-process-row">
                <div class="middle-bar"></div>
                <div class="col-lg-5">
                    <div class="payment-method">
                        <h5 class="finalise-title">Payment Method</h5>
                        <?php if( !empty($_SESSION['user_data']['default_card']) ) : ?>
                        <div class="default-payment">
                            <button class="js-use-default-card button-style-1-indp">Use Default Card</button><br/><br />
                        </div>
                        <?php endif; ?>
                        <div class="credit-card">
                            <img src="<?php echo get_template_directory_uri() .'/assets/img/card.png' ?>" alt="">
                        </div>
                        <form id="js-payment-form">
                            <div class="single-input-box">
                                <label for="">Name On Card</label>
                                <input type="text" name="card_holder_name" placeholder="">
                            </div>
                            <div class="single-input-box">
                                <label for="">Card Number</label>
                                <input type="text" name="card_number" placeholder="" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="single-input-box">
                                        <label for="">Expiry Date</label>
                                        <select name="expire_month" id="" required>
                                            <option value="">Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="single-input-box">
                                        <label for=""></label>
                                        <select name="expire_year" id="" required>
                                            <option value="">Year</option>
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                            <option value="22">2022</option>
                                            <option value="23">2023</option>
                                            <option value="24">2024</option>
                                            <option value="25">2025</option>
                                            <option value="26">2026</option>
                                            <option value="27">2027</option>
                                            <option value="28">2028</option>
                                            <option value="29">2029</option>
                                            <option value="30">2030</option>
                                            <option value="31">2031</option>
                                            <option value="32">2032</option>
                                            <option value="33">2033</option>
                                            <option value="34">2034</option>
                                            <option value="35">2035</option>
                                            <option value="36">2036</option>
                                            <option value="37">2037</option>
                                            <option value="38">2038</option>
                                            <option value="39">2039</option>
                                            <option value="40">2040</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="single-input-box">
                                        <label for="">CVV Code</label>
                                        <input type="text" name="cvv" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="single-input-box text-left">
                                <input type="submit" value="Pay & Continue" class="button-style-1-indp js-payment-process">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <?php do_action('wcc_payment_summary'); ?>
                </div>
            </div>
            <div class="navs-of-lets-started">
                <div class="row">
                    <div class="col-12">
                        <div class="prev-post text-center">
                            <a href="<?php echo home_url('/additional-packages'); ?>" class="link prev-post link-style-1-indp">Previous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
get_footer();