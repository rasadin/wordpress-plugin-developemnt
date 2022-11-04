(function($) {
    "use strict";

    /*
    * Scroll to Top
    * */
    var customScrollTo = function (topValue, time){
        jQuery("html, body").animate({
            scrollTop: topValue
        }, time);
    }

    /**
     * Trial Signup Popup
     * @author Rabiul
     * @since 1.0.0
     */
    var freeSignupPopup = function() {
        var freeSignUpBtn = '.js-free-signup';
        $(document.body).on('click', freeSignUpBtn, function(e) {
            e.preventDefault();
            e.stopPropagation();
            trialPopUp('.js-trial-popup');

            // Clea the local storage
            localStorage.clear();

            var signupType = 'free';

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'define_signup_type',
                    signup_type: signupType
                },
                success: function( res ) {
                    var data = JSON.parse( res );
                    console.log( data );
                }
            })
            
        })
    }
    freeSignupPopup();

    /**
    * Trial Form Validation
    * @author Rabiul
    * @since 1.0.0
    */
    var trialFormValidation = function() {

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) 
            {
                if (regexp.constructor != RegExp)
                    regexp = new RegExp(regexp);
                else if (regexp.global)
                    regexp.lastIndex = 0;
                return this.optional(element) || regexp.test(value);
            },
            "Please check your input."
    );

        $('#wcc-trial-form').validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 3
                },
                lastname: {
                    required: true,
                    minlength: 3
                },
                mobile_number: {
                    required: true,
                },
                email_address: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{6,}$/,

                },
                store_name: {
                    required: true
                },
                country_name: {
                    required: true,
                },
            }
        });
    }
    trialFormValidation();

    /**
     * Trail Form Login on Header Login Link Click
     * @author Rabiul
     * @since 1.0.0
     */
    var trialHeaderLoginClick = function() {
        var trialSignupForm = $('form.js-checkemail');
        var trialLoginForm = $('.js-login-form-appender');
        var template        = wp.template('wcc-login-form');

        // Header Text
        var titleText = 'Sign in to get started';
        var headerText = '';

        $(document.body).on( 'click', 'a#js-header-login', function(e) { 
            e.preventDefault();
            $('.trial-head .title').html(titleText);
            $('.trial-head p.already').addClass('already-exist').html(headerText);
            trialSignupForm.hide();
            trialLoginForm.show();
            var data = [];
            trialLoginForm.html(template(data));
        });
    }
    trialHeaderLoginClick();

    var isEmailAddress = function(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    /**
    * Check Email Address is Already Exists or Not
    * @author Rabiul
    * @since 1.0.0
    */
    var checkEmailAddress = function () {
        var freeForm = 'form.js-checkemail';

        $(document.body).on('submit', freeForm, function(e) {
            e.preventDefault();
            e.stopPropagation();

            var appnedTo   = $('.js-login-form-appender');
            var template   = wp.template('wcc-login-form');
            var typedEmail = $('input[name="email_address"]').val();
            var storeName =  $('form.js-checkemail input[name="store_name"]').val();
            var websiteType =  $('form.js-checkemail input[name="website_type"]')[0].checked;
            var countryName = $('form.js-checkemail select[name="country_name"]').val();

            // Header Text
            var titleText = 'Sign in to get started';
            var headerText = 'Seems like you already have an account. Please Login.';

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'check_email_address', // [N.B:] admin\Modules\Provision\Provision.php
                    typed_email: typedEmail,
                    store_name: storeName,
                    website_type: websiteType,
                    country_name: countryName,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    $('.lds-ring').addClass('show-loader');
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                    if(data.response.responseData.isEmailExists == true) {
                        $('.lds-ring').removeClass('show-loader');
                        localStorage.setItem('isEmailExists', 'true');
                        $(freeForm).hide();
                        appnedTo.show();
                        // redirect to login after 1 sec
                        setTimeout(function() {
                            $('.trial-head .title').html(titleText);
                            $('.trial-head p.already').addClass('already-exist').html(headerText);
                            appnedTo.html(template(data));
                        }, 500)
                    }else {
                        localStorage.setItem('isEmailExists', 'false');
                        $('form.js-checkemail').removeClass('js-checkemail').addClass('wcc-trial-form').trigger('submit');
                    }
                }
            });
        })
    }
    checkEmailAddress();

    /**
     * Paid Form Login on Header Login Link Click
     * @author Rabiul
     * @since 1.0.0
     */
    var paidHeaderLoginClick = function() {
        var paidSignupForm = $('form.js-paid-checkemail');
        var paidLoginForm = $('.js-paid-login-form-appender');
        var template        = wp.template('wcc-paid-login-form');

        // Header Text
        var titleText = 'Sign in to get started';
        var headerText = '';

        $(document.body).on( 'click', 'a#js-paid-header-login', function(e) { 
            e.preventDefault();
            $('.trial-head .title').html(titleText);
            $('.trial-head p.already').addClass('already-exist').html(headerText);
            paidSignupForm.hide();
            paidLoginForm.show();
            var data = [];
            paidLoginForm.html(template(data));
        });
    }
    paidHeaderLoginClick();

    /**
    * Check Paid Email Address is Already Exists or Not
    * @author Rabiul
    * @since 1.0.0
    */
    var checkPaidEmailAddress = function () {
        var paidForm = 'form.js-paid-checkemail';

        $(document.body).on('submit', paidForm, function(e) {
            e.preventDefault();
            e.stopPropagation();

            var appnedTo   = $('.js-paid-login-form-appender');
            var template   = wp.template('wcc-paid-login-form');
            var typedEmail = $('input[name = "paid_email_address"]').val();
            var storeName =  $('form.js-paid-checkemail input[name="store_name"]').val();
            var websiteType =  $('form.js-paid-checkemail input[name="website_type"]')[0].checked;

            // Header Text
            var titleText = 'Sign in to get started';
            var headerText = 'Seems like you already have an account. Please Login.';
  
            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'check_email_address', // [N.B:] admin\Modules\Provision\Provision.php
                    typed_email: typedEmail,
                    store_name: storeName,
                    website_type: websiteType,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    $('.lds-ring').addClass('show-loader');
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                    if(data.response.responseData.isEmailExists == true) {
                        $('.lds-ring').removeClass('show-loader');
                        localStorage.setItem('isEmailExists', 'true');
                        $(paidForm).hide();
                        appnedTo.show();
                        // redirect to login after 1 sec
                        setTimeout(function() {
                            $('.trial-head .title').html(titleText);
                            $('.trial-head p.already').addClass('already-exist').html(headerText);
                            appnedTo.html(template(data));
                        }, 500)
                    }else {
                        localStorage.setItem('isEmailExists', 'false');
                        $('form.js-paid-checkemail').removeClass('js-paid-checkemail').addClass('wcc-paid-form').trigger('submit');
                    }
                }
            });
        })
    }
    checkPaidEmailAddress();

    /**
    * Trial Signup Form Process
    * @author Rabiul
    * @since 1.0.0
    */
    var trialSignupFormProcess = function() {
        var trialForm = 'form.wcc-trial-form';
        $(document.body).on('submit', trialForm, function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $('.lds-ring').addClass('show-loader');

            var websiteType = $( '#trial-sale-online' )[0].checked;

            // Check if email address is existed or not
            if( 'false' == localStorage.getItem('isEmailExists') ) {
                setInterval(function() {
                    $('.lds-ring').removeClass('show-loader');
                }, 2000)
                
                setInterval(function() {
                    $.ajax({
                        url: publicLocalizer.ajaxUrl,
                        type: 'post',
                        data: {
                            action: 'trial_signup', // [N.B:] admin\Modules\Provision\Provision.php
                            fields: $('form.wcc-trial-form').serialize(),
                            website_type: websiteType,
                            nonce: publicLocalizer.nonce
                        },
                        beforeSend: function() {
                            // Remove email loader after 2 sec
                            
                            // Show Bottom Loader
                            $('.lds-ring-bottom').addClass('show-loader');
                            $('.js-wcc-trial-form').attr('value', 'Processing...')
                        },
                        success: function(res) {
                            // Removing All Loaders
                            $('.lds-ring').removeClass('show-loader');
                            $('.lds-ring-bottom').removeClass('show-loader');
    
                            var data  = JSON.parse(res);
                            if( data == 'success' ) {
                                window.location.replace( publicLocalizer.homeUrl + publicLocalizer.wccSettings['template-library-slug'] )
                            }
                        }
                    });
                }, 3000)
            }
        }) 
    }
    trialSignupFormProcess();

    /**
     * Paid Signup
     * @author Rabiul
     * @since 1.0.0
     */
    var paidSignupPopup =  function() {
        var paidSignupBtn = '.js-paid-signup';
        $(document.body).on('click', paidSignupBtn, function(e) {
            e.preventDefault();
            e.stopPropagation();
            trialPopUp('.js-paid-popup');

            // Clea the local storage
            localStorage.clear();

            var signupType = 'paid';

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'define_signup_type',
                    signup_type: signupType
                },
                success: function( res ) {
                    var data = JSON.parse( res );
                    console.log( data );
                }
            })
        })
    }
    paidSignupPopup();

    /**
    * Paid Form Validation
    * @author Rabiul
    * @since 1.0.0
    */
    var paidFormValidation = function() {

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) 
            {
                if (regexp.constructor != RegExp)
                    regexp = new RegExp(regexp);
                else if (regexp.global)
                    regexp.lastIndex = 0;
                return this.optional(element) || regexp.test(value);
            },
            "Please check your input."
    );

        $('#wcc-paid-form').validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 3
                },
                lastname: {
                    required: true,
                    minlength: 3
                },
                mobile_number: {
                    required: true,
                },
                paid_email_address: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*]).{6,}$/,
                },
                store_name: {
                    required: true
                },
                country_name: {
                    required: true,
                },
            }
        });
    }
    paidFormValidation();

    /**
    * Paid Signup Form
    * @author Rabiul
    * @since 1.0.0
    */
    var paidSignupFormProcess = function() {
        var paidForm = 'form.wcc-paid-form';
        $(document.body).on('submit', paidForm, function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $('.lds-ring').addClass('show-loader');

            var websiteType = $( '#paid-sale-online' )[0].checked;

            // Check if email address is existed or not
            if( 'false' == localStorage.getItem('isEmailExists') ) {
                setInterval(function() {
                    $('.lds-ring').removeClass('show-loader');
                }, 2000)
                
                setInterval(function() {
                    $.ajax({
                        url: publicLocalizer.ajaxUrl,
                        type: 'post',
                        data: {
                            action: 'paid_signup', // [N.B:] admin\Modules\Provision\Provision.php
                            fields: $('form.wcc-paid-form').serialize(),
                            website_type: websiteType,
                            nonce: publicLocalizer.nonce
                        },
                        beforeSend: function() {
                            // Remove email loader after 2 sec
                            
                            // Show Bottom Loader
                            $('.lds-ring-bottom').addClass('show-loader');
                            $('.js-wcc-paid-form').attr('value', 'Processing...')
                        },
                        success: function(res) {
                            // Removing All Loaders
                            $('.lds-ring').removeClass('show-loader');
                            $('.lds-ring-bottom').removeClass('show-loader');
    
                            var data  = JSON.parse(res);
                            if( data == 'success' ) {
                                window.location.replace( publicLocalizer.homeUrl + publicLocalizer.wccSettings['template-library-slug'] )
                            }
                        }
                    });
                }, 3000)
            }
        }) 
    }
    paidSignupFormProcess();

    /**
    * On Login back Link Click Action
    * @author Rabiul
    * @since 1.0.0
    */
    var onLoginInBackLinkClick = function() {
        var backLink = '.js-login-back';
        $(document.body).on('click', backLink, function(e) {
            e.preventDefault();
            $('form.js-checkemail').show();
            $('.js-login-form-appender').hide();
            $('.trial-head .title').html('Start your 15-day free trial');
            $('.trial-head .already').removeClass('already-exist').html('Already have an account? <a href="#" id="js-header-login">Log in</a>');
        })
    }
    onLoginInBackLinkClick();

    /**
    * On Login back Link Click Action
    * @author Rabiul
    * @since 1.0.0
    */
    var onPaidLoginInBackLinkClick = function() {
        var backLink = '.js-paid-login-back';
        $(document.body).on('click', backLink, function(e) {
            e.preventDefault();
            $('form.js-paid-checkemail').show();
            $('.js-paid-login-form-appender').hide();
            $('.trial-head .title').html('Sign up to get started');
            $('.trial-head .already').removeClass('already-exist').html('Already have an account? <a href="#" id="js-paid-header-login">Log in</a>');
        })
    }
    onPaidLoginInBackLinkClick();

    /**
    * Wcc Trial Login Form
    * @author Rabiul
    * @since 1.0.0
    */
    var trialLoginFormProcess = function() {
        var loginForm = 'form.js-wc-login-form';
        $(document.body).on('submit', loginForm, function(e) {
            e.preventDefault();
            e.stopPropagation();

            var form = $(this);
            form.find(".message").empty();

            var appnedTo = $('.js-after-login-form-appender');
            var template = wp.template('wcc-after-login-form');

            var isPassword = $('#wcc-login-form input[name="password"]').val(); 
            var isEmail = $('#wcc-login-form input[name="email"]').val();
            if( isPassword != '' && isEmail != '' ) {
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'wc_login', // [N.B:] admin\Modules\Provision\Provision.php
                        fields: form.serialize(),
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        form.find("input[type='submit']").attr('value', 'Processing...')
                    },
                    success: function(res) {
                        form.find("input[type='submit']").attr('value', 'Login')
                        var data  = JSON.parse(res);
                        if( data.success == 1 ) {
                            $('.trial-head p.already').html('');
                            $('.js-login-form-appender').hide();
                            appnedTo.append(template(data));
                            $('#wcc-trial-after-login select[name="country_name"] option[value='+data.prefilledForm.country+']').attr('selected', 'selected');
                            if( data.prefilledForm.websiteType == 'true' ) {
                                $('#wcc-trial-after-login input[name="website_type"]').prop('checked', true);
                            }
                        }else{
                            form.find(".message").html("<span class='error'>"+data.data.message+"</span>")
                        }
                    }
                });
            }else if( isPassword == '' && isEmail == '' ) {
                form.find(".email-error").show();
                form.find(".email-error").html('<span class="error">This field is required!</span>');
                $('#wcc-login-form input[name="email"]').addClass('error');

                form.find(".password-error").show();
                form.find(".password-error").html('<span class="error">This field is required!</span>');
                $('#wcc-login-form input[name="password"]').addClass('error');
            }else if( isEmail != '' ) {
                if( !isEmailAddress( isEmail ) ) {
                    form.find(".email-error").show();
                    form.find(".email-error").html('<span class="error">Please enter a valid email address!</span>');
                    $('#wcc-login-form input[name="email"]').addClass('error');
                }
            }

            if( isPassword == '' ) {
                form.find(".password-error").show();
                form.find(".password-error").html('<span class="error">This field is required!</span>');
                $('#wcc-login-form input[name="password"]').addClass('error');
            }

        })
    }
    trialLoginFormProcess();

    /**
     * Password Login Field
     */
    var clearLoginFormError = function() {
        $(document.body).on( 'keyup', '#wcc-login-form input[name="password"], #wcc-paid-login-form input[name="password"]', function(e) {
            var passwordLength = $( this ).val().length;

            if( passwordLength < 1 ) {
                $('.password-error').show();
                $(".password-error").html('<span class="error">This field is required!</span>');
            }else {
                $('.password-error').hide();
                $('#wcc-login-form input[name="password"]').removeClass('error');
                $('#wcc-paid-login-form input[name="password"]').removeClass('error');
            }
        } )

        $(document.body).on( 'keyup', '#wcc-login-form input[name="email"], #wcc-paid-login-form input[name="email"]', function(e) {
            var emaillength = $( this ).val().length;

            if( emaillength < 1 ) {
                $('.email-error').show();
                $(".email-error").html('<span class="error">This field is required!</span>');
            }else {
                $('.email-error').hide();
                $('#wcc-login-form input[name="email"]').removeClass('error');
                $('#wcc-paid-login-form input[name="email"]').removeClass('error');
            }
        } )
    }
    clearLoginFormError();

    /**
    * Wcc Paid Login Form
    * @author Rabiul
    * @since 1.0.0
    */
    var paidLoginFormProcess = function() {
        var loginForm = 'form.js-wc-paid-login-form';
        $(document.body).on('submit', loginForm, function(e) {
            e.preventDefault();
            e.stopPropagation();

            var form = $(this);
            form.find(".message").empty();

            var appnedTo = $('.js-paid-after-login-form-appender');
            var template = wp.template('wcc-paid-after-login-form');

            var isPassword = $('#wcc-paid-login-form input[name="password"]').val();
            var isEmail = $('#wcc-paid-login-form input[name="email"]').val();
            if( isPassword != '' && isEmail != '' ) {
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'wc_login', // [N.B:] admin\Modules\Provision\Provision.php
                        fields: form.serialize(),
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        form.find("input[type='submit']").attr('value', 'Processing...')
                    },
                    success: function(res) {
                        form.find("input[type='submit']").attr('value', 'Login')
                        var data  = JSON.parse(res);
                        console.log(data);
                        if( data.success == 1 ) {
                            $('.trial-head p.already').html('');
                            $('.js-paid-login-form-appender').hide();
                            appnedTo.append(template(data));
                            $('#wcc-paid-after-login select[name="country_name"] option[value='+data.prefilledForm.country+']').attr('selected', 'selected');
                            if( data.prefilledForm.websiteType == 'true' ) {
                                $('#wcc-paid-after-login input[name="website_type"]').prop('checked', true);
                            }
                        }else{
                            form.find(".message").html("<span class='error'>"+data.data.message+"</span>")
                        }
                    }
                });
            }else if( isPassword == '' && isEmail == ''  ) {
                form.find(".email-error").show();
                form.find(".email-error").html('<span class="error">This field is required!</span>');
                $('#wcc-paid-login-form input[name="email"]').addClass('error');

                form.find(".password-error").show();
                form.find(".password-error").html('<span class="error">This field is required!</span>');
                $('#wcc-paid-login-form input[name="password"]').addClass('error');
            }else if( isEmail != '' ) {
                if( !isEmailAddress( isEmail ) ) {
                    form.find(".email-error").show();
                    form.find(".email-error").html('<span class="error">Please enter a valid email address!</span>');
                    $('#wcc-paid-login-form input[name="email"]').addClass('error');
                }
            }

            if( isPassword == '' ) {
                form.find(".password-error").show();
                form.find(".password-error").html('<span class="error">This field is required!</span>');
                $('#wcc-paid-login-form input[name="password"]').addClass('error');
            }
        })
    }
    paidLoginFormProcess();

    

    /**
    * After Login Process
    * @author Rabiul
    * @since 1.0.0
    */
    var afterLoginTrailProcess = function() {
        // Sending request on form submission
        $(document.body).on('submit', '#wcc-trial-after-login', function(e) {
            e.preventDefault();
            var trialStoreName      = $( '#wcc-trial-after-login input[name="store_name"]' ).val();
            var trialCountryName    = $( '#wcc-trial-after-login select[name="country_name"]' ).val();
            var websiteType         = $( '#wcc-trial-after-login input[name="website_type"]' )[0].checked;

            $('.form-error').hide();
            
            if( trialStoreName != '' && trialCountryName != '' ) {
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'save_user_data_after_login', // [N.B:] admin\Modules\Provision\Provision.php
                        fields: $('#wcc-trial-after-login').serialize(),
                        website_type: websiteType,
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        // Show Bottom Loader
                        $('.lds-ring-bottom').addClass('show-loader');
                        $('#wcc-trial-after-login').find("input[type='submit']").attr('value', 'Processing...');
                    },
                    success: function(res) {
                        var data  = JSON.parse(res);
    
                        if( 'success' == data ) {
                            window.location.replace( publicLocalizer.homeUrl + publicLocalizer.wccSettings['template-library-slug'] )
                        }else if('required' == data) {
                            $('.error-message').show();
                            $('.error-message').html('Please fillup the required fields!');
                            $('#wcc-trial-after-login').find("input[type='submit']").attr('value', 'Submit');
                            $('.lds-ring-bottom').removeClass('show-loader');
                        }else {
                            $('.error-message').show();
                            $('.error-message').html('Sorry! Something went wrong! Please try again!');
                            $('#wcc-trial-after-login').find("input[type='submit']").attr('value', 'Submit');
                            $('.lds-ring-bottom').removeClass('show-loader');
                        }
                        
                    }
                });
            }
            if(trialStoreName == '') {
                $( '#store-name-error' ).show();
                $( '#wcc-trial-after-login input[name="store_name"]' ).addClass('error');
                $( '#store-name-error' ).html('This field is required');
            }
            if(trialCountryName == '') {
                $( '#country-name-error' ).show();
                $( '#wcc-trial-after-login select[name="country_name"]' ).addClass('error');
                $( '#country-name-error' ).html('This field is required');
            }
            
        })
    }
    afterLoginTrailProcess();

    /**
     * After Login Trial Form Validation
     */
    var afterLoginTrialFormValidation = function() {
        $(document.body).on( 'keyup', '#wcc-trial-after-login input[name="store_name"]', function(e) {
            var trialStoreName      = $( '#wcc-trial-after-login input[name="store_name"]' ).val();
            if( trialStoreName != '' ) {
                $( '#store-name-error' ).hide();
                $( '#wcc-trial-after-login input[name="store_name"]' ).removeClass('error');
            }else {
                $( '#store-name-error' ).show();
                $( '#store-name-error' ).html('This field is required');
                $( '#wcc-trial-after-login input[name="store_name"]' ).addClass('error');
            }
        });

        $(document.body).on( 'change', '#wcc-trial-after-login select[name="country_name"]', function(e) {
            var trialCountryName    = $( '#wcc-trial-after-login select[name="country_name"]' ).val();
            if( trialCountryName != '' ) {
                $( '#country-name-error' ).hide();
                $( '#wcc-trial-after-login select[name="country_name"]' ).removeClass('error');
            }else {
                $( '#country-name-error' ).show();
                $( '#wcc-trial-after-login select[name="country_name"]' ).addClass('error');
                $( '#country-name-error' ).html('This field is required');
            }
        });
        
    } 
    afterLoginTrialFormValidation();

    /**
    * After Login Process (Paid)
    * @author Rabiul
    * @since 1.0.0
    */
    var afterLoginPaidProcess = function() {
        // Sending request on form submission
        $(document.body).on('submit', '#wcc-paid-after-login', function(e) {
            e.preventDefault();

            var paidStoreName   = $( '#wcc-paid-after-login input[name="store_name"]' ).val();
            var paidCountryName = $( '#wcc-paid-after-login select[name="country_name"]' ).val();
            var websiteType     = $( '#wcc-paid-after-login input[name="website_type"]' )[0].checked;

            $('.form-error').hide();

            if( paidStoreName != '' && paidCountryName != '' ) {
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'save_user_data_after_login', // [N.B:] admin\Modules\Provision\Provision.php
                        fields: $('#wcc-paid-after-login').serialize(),
                        website_type: websiteType,
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        // Show Bottom Loader
                        $('.lds-ring-bottom').addClass('show-loader');
                        $('#wcc-paid-after-login').find("input[type='submit']").attr('value', 'Processing...')
                    },
                    success: function(res) {
                        var data  = JSON.parse(res);

                        if( 'success' == data ) {
                            window.location.replace( publicLocalizer.homeUrl + publicLocalizer.wccSettings['template-library-slug'] )
                        }else if('required' == data) {
                            $('.error-message').show();
                            $( '.error-message' ).html( 'Please fillup the required fields!' );
                        }else {
                            $('.error-message').show();
                            $( '.error-message' ).html( 'Sorry! Something went wrong! Please try again!' );
                        }
                        
                    }
                });
            }
            if(paidStoreName == '') {
                $( '#paid-store-name-error' ).show();
                $( '#paid-store-name-error' ).html('This field is required');
                $( '#wcc-paid-after-login input[name="store_name"]' ).addClass('error');
            }
            if(paidCountryName == '') {
                $( '#paid-country-name-error' ).show();
                $( '#paid-country-name-error' ).html('This field is required');
                $( '#wcc-paid-after-login select[name="country_name"]' ).addClass('error');
            }
            
            
        })
    }
    afterLoginPaidProcess();

    /**
     * After Login Paid Form Validation
     */
    var afterLoginPaidFormValidation = function() {
        $(document.body).on( 'keyup', '#wcc-paid-after-login input[name="store_name"]', function(e) {
            var paidStoreName   = $( '#wcc-paid-after-login input[name="store_name"]' ).val();
            if( paidStoreName != '' ) {
                $( '#paid-store-name-error' ).hide();
                $( '#wcc-paid-after-login input[name="store_name"]' ).removeClass('error');
            }else {
                $( '#paid-store-name-error' ).show();
                $( '#paid-store-name-error' ).html('This field is required');
                $( '#wcc-paid-after-login input[name="store_name"]' ).addClass('error');
            }
        });

        $(document.body).on( 'change', '#wcc-paid-after-login select[name="country_name"]', function(e) {
            var paidCountryName    = $( '#wcc-paid-after-login select[name="country_name"]' ).val();
            if( paidCountryName != '' ) {
                $( '#paid-country-name-error' ).hide();
                $( '#wcc-paid-after-login select[name="country_name"]' ).removeClass('error');
            }else {
                $( '#paid-country-name-error' ).show();
                $( '#paid-country-name-error' ).html('This field is required');
                $( '#wcc-paid-after-login select[name="country_name"]' ).addClass('error');
            }
        });
        
    } 
    afterLoginPaidFormValidation();
    
    /**
     * Payment Propcess Loader
     * @author Rabiul
     * @since 1.0.0
     */
    var paymentLoader = function() {
        var paymentBtn = $('.js-payment-btn');

        $(paymentBtn).on('click', function(e) {
            showPaymentLoader(e, publicLocalizer.homeUrl);
        })
    }
    paymentLoader();

    /**
     * Load more templates from web commander
     * @author Rabiul
     * @since 1.0.0
     */
    var loadmoreTemplate = function() {
        var loadTemplate = $('.js-load-more-template');
        var perPage = parseInt(publicLocalizer.posts_per_page, 10);
        var offset  = perPage;

        $(loadTemplate).on('click', function(e) {
            var _self = $(this);
            e.preventDefault();

            var appnedTo = $('.js-template-appender');
            var template = wp.template('load-templates');

            var spinner = 'Loading...';

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'loadmore_templates', // 
                    per_page: perPage,
                    offset: offset,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    _self.html('').append(spinner);
                    _self.hide();
                },
                success: function(res) {
                    // Parsing JSON Data
                    var data  = JSON.parse(res);

                    // Increment Offset
                    offset += parseInt( perPage, 10 );

                    // Append Data
                    appnedTo.append(template(data));

                    // Remove Loader
                    _self.html('Load More');

                    // Hiding Load More Button If No More Posts.
                    if( data.totalTemplates <= offset || data.totalTemplates == perPage  ) {
                        _self.hide();
                    }else {
                        _self.show();
                    }

                }
            });
        })
    }
    loadmoreTemplate();

    /**
     * Get Selected Template
     * @author Rabiul
     * @since 1.0.0
     */
    var getSelectedTemplate = function() {
        $(document.body).on('click', '.js-is-selected', function(e) {
            e.preventDefault();
            var selectedTemplate = $(this).data('template-id');
            var selectedTemplateTieredID = $(this).data('tiered-id');
            var taxAmount = $(this).data('tax-amount');

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'set_template_id', // [N.B:] admin\Modules\Provision\Provision.php
                    template_id: selectedTemplate,
                    tiered_id: selectedTemplateTieredID,
                    tax_amount: taxAmount,
                    nonce: publicLocalizer.nonce
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                }
            });
        })
    }
    getSelectedTemplate();
    
    /**
     * Template Selection
     * @author Rabiul 
     * @since 1.0.0
     */
    var templateSelection = function() {
        var selectLink = '.js-is-selected';
        $(document.body).on('click', selectLink, function(e) {

            e.preventDefault();
            var selectedTemplate = $(this).data('template-id');

            $('.single-popular .img').removeClass('selected');
            $('.js-next-link').hide();
            $('.js-paid-link').hide();
            $('.img-content a.demo').show();
            $(selectLink).show();
            $(this).parents('.img-content-inner').prev().prev().attr('checked', 'checked');
            
            if( publicLocalizer.signupType == 'free' ) {
                $(this).parents('.img-content').find('a.demo').hide();
                $(this).parents('.img-content').append('<a href="#" class="select link link-style-1-indp js-next-link" data-temp-id-last="'+selectedTemplate+'">Next</a>');
            }else if( publicLocalizer.signupType == 'paid' ) {
                $(this).parents('.img-content').find('a.demo').hide();
                $(this).parents('.img-content').append('<a href="'+theme_localizer.home_url + 'additional-packages" class="select link link-style-1-indp js-paid-link">Next</a>');
            }
            $(this).hide();
            $(this).parents('.img').addClass('selected');
        })        
    }
    templateSelection();

    /**
    * Package Selection
    * @author Rabiul
    * @since 1.0.0
    */
    var packageSelection = function() {
        var selectPackage = '.js-add-package';
        $(document.body).on('click', selectPackage, function(e) {
            var _self = $(this);
            e.preventDefault();
            $(this).html( 'Adding...' );
            var packageID       = $(this).data('package-id');
            var packageName     = $(this).data('package-name');
            var packageTieredID = $(this).data('package-tiered-id');
            var packageType     = $(this).data('package-type');
            var packagePrice    = $(this).data('package-price');
            var packageDuration = $(this).data('package-duration');
            var packageTaxValue = $(this).data('packageTaxValue');

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action                : 'package_selection', // [N.B: ] admin\Modules\Provision\Provision.php
                    package_id            : packageID,
                    package_name          : packageName,
                    package_tiered_id     : packageTieredID,
                    package_type          : packageType,
                    package_price         : packagePrice,
                    package_duration      : packageDuration,
                    data_package_tax_value: packageTaxValue,
                    nonce                 : publicLocalizer.nonce
                },
                beforeSend: function() {},
                success: function(res) {
                    var data  = JSON.parse(res);
                    if( !data ) {
                        console.log('Packge not included.')
                    }else {
                        _self.html('Remove').removeClass('js-add-package').addClass('js-remove-package')
                    }
                }
            });
        })
    }
    packageSelection();
    /**
    * Default Package Selection
    * @author Rabiul
    * @since 1.0.0
    */
    var defaultPackageSelection = function() {
        
        var selectPackage = '.js-default-package';
        $(document.body).trigger('click', selectPackage, function(e) {
            console.log('trigger')
            var _self = $(this);
            e.preventDefault();
            //  console.log($(this).data());
            var packageID       = $(this).data('package-id');
            var packageName     = $(this).data('package-name');
            var packageTieredID = $(this).data('package-tiered-id');
            var packageType     = $(this).data('package-type');
            var packagePrice    = $(this).data('package-price');
            var packageDuration = $(this).data('package-duration');
            var packageTaxValue = $(this).data('packageTaxValue');

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action                : 'package_selection', // [N.B: ] admin\Modules\Provision\Provision.php
                    package_id            : packageID,
                    package_name          : packageName,
                    package_tiered_id     : packageTieredID,
                    package_type          : packageType,
                    package_price         : packagePrice,
                    package_duration      : packageDuration,
                    data_package_tax_value: packageTaxValue,
                    nonce                 : publicLocalizer.nonce
                },
                beforeSend: function() {},
                success: function(res) {
                    var data  = JSON.parse(res);
                    if( !data ) {
                        console.log('Packge not included.')
                    }else {
                        _self.html('Remove').removeClass('js-add-package').addClass('js-remove-package')
                    }
                }
            });
        })
    }
    defaultPackageSelection();
    $('document').ready(function() {
        setTimeout(function() {
            $(".js-default-package").trigger('click');
        },10);
    });

    /**
    * Remove Package
    * @author Rabiul
    * @since 1.0.0
    */
    var removePackage = function() {
        var removePackage = '.js-remove-package';
        $(document.body).on('click', removePackage, function(e) {
            e.preventDefault();
            var _self       = $(this);
            var packageID   = $(this).data('package-id');
            var packageName = $(this).data('package-name');
            var packageTieredID = $(this).data('package-tiered-id');

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action           : 'remove_package', // [N.B: ] admin\Modules\Provision\Provision.php
                    package_id       : packageID,
                    package_name     : packageName,
                    package_tiered_id: packageTieredID,
                    nonce            : publicLocalizer.nonce
                },
                beforeSend: function() {},
                success: function(res) {
                    var data  = JSON.parse(res);
                    console.log(data);
                    if( !data ) {
                        console.log('No packges to be removed.')
                    }else {
                        _self.html('Add +').removeClass('js-remove-package').addClass('js-add-package')
                    }
                }
            });
        })
    }
    removePackage();

    /**
    * Trial Signup Process
    * @author Rabiul
    * @since 1.0.0
    */
    var trialSignupProcess = function() {
        var nextLink = '.js-next-link';
        $(document.body).on('click', nextLink, function(e) {
            e.preventDefault();

            var selectedTemplateLast = $(this).data('temp-id-last');
            // alert(selectedTemplateLast);


            // selectedTemplateLast = selectedTemplateLast.replace(/\s/g, '');

            // Loader
            $('.signup-preloader').css({
                'opacity': 1,
                'zIndex' : 10000
            });
            $('.lds-ring-bottom').css({
                'opacity': 1,
                'top' : '-50px'
            });

            // Scrolling Text
            $('.scroll-text-2').css({'opacity': 0});
            $('.scroll-text-3').css({'opacity': 0});

            setTimeout(function() {
                $('.scroll-text-1').css({'opacity': 0});
                $('.scroll-text-2').css({'opacity': 1});
            }, 3000);

            setTimeout(function() {
                $('.scroll-text-2').css({'opacity': 0});
                $('.scroll-text-3').css({'opacity': 1});
            }, 6000);

            $(".js-template-message").empty();
            if(publicLocalizer.signupType == 'free') {
                var templateID = selectedTemplateLast;
                var templateTieredID = publicLocalizer.template.tiered_id;
                // Ajax Request
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'trial_signup_process', // [N.B:] admin\Modules\Provision\Provision.php
                        template_id: templateID,
                        template_tired_id: templateTieredID,
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        $(nextLink).text('Redirecting...');
                    },
                    success: function(res) {
                        var data  = JSON.parse(res);
                        console.log(data);

                        if( data.isSuccess == true ) {
                            setTimeout( function() {
                                $('.preloader-title').addClass('signup-success').text('All done. Welcome to your new website!')
                            }, 3000 );
                            setTimeout( function() {
                                window.location.replace(data.responseData.login_url)
                            }, 5000 );
                        }else {
                            // Removing Loader
                            $('.signup-preloader').css({
                                'opacity': 0,
                                'zIndex' : -1
                            });
                            $('.lds-ring-bottom').css({
                                'opacity': 0,
                                'top' : '0px'
                            });

                            $(nextLink).text('Next');
                            if( data == 'noinstance' ) {
                                $(".js-template-message").html("<span class='error'>Request timed out for inactivity!</span>");
                                setTimeout( function() {
                                    window.location.replace(publicLocalizer.homeUrl('/pricing'));
                                }, 1500);
                            }else {
                                // When Error Occurs "+data.message+"
                                $(".js-template-message").html("<span class='error'>Some thing went wrong! Please contact with our support team.</span>");

                            }
                            customScrollTo(0, 500);
                        }
                    }
                });
            }
        })
    }
    trialSignupProcess();

    /**
    * Payment Process
    * @author Rabiul
    * @since 1.0.0
    */
    var paymentProcess = function() {
        var paymentForm = '#js-payment-form';
        $(document.body).on('submit', paymentForm, function(e) {
            $(".js-payment-message").empty();
            e.preventDefault();
            showPaymentLoader(e);
            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'payment_process', // [N.B:] admin\Modules\Provision\Provision.php
                    fields: $(paymentForm).serialize(),
                    tempalte_id: publicLocalizer.template.id,
                    nonce: publicLocalizer.nonce
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                    if( !data ) {
                        console.log('Payment Process Failed!');
                    }else {
                        
                        if(data.code === 0){
                            $(".js-payment-message").html("<span class='error'>"+data.response+"</span>");
                            reversePaymentLoader();
                        }else if(!data.isSuccess){
                            $(".js-payment-message").html("<span class='error'>"+data.message+"</span>");
                            reversePaymentLoader();
                        }else{
                            localStorage.setItem('wcc_login_url', data.responseData.login_url)
                            window.location.replace(publicLocalizer.homeUrl + publicLocalizer.wccSettings['payment-success-slug']);
                        }

                    }
                }
            });
        })        
    }
    paymentProcess();

    /**
    * Payment Process With Default card
    * @author Rabiul
    * @since 1.0.0
    */
    var paymentProcessWithDefaultCard = function() {
        var defaultCard = '.js-use-default-card';
        $(document.body).on('click', defaultCard, function(e) {
            $(".js-payment-message").empty();
            e.preventDefault();
            showPaymentLoader(e);
            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'payment_process_with_default_card', // [N.B:] admin\Modules\Provision\Provision.php
                    // fields: $(paymentForm).serialize(),
                    tempalte_id: publicLocalizer.template.id,
                    nonce: publicLocalizer.nonce
                },
                success: function(res) {
                    var data  = JSON.parse(res);
                    if( !data ) {
                        console.log('Payment Process Failed!');
                    }else {
                        
                        if(data.code === 0){
                            $(".js-payment-message").html("<span class='error'>"+data.response+"</span>");
                            reversePaymentLoader();
                        }else if(!data.isSuccess){
                            $(".js-payment-message").html("<span class='error'>"+data.message+"</span>");
                            reversePaymentLoader();
                        }else{
                            localStorage.setItem('wcc_login_url', data.responseData.login_url)
                            window.location.replace(publicLocalizer.homeUrl + publicLocalizer.wccSettings['payment-success-slug']);
                        }

                    }
                }
            });
        })        
    }
    paymentProcessWithDefaultCard();

    /**
    * Payment Process Validation
    * @author Rabiul
    * @since 1.0.0
    */
    $.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    var paymentProcessValidation = function() {
        // Get Current Year in 2 Digits
        // var currentYear = new Date().getFullYear().toString().substr(-2);
        // Validation
        $('#js-payment-form').validate({
            rules: {
                card_number: {
                    required: true,
                    minlength: 13,
                    maxlength: 16,
                    // creditcard: true
                },
                expire_month: {
                    required: true,
                },
                expire_year: {
                    required: true,
                },
                cvv: {
                    required: true,
                    number: true,
                    minlength: 3,
                    maxlength: 4,
                }
            },
            messages: {
                card_number: "Please provide valid card number.",
                expire_month: "Month field is required",
                expire_year: "Year field is required",
                cvv: "Invalid cvv code, Value must have 3 or 4 digits",
            }
        })
    }
    paymentProcessValidation();

    /**
    * Check for Successfull Login URL
    * @author Rabiul
    * @since 1.0.0
    */
    var successLoginUrl = function () {
        if( typeof (localStorage.getItem('wcc_login_url')) != 'undefined' ) {
            $('.js-wcc-success-login').attr('href', localStorage.getItem('wcc_login_url'));
        }else {
            $('.js-success-url').html( '<strong>Your site has been deployed. Please check your email for more information.</strong>' );
        }
    }
    successLoginUrl();

    

    /**
    * Template Sorting
    * @author Rabiul
    * @since 1.0.0
    */
    var templateSorting = function() {
        var categoryDropdown = '#wcc-template-category';
        var perPage = parseInt(publicLocalizer.posts_per_page, 10);
        $(document.body).on('change', categoryDropdown, function(e) {
            e.preventDefault();
            $('#wcc-search-template').trigger('reset');
            var category = $(this).val();
            console.log(category);
            var appnedTo = $('.js-template-appender');
            var template = wp.template('load-templates');
            
            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'template_sorting', // [N.B:] admin\Modules\Provision\Provision.php
                    category: category,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    appnedTo.find('.col-lg-4').remove();
                    appnedTo.find('.no-template-found').remove();
                    // Show Bottom Loader
                    $('.lds-ring-template').addClass('show-loader');
                },
                success: function(res) {
                    $('.default-templates').empty();
                    // Show Bottom Loader
                    $('.lds-ring-template').removeClass('show-loader');
                    var data  = JSON.parse(res);
                    if( data.templates.length !== 0 ) {
                        // Append Data
                        appnedTo.append(template(data));
                    }else {
                        appnedTo.append('<h4 class="no-template-found">No templates found!</h4>');
                    }

                    // Hiding Load More Button If No More Posts.
                    if( data.totalTemplates <= perPage  ) {
                        $('.js-load-more-template').hide();
                    }
                }
            });
        }) 
    }
    templateSorting();
    
    /**
    * Search Template
    * @author Rabiul
    * @since 1.0.0
    */
    var searchTemplate = function() {
        var searchForm = '#wcc-search-template';
        var perPage = parseInt(publicLocalizer.posts_per_page, 10);
        var appnedTo = $('.js-template-appender');
        var template = wp.template('load-templates');

        $(document.body).on('submit', searchForm, function(e) {
            e.preventDefault();
            var keyword = $('#wcc-template-serach-keyword').val();
            var category = $('#wcc-template-category').val();

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'template_searching', // [N.B:] admin\Modules\Provision\Provision.php
                    keyword: keyword,
                    category: category,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    appnedTo.find('.col-lg-4').remove();
                    appnedTo.find('.no-template-found').remove();
                    // Show Bottom Loader
                    $('.lds-ring-template').addClass('show-loader');
                },
                success: function(res) {
                    $('.default-templates').empty();
                    // Show Bottom Loader
                    $('.lds-ring-template').removeClass('show-loader');
                    var data  = JSON.parse(res);
                    if( data.templates.length !== 0 ) {
                        // Append Data
                        appnedTo.append(template(data));
                    }else {
                        appnedTo.append('<h4 class="no-template-found">No templates found!</h4>');
                    }
    
                    // Hiding Load More Button If No More Posts.
                    if( data.totalTemplates <= perPage  ) {
                        $('.js-load-more-template').hide();
                    }
                }
            });
            
        })

        
    }
    searchTemplate();

    /**
     * Skip Step Logic
     * @author Rabiul
     * @since 1.0.0
     */
    var skipStepLogic = function() {
        var skipStep = $('.js-skip');

        $(skipStep).on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var _self = $(this);
            if(publicLocalizer.signupType == 'free') {
                // Loader
                $('.signup-preloader').css({
                    'opacity': 1,
                    'zIndex' : 10000
                });
                $('.lds-ring-bottom').css({
                    'opacity': 1,
                    'top' : '-50px'
                });

                // Scrolling Text
                $('.scroll-text-2').css({'opacity': 0});
                $('.scroll-text-3').css({'opacity': 0});

                setTimeout(function() {
                    $('.scroll-text-1').css({'opacity': 0});
                    $('.scroll-text-2').css({'opacity': 1});
                }, 3000);

                setTimeout(function() {
                    $('.scroll-text-2').css({'opacity': 0});
                    $('.scroll-text-3').css({'opacity': 1});
                }, 6000);
                
                $.ajax({
                    url: publicLocalizer.ajaxUrl,
                    type: 'post',
                    data: {
                        action: 'trial_signup_process', // [N.B:] admin\Modules\Provision\Provision.php
                        template_id: 'BB72DCA5-2E7D-4479-AFCB-F0023B6870A5',
                        nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        _self.html('<div class="lds-ring skip-ring"><div></div><div></div><div></div><div></div></div>');
                    },
                    success: function(res) {
                        var data  = JSON.parse(res);
                        var redirectURL = data.responseData.login_url;
                        if( redirectURL != '' ) {
                            setTimeout( function() {
                                $('.preloader-title').addClass('signup-success').text('All done. Welcome to your new website!')
                            }, 3000 );
                            setTimeout( function() {
                                window.location.replace(redirectURL)
                            }, 5000 );
                            
                        }

                        
                    }
                });
                
            }else if(publicLocalizer.signupType == 'paid') {
                window.location.replace(publicLocalizer.homeUrl + 'additional-packages')
            }
        })
    }
    skipStepLogic();

})(jQuery);