<?php  
namespace WCC\Admin\Modules\TrialSignup;

class SignupForm {
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
        <div class="trial-area js-trial-popup" id="free-signup">
            <a href="#" class="js-close-trial" onclick="closeTrialPopUp(event)">Close</a>
            <div class="container">
                <div class="justify-content-center">
                    <div class="trial-head">
                        <h2 class="title">..</h2>
                        <p class="already">Already have an account? <a href="#" id="js-header-login">Log in</a></p>
                    </div>
                    <div class="form-wrap">
                        <!-- Signup Form -->
                        <form id="wcc-trial-form" class="js-checkemail">
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
                                <input type="email" name="email_address" class="js-check-email" placeholder="Email address*" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" autocomplete="off">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            </div>
                            <div class="single-input-box">
                                <input type="password" name="password" placeholder="Password*"  pattern=".{6,}" title="use 6 or more (uppercase, lowercase, number & special) characters.">
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
                                <label for="trial-sale-online">
                                    <input type="checkbox" name="website_type" value="1" id="trial-sale-online" /> I wish to sell product or services from my website.
                                </label>
                            </div>


                            <div class="single-input-box submit-input-box hidden-if-exists">
                                <input type="submit" class="button-style-1-indp js-wcc-trial-form" value="Sign Up for free">
                            </div>
                            <div class="lds-ring-bottom"><div></div><div></div><div></div><div></div></div>
                        </form>

                        <!-- Login form -->
                        <div class="wcc-login-form js-login-form-appender">
                            <script type="text/html" id="tmpl-wcc-login-form">
                                <form class="wc_login_form js-wc-login-form" id="wcc-login-form" method="post">
                                    <# if( data != '' ) { #>
                                    <div class="single-input-box-readonly">
                                        {{data.email}}
                                        <input type="hidden" name="email" value="{{data.email}}" class="js-wcc-login-email" placeholder="Email">
                                    </div>
                                    <# }else { #>
                                    <div class="single-input-box">
                                        <input type="text" name="email" value="" class="js-wcc-login-email" placeholder="Email*">
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
                                        <a href="#" class="login-back js-login-back"><i aria-hidden="true" class="fas fa-chevron-left"></i>Back</a>
                                    </div>
                                    <div class="message"></div>
                                </form>
                            </script>
                        </div>
                        
                        <!-- After Login Form -->
                        <div class="wcc-after-login-form js-after-login-form-appender">
                            <script type="text/html" id="tmpl-wcc-after-login-form">
                            
                                <form id="wcc-trial-after-login" class="wc_login_form js_after_login_form">
                                    <div class="single-input-box">
                                        <input type="text" name="store_name" value="{{data.prefilledForm.storeName}}" class="js-trial-store-name" placeholder="Store Name*">
                                        <div class="form-error" id="store-name-error" style="display: none;"></div>
                                    </div>
                                    <div class="single-input-box">
                                        <select name="country_name" class="js-trial-country-name">
                                            <option value="">Select Country*</option>
                                            <?php  
                                                $countries = wcc_country_list();
                                                foreach( $countries as $key=>$country ) :
                                            ?>
                                            <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-error" id="country-name-error" style="display: none;"></div>
                                    </div>
                                    <div class="single-input-box hidden-if-exists">
                                        <label for="after-login-trial-sale-online">
                                            <input type="checkbox" name="website_type" value="1" id="after-login-trial-sale-online" /> I wish to sell product or services from my website.
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