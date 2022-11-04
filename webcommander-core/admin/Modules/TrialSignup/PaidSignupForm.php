<?php
namespace WCC\Admin\Modules\TrialSignup;

class PaidSignupForm {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'trial_signup', array($this, 'form') );
    }

    /**
     * Signup Form
     * @author Rabiul
     * @since 1.0.0
     */
    public function form() {
        ?>
        <div class="trial-area js-paid-popup" id="paid-signup">
            <a href="#" class="js-close-trial" onclick="closeTrialPopUp(event)">Close</a>
            <div class="container">
                <div class="justify-content-center">
                    <div class="trial-head">
                        <h2 class="title">Sign up to get started</h2>
                        <p class="already">Already have an account? <a href="#" id="js-paid-header-login">Log in</a></p>
                    </div>
                    <div class="form-wrap">
                        <!-- Signup Form -->
                        <form id="wcc-paid-form" class="js-paid-checkemail">
                            <div class="single-input-box hidden-if-exists">
                                <input type="text" name="firstname" placeholder="First Name*">
                            </div>
                            <div class="single-input-box hidden-if-exists">
                                <input type="text" name="lastname" placeholder="Last Name*">
                            </div>
                            <div class="single-input-box hidden-if-exists">
                                <input type="text" name="mobile_number" placeholder="Mobile Number*">
                            </div>
                            <div class="single-input-box">
                                <input type="email" name="paid_email_address" id="check-email" class="js-check-email" placeholder="Email address*" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            </div>
                            <div class="single-input-box">
                                <input type="password" name="password" placeholder="Password*" pattern=".{6,}" title="use 6 or more (uppercase, lowercase, number & special) characters.">
                                <span class="wcc-email-already-exist js-email-already-exist"></span>
                            </div>
                            <div class="single-input-box hidden-if-exists">
                                <input type="text" name="store_name" placeholder="Store Name*">
                            </div>
                            <div class="single-input-box hidden-if-exists">
                                <select name="country_name" class="">
                                    <option value="">Select Country*</option>
                                    <?php
                                    $countries = wcc_country_list();
                                    foreach( $countries as $key=>$country ) :
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php selected( 'AU', $key ); ?>><?php echo $country; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="single-input-box hidden-if-exists">
                                <label for="paid-sale-online">
                                    <input type="checkbox" name="website_type" value="1" id="paid-sale-online" /> I wish to sell product or services from my website.
                                </label>
                            </div>
                            <div class="single-input-box submit-input-box hidden-if-exists">
                                <input type="submit" class="button-style-1-indp js-wcc-paid-form" value="Get Started">
                            </div>
                            <div class="lds-ring-bottom"><div></div><div></div><div></div><div></div></div>
                        </form>

                        <!-- Login form -->
                        <div class="wcc-paid-login-form js-paid-login-form-appender">
                            <script type="text/html" id="tmpl-wcc-paid-login-form">
                                <form class="wc_login_form js-wc-paid-login-form" id="wcc-paid-login-form" method="post">

                                    <# if( data != '' ) { #>
                                    <div class="single-input-box-readonly">
                                        {{data.email}}
                                        <input type="hidden" name="email" value="{{data.email}}" class="js-wcc-login-email" placeholder="Email">
                                    </div>
                                    <# }else { #>
                                    <div class="single-input-box">
                                        <input type="text" name="email" value="" class="js-wcc-login-email" placeholder="Email">
                                        <div class="email-error" style="display: none;"></div>
                                    </div>
                                    <# } #>
                                    <div class="single-input-box">
                                        <input type="password" name="password" placeholder="Password">
                                        <div class="password-error" style="display: none;"></div>
                                    </div>
                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="hidden_store_name" value="{{data.storeName}}">
                                    <input type="hidden" name="hidden_website_type" value="{{data.websiteType}}">
                                    <!-- Hidden Fields Ends -->
                                    <div class="single-input-box submit-input-box">
                                        <input type="submit" class="button-style-1-indp" value="Login">
                                        <a href="#" class="login-back js-paid-login-back"><i aria-hidden="true" class="fas fa-chevron-left"></i>Back</a>
                                    </div>
                                    <div class="message"></div>
                                </form>
                            </script>
                        </div>

                        <!-- After Login Form -->
                        <div class="wcc-paid-after-login-form js-paid-after-login-form-appender">
                            <script type="text/html" id="tmpl-wcc-paid-after-login-form">
                                <form id="wcc-paid-after-login" class="wc_login_form js_after_login_form">
                                    <div class="single-input-box">
                                        <input type="text" name="store_name" class="js-paid-store-name" placeholder="Store Name*" value="{{data.prefilledForm.storeName}}">
                                        <div class="form-error" id="paid-store-name-error" style="display: none;"></div>
                                    </div>
                                    <div class="single-input-box">
                                        <select name="country_name" class="">
                                            <option value="">Select Country*</option>
                                            <?php
                                            $countries = wcc_country_list();
                                            foreach( $countries as $key=>$country ) :
                                                ?>
                                                <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-error" id="paid-country-name-error" style="display: none;"></div>
                                    </div>
                                    <div class="single-input-box hidden-if-exists">
                                        <label for="after-login-paid-sale-online">
                                            <input type="checkbox" name="website_type" value="1" id="after-login-paid-sale-online" /> I wish to sell product or services from my website.
                                        </label>
                                    </div>
                                    <div class="single-input-box submit-input-box">
                                        <input type="submit" class="button-style-1-indp" value="Submit">
                                    </div>
                                    
                                    <div class="lds-ring-bottom"><div></div><div></div><div></div><div></div></div>
                                </form>
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}