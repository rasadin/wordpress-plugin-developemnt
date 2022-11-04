<?php 
namespace WCC\Admin\Modules;
use Webmascot\Provisioning\Provisioning;
use Webmascot\ApiHelper\Communicator\Data\ProvisioningAuthCredentialData;

class Provision {
    /**
     * Construct  Functions
     */
    public function __construct() {
        // Define Signup Type
        add_action( 'wp_ajax_define_signup_type', array( $this, 'define_signup_type' ) );
        add_action( 'wp_ajax_nopriv_define_signup_type', array( $this, 'define_signup_type' ) );

        add_action( 'wcc_template_library', array($this, 'get_provision_templates') );
        add_action( 'wcc_provision_pcakages', array($this, 'get_provision_packages') );
        // Loadmore Templates
        add_action( 'wp_ajax_loadmore_templates', array($this, 'loadmore_templates') );
        add_action( 'wp_ajax_nopriv_loadmore_templates', array($this, 'loadmore_templates') );
        // Trial Signup
        add_action( 'wp_ajax_trial_signup', array( $this, 'trial_signup' ) );
        add_action( 'wp_ajax_nopriv_trial_signup', array( $this, 'trial_signup' ) );
        // Paid Signup
        add_action( 'wp_ajax_paid_signup', array( $this, 'paid_signup' ) );
        add_action( 'wp_ajax_nopriv_paid_signup', array( $this, 'paid_signup' ) );
        // Login
        add_action( 'wp_ajax_wc_login', array( $this, 'wc_login' ) );
        add_action( 'wp_ajax_nopriv_wc_login', array( $this, 'wc_login' ) );
        // Select Package
        add_action( 'wp_ajax_package_selection', array( $this, 'package_selection' ) );
        add_action( 'wp_ajax_nopriv_package_selection', array( $this, 'package_selection' ) );
        // Remove Package
        add_action( 'wp_ajax_remove_package', array( $this, 'remove_package' ) );
        add_action( 'wp_ajax_nopriv_remove_package', array( $this, 'remove_package' ) );
        // Payment Process
        add_action( 'wp_ajax_payment_process', array( $this, 'payment_process' ) );
        add_action( 'wp_ajax_nopriv_payment_process', array( $this, 'payment_process' ) );
        // Payment Process With Default card
        add_action( 'wp_ajax_payment_process_with_default_card', array( $this, 'payment_process_with_default_card' ) );
        add_action( 'wp_ajax_nopriv_payment_process_with_default_card', array( $this, 'payment_process_with_default_card' ) );
        // Trial Signup Process
        add_action( 'wp_ajax_trial_signup_process', array( $this, 'trial_signup_process' ) );
        add_action( 'wp_ajax_nopriv_trial_signup_process', array( $this, 'trial_signup_process' ) );
        // Set Selected Template ID
        add_action( 'wp_ajax_set_template_id', array( $this, 'set_template_id' ) );
        add_action( 'wp_ajax_nopriv_set_template_id', array( $this, 'set_template_id' ) );
        // Invoice Hook
        add_action( 'wcc_invoice_details', array( $this, 'invocie_details' ) );
        // Invoice Template Info Hook
        add_action( 'wcc_invoice_template_information', array( $this, 'invoice_template_info' ) );
        // Check for Already Existed User Email
        add_action( 'wp_ajax_check_email_address', array( $this, 'check_email_address' ) );
        add_action( 'wp_ajax_nopriv_check_email_address', array( $this, 'check_email_address' ) );
        // Login Url Hook
        add_action( 'wcc_success_login_url', array( $this, 'login_url_link' ) );

        // Template Sorting
        add_action( 'wp_ajax_template_sorting', array( $this, 'template_sorting' ) );
        add_action( 'wp_ajax_nopriv_template_sorting', array( $this, 'template_sorting' ) );

        // Template Searching
        add_action( 'wp_ajax_template_searching', array( $this, 'template_searching' ) );
        add_action( 'wp_ajax_nopriv_template_searching', array( $this, 'template_searching' ) );
        
        // Payment Process Summary
        add_action( 'wcc_payment_summary', array( $this, 'payment_process_summary' ) );

        // Save User Data After Login
        add_action('wp_ajax_save_user_data_after_login', array( $this, 'save_user_data_after_login' ));
        add_action('wp_ajax_nopriv_save_user_data_after_login', array( $this, 'save_user_data_after_login' ));
    }

    /**
     * Provision Library Init
     * @author Rabiul
     * @since 1.0.0
     */
    public function provision_init() {
        $provision = $this->get_provision_data();

        $provisioningAuthCredentialData = new ProvisioningAuthCredentialData([
            'clientId'      => $provision->client_id,
            'clientSecret'  => $provision->client_secret,
            'accessToken'   => $provision->access_token,
            'refreshToken'  => $provision->refresh_token,
            'code'          => $provision->code,
            'url'           => $provision->url,
            'authTokenRenewCallback' => function(ProvisioningAuthCredentialData $authCredentialData){
                $data = array(
                    'client_id'     => $authCredentialData->getClientId(),
                    'client_secret' => $authCredentialData->getClientSecret(),
                    'access_token'  => $authCredentialData->getAccessToken(),
                    'refresh_token' => $authCredentialData->getRefreshToken(),
                    'code'          => $authCredentialData->getCode(),
                    'url'           => $authCredentialData->getUrl(),
                );

                $this->update_provision_data($data);

            },
            'instanceIdentifier' => "7852-18A2-85D2-144A"
        ]);

        return $provisioning = new Provisioning($provisioningAuthCredentialData);
    }

    /**
     * Get Provision Data
     * @author Rabiul
     * @since 1.0.0
     */
    public function get_provision_data() {
        global $wpdb;
        $table = $wpdb->prefix.'provision';
        $sql = "SELECT * FROM $table";
        $results = $wpdb->get_results($sql);
        
        $return_data = [];
        foreach( $results as $result ) {
            $return_data = array(
                'client_id'     => $result->client_id,
                'client_secret' => $result->client_secret,
                'access_token'  => $result->access_token,
                'refresh_token' => $result->refresh_token,
                'code'          => $result->code,
                'url'           => $result->url,
            );
        }
    
        return (object) $return_data;
    }

    /**
     * Update Provision Data
     * @author Rabiul
     * @since 1.0.0
     */
    public function update_provision_data($data) {
        global $wpdb;
        $table = $wpdb->prefix.'provision';
        $format = array('%s', '%s', '%s', '%s', '%s', '%s');
        $where = array( 'id' => 1 );
        $where_format = array( '%d' );

        $update = $wpdb->update( $table, $data, $where, $format, $where_format );

        /**
         * Write Log
         */
        $this->provision_log($data);

        if( false === $update ) {
            wp_die('Error in update');
        }
    }
    
    /**
    * Write Provision Log File
    * @author Rabiul
    * @since 1.0.0
    */
    public function provision_log($data) {
        $fp = \fopen( WCC_PLUGIN_PATH . '/log/provision.txt', 'w' );
        \fwrite( $fp, print_r($data, true) );
        \fclose($fp);
    }

    /**
     * Define Signup Type
     * @author Rabiul
     * @since 1.0.0
     */
    public function define_signup_type() {

        if( isset( $_POST[ 'signup_type' ] ) ) {
            $_SESSION[ 'signup_type' ] = $_POST[ 'signup_type' ];
            $_SESSION[ 'template' ] = array(
                'id' => '',
            );
        }else {
            $_SESSION[ 'signup_type' ] = false;
        }

        echo wp_json_encode( $_SESSION[ 'signup_type' ] );
        wp_die();

    }

    /**
    * Trial Signup
    * @author Rabiul
    * @since 1.0.0
    */
    public function trial_signup() {

        \check_ajax_referer( WCC_NONCE, 'nonce' );

        if( isset($_POST['fields']) ) {
            parse_str( $_POST['fields'], $fields );

            
            if( isset( $_POST['website_type'] ) && 'true' == $_POST['website_type'] ) {
                $store_type = 'E-COMMERCE';
            }else {
                $store_type = 'CONTENT';
            }

            // Storing user data in session
            $_SESSION['user_data'] = array(
                'firstname'         => $fields['firstname'],
                'lastname'          => $fields['lastname'],
                'password'          => isset($fields['password']) ? $fields['password'] : '123456',
                'mobile_number'     => $fields['mobile_number'],
                'email_address'     => $fields['email_address'],
                'store_name'        => $fields['store_name'],
                'template_id'       => null,
                'is_email_verified' => false,
                'country'           => $fields['country_name'],
                'state'             => $fields['state_name'],
                'city'              => $fields['city_name'],
                'zip'               => $fields['zip_code'],
                'store_type'        => $store_type,
            );
            $_SESSION['login_url']      = $signup['responseData']['login_url'];
            $_SESSION['identity_code']  = $signup['responseData']['identity_code'];
            $signup = 'success';
        }else {
            $signup = false;
        }

        echo wp_json_encode($signup);
        wp_die();
    }

    /**
    * Paid Signup
    * @author Rabiul
    * @since 1.0.0
    */
    public function paid_signup() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( isset($_POST['fields']) ) {
            parse_str( $_POST['fields'], $fields );

            if( 'true' == $_POST['website_type'] ) {
                $store_type = 'E-COMMERCE';
            }else {
                $store_type = 'CONTENT';
            }

            // Storing user data in session
            $_SESSION['user_data'] = array(
                'firstname'         => $fields['firstname'],
                'lastname'          => $fields['lastname'],
                'password'          => isset($fields['password']) ? $fields['password'] : '123456',
                'mobile_number'     => $fields['mobile_number'],
                'email_address'     => $fields['paid_email_address'],
                'store_name'        => $fields['store_name'],
                'template_id'       => null,
                'is_email_verified' => false,
                'country'           => $fields['country_name'],
                'state'             => $fields['state_name'],
                'city'              => $fields['city_name'],
                'zip'               => $fields['zip_code'],
                'store_type'        => $store_type
            );
            $_SESSION['login_url']      = $signup['responseData']['login_url'];
            $_SESSION['identity_code']  = $signup['responseData']['identity_code'];
            $signup = 'success';
        }else {
            $signup = false;
        }

        echo wp_json_encode($signup);
        wp_die();
    }

    /**
    * Webcommander Login
    * @author Iman Ali
    * @modified Rabiul
    * @since 1.0.0
    */
    public function wc_login() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( isset($_POST['fields']) ) {
            parse_str( $_POST['fields'], $fields );
            $email          = $fields['email'];
            $password       = $fields['password'];
            $website_type   = $fields['website_type'];
            $provisioning   = $this->provision_init();

            $account = $provisioning->account()->loginByEmailAndPassword($email, $password);
            
            $response = [
                'success'=> 0,
                'data'  =>$account,
            ];
            if($account['isSuccess'] == 1){
                $response_data = $account["responseData"];
                $country = empty($account['responseData']['country']) ? 'AU' : $account['responseData']['country'];

                $_SESSION['user_data'] = array(
                    'firstname'         => $account['responseData']['first_name'],
                    'lastname'          => $account['responseData']['last_name'],
                    'password'          => $password,
                    'mobile_number'     => $account['responseData']['phone'],
                    'email_address'     => $account['responseData']['email'],
                    'template_id'       => null,
                    'is_email_verified' => true,
                    'country'           => $country,
                    'state'             => $account['responseData']['state'],
                    'city'              => $account['responseData']['city'],
                    'zip'               => $account['responseData']['zip'],
                    'store_type'        => $fields['website_type'],
                    'store_name'        => '',
                    'default_card'      => $account['responseData']['default_card'],
                );
                $_SESSION['already_registered'] = true;
                $response['success'] = 1;
                $response['prefilledForm'] = [
                    'storeName'     => $fields['hidden_store_name'],
                    'websiteType'   => $fields['hidden_website_type'],
                    'country'       => $country
                ];

            }

            echo wp_json_encode($response);
            wp_die();
        }

        
    }

    /**
    * Find Template Type
    * @author Iman Ali
    * @since 1.0.0
    */
    public function get_template_type() {
        $store_type = null;
        $template_type = null;
        if(isset($_SESSION['user_data']['store_type']) && $_SESSION['user_data']['store_type']){
            $store_type = $_SESSION['user_data']['store_type'];
            if($store_type == 'E-COMMERCE'){
                return $template_type = 'ecommerce';
            }elseif ($store_type == 'CONTENT'){
                return $template_type = 'general';
            }
        }
    }

    /**
     * Get Templates
     * @author Rabiul
     * @since 1.0.0
     */
    public function get_provision_templates() {

        $provisioning   = $this->provision_init();
        $templates      = $provisioning->template()->listAll(get_option('posts_per_page'), 0, null, $this->get_template_type());

        $template_list  = $templates['responseData']['list'];
        $categories     = $provisioning->template()->typesAndCategory()['responseData']['categories'];
        ?>
        <div class="">
            <div class="container">
                <div class="category-browse-search">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cbs-category">
                                <label for="by">Browse by</label>
                                <select name="wcc_template_categories" id="wcc-template-category">
                                    <option value="">Select category</option>
                                    <?php foreach( $categories as $category ) : ?>
                                        <option value="<?php echo $category['name']; ?>"><?php echo $category['displayName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cbs-search">
                                <form id="wcc-search-template">
                                    <div class="input-box">
                                        <input type="text" id="wcc-template-serach-keyword" placeholder="Search">
                                        <button><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container category-container big mt-5 mb-5">
                <div class="message template-message js-template-message"></div>
                <div class="row default-templates">
                    <?php if( !empty($template_list) ) : ?>
                        <?php foreach( $template_list as $template ) : 
                            $tiered_id = isset($template['illustrator']['tiered_pricing'][0]['uuid']) ? $template['illustrator']['tiered_pricing'][0]['uuid'] : '';
                            
                            if( !empty($tiered_id) ) {
                                $tax_amount = $template['illustrator']['tiered_pricing'][0]['taxes'][0]['amount'];
                            }else {
                                $tax_amount = 0;
                            }
                        ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="single-popular">
                                    <div class="img">
                                        <span class="selected-icon"><i class="fas fa-check"></i></span>
                                        <img src="<?php echo esc_url($template['imageURL']); ?>" alt="<?php echo $template['name'] ?>">
                                        <div class="img-content">
                                            <input type="radio" name="popular" class="js-select-template" value="<?php echo $template['uuid']; ?>">
                                            <div class="img-content-inner">
                                                <p><a href="<?php echo esc_url($template['liveURL']); ?>" class="demo link link-style-1-indp" target="_blank">View Demo</a></p>
                                                <p><a href="" class="select link link-style-1-indp js-is-selected" data-template-id="<?php echo $template['uuid']; ?>" data-tiered-id="<?php echo $tiered_id; ?>" data-tax-amount="<?php echo $tax_amount; ?>">Select</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h6 class="type"><?php echo $template['type']; ?></h6>
                                        <h5 class="title"><?php echo $template['name']; ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                    <?php else: ?>
                        <div class="col-md-12 text-center">
                            <h2 class="no-template-text">No templates found!!</h2>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Appned Ajax Rendered Data -->
                <div class="row js-template-appender">
                    <script type="text/html" id="tmpl-load-templates">
                        <# _.each( data.templates, function( template, index ) { #>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="single-popular">
                                    <div class="img">
                                        <span class="selected-icon"><i class="fas fa-check"></i></span>
                                        <img src="{{template.imageURL}}" alt="{{template.name}}">
                                        <div class="img-content">
                                            <input type="radio" name="popular" class="js-select-template" value="{{template.uuid}}">
                                            <div class="img-content-inner">
                                                <p><a href="{{template.liveURL}}" class="demo link link-style-1-indp" target="_blank">View Demo</a></p>
                                                <p><a href="" class="select link link-style-1-indp js-is-selected" data-template-id="{{template.uuid}}" data-tiered-id="<?php echo $tiered_id; ?>" data-tax-amount="<?php echo $tax_amount; ?>">Select</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h6 class="type">{{{template.type}}}</h6>
                                        <h5 class="title">{{{template.name}}}</h5>
                                    </div>
                                </div>
                            </div>
                        <# }) #>
                    </script>
                </div>
                <?php 
                    $total_posts = $templates['responseData']['total']; 
                    $per_page = get_option('posts_per_page');

                    if( $total_posts > $per_page ) :   
                    
                ?>
                <!-- Load More Button -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-info btn-lg load-btn js-load-more-template">Load More</button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Load More Templates
     * @author Rabiulh
     * @since 1.0.0
     */
    public function loadmore_templates() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( isset($_POST['per_page']) && isset($_POST['offset']) ) {

            $template_type = $this->get_template_type();
            $provisioning = $this->provision_init();
            $templates = $provisioning->template()->listAll($_POST['per_page'], $_POST['offset'], null, $template_type);
            $template_list = $templates['responseData']['list'];
            $total = $templates['responseData']['total'];
            
        }else {
            $template_list = null;
        }

        $result = array(
            'templates' => $template_list,
            'totalTemplates' => $total
        );
        echo wp_json_encode($result);
        wp_die();
    }

    /**
    * Template Sorting By Category
    * @author Rabiul
    * @since 1.0.0
    */
    public function template_sorting() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( !empty($_POST['category']) ) {
            $category = $_POST['category'];
            $type = $this->get_template_type();

            $provisioning = $this->provision_init();
            $templates      = $provisioning->template()->listAll(get_option('posts_per_page'), 0, '', $type, $category);
            $template_list  = $templates['responseData']['list'];
            $total = $templates['responseData']['total'];
            $result = array(
                'templates' => $template_list,
                'totalTemplates' => $total
            );
        }else {
            $type = $this->get_template_type();

            $provisioning   = $this->provision_init();
            $templates      = $provisioning->template()->listAll( get_option('posts_per_page'), 0, '', $type );
            $template_list  = $templates['responseData']['list'];
            $total = $templates['responseData']['total'];
            $result = array(
                'templates' => $template_list,
                'totalTemplates' => $total
            );
        }

        echo wp_json_encode($result);
        wp_die();
    }

    /**
    * Template Searching by Keyword
    * @author Rabiul
    * @since 1.0.0
    */
    public function template_searching() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( isset($_POST['keyword']) ) {
            $category = !empty( $_POST['category'] ) ? $_POST['category'] : null;
            $keyword       = $_POST['keyword'];
            $type          = $this->get_template_type();
            $provisioning  = $this->provision_init();
            $templates     = $provisioning->template()->listAll(get_option('posts_per_page'), 0, $keyword, $type, $category );
            $template_list = $templates['responseData']['list'];
            $total         = $templates['responseData']['total'];
            $result        = array(
                'templates'      => $template_list,
                'totalTemplates' => $total
            );
        }

        echo wp_json_encode($result);
        wp_die();
    }

    /**
    * Get Packages
    * @author Rabiul
    * @since 1.0.0
    */
    public function get_provision_packages() {
        $provisioning   = $this->provision_init();
        $packages       = $provisioning->package()->listAll();
        $package_list   = $packages['responseData']['list'];
        
        if( !empty($package_list) ) : 
        ?>
            <?php foreach( $package_list as $key=>$package ) : ?>
                <?php  if( $key <= 1 ) : ?>
                    
                    <div class="col-lg-6 col-12">
                        <div class="lets-start-content">
                            
                            <?php 
                                $args = array(
                                    'post_type' => 'package',
                                    'post_status' => 'publish',
                                    'title' => $package['name']
                                );
                                $query = new \WP_Query($args);
                                if( !empty($query->posts) ) {
                                    foreach( $query->posts as $post ) {
                                        ?>
                                        <div class="icon">
                                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID)) ?>" alt="<?php echo $post->post_title; ?>">
                                        </div>
                                        <h2 class="title"><?php echo $post->post_title; ?></h2>
                                        <div class="pakcage-content">
                                            <?php echo $post->post_content; ?>
                                        </div>
                                        <?php
                                    }
                                }

                            $duration = '/'.$package['tiered_pricing'][0]['duration'];
                            if (strtoupper($package['tiered_pricing'][0]['duration']) == 'MONTHLY'){
                                $duration = '/mo';
                            }
                            else if (strtoupper($package['tiered_pricing'][0]['duration']) == 'YEARLY'){
                                $duration = '/yr';
                            }
                            elseif (strtoupper($package['tiered_pricing'][0]['duration']) == 'LIFE_TIME'){
                                $duration = '/One-off';
                            }
                            ?>

                            <?php 
                                $package_btn_text  = 'Add +';
                                $package_btn_class = 'js-add-package';
                                ob_start();
                                $package_link = '';
                                if( $key == 0 ) {
                                    $default_package = ' js-default-package hide-default-package';
                                    ?>
                                    <button type="button" class="add default-package" disabled>Remove</button>
                                    <a href="#" class="add link-style-3-indp <?php echo esc_attr($package_btn_class) . esc_attr($default_package); ?><?php  ?>" data-package-name="<?php echo $package['name'] ?>" data-package-id="<?php echo $package['uuid']; ?>" data-package-tiered-id="<?php echo $package['tiered_pricing'][0]['uuid']; ?>" data-package-type="<?php echo $package['package_type']; ?>" data-package-price="<?php echo $package['tiered_pricing'][0]['amount']; ?>"data-package-tax-value="<?php //echo $package['tax']['amount']; ?>"data-package-duration-shotcode="<?php echo $duration; ?>"data-package-duration="<?php echo $package['tiered_pricing'][0]['duration']; ?>"> <?php echo $package_btn_text; ?></a>
                                    <?php
                                }else {
                                    $default_package = '';
                                    ?>
                                    <a href="#" class="add link-style-3-indp <?php echo esc_attr($package_btn_class) . esc_attr($default_package); ?><?php  ?>" data-package-name="<?php echo $package['name'] ?>" data-package-id="<?php echo $package['uuid']; ?>" data-package-tiered-id="<?php echo $package['tiered_pricing'][0]['uuid']; ?>" data-package-type="<?php echo $package['package_type']; ?>" data-package-price="<?php echo $package['tiered_pricing'][0]['amount']; ?>"data-package-tax-value="<?php //echo $package['tax']['amount']; ?>"data-package-duration-shotcode="<?php echo $duration; ?>"data-package-duration="<?php echo $package['tiered_pricing'][0]['duration']; ?>"> <?php echo $package_btn_text; ?></a>
                                    <?php
                                }
                                ?>
                                <?php $package_link = ob_get_contents(); ob_end_clean(); ?>
                            <h2 class="price">$<?php echo $package['tiered_pricing'][0]['amount']; ?> <span class="duration"><?php echo $duration ?></span></h2>
                            <?php echo $package_link; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <h2>Sorry! No Pakcage Found!</h2>
            </div>
        <?php endif; ?>
        <?php
    }

    /**
    * Pakcage Selection
    * @author Rabiul
    * @since 1.0.0
    */
    public function package_selection() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if(isset($_POST['package_id']) && isset($_POST['package_name']) && isset($_POST['package_tiered_id']) && isset($_POST['package_type']) && isset($_POST['package_price']) && isset($_POST['package_duration']) ) {
            $selected_package = array(
                'name'      => $_POST['package_name'],
                'id'        => $_POST['package_id'],
                'tiered_id' => $_POST['package_tiered_id'],
                'type'      => $_POST['package_type'],
                'price'     => $_POST['package_price'],
                'duration'  =>  $_POST['package_duration'],
                'tax_value'  => $_POST['data_package_tax_value']
            );

            if(isset($_SESSION['packages'])) {
                array_push($_SESSION['packages'], $selected_package);
                $packages = array_values($_SESSION['packages']);
            }else {
                $_SESSION['packages'] = [$selected_package];
                $packages = $_SESSION['packages'];
            }
        }else {
            $_SESSION['packages'] = false;
        }

        echo wp_json_encode($packages);
        wp_die();
    }

    /**
    * Remove Package
    * @author Rabiul
    * @since 1.0.0
    */
    public function remove_package() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if(isset($_POST['package_id']) && isset($_POST['package_name']) ) {
            if(isset($_SESSION['packages'])) {
                $_SESSION['packages'] = array_values($_SESSION['packages']);
                $find = array_search( $_POST['package_id'], array_column($_SESSION['packages'], 'id') );
                unset($_SESSION['packages'][$find]);
                $packages = array_values($_SESSION['packages']);
            }else {
                return;
            }
        }else {
            $_SESSION['packages'] = false;
        }

        echo wp_json_encode($packages);
        wp_die();
    }

    /**
    * Trial Signup Process
    * @author Rabiul
    * @since 1.0.0
    */
    public function trial_signup_process() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if( isset( $_SESSION[ 'user_data' ] ) && ! empty( $_SESSION[ 'user_data' ] ) ) {
            if(isset($_POST['template_id'])) {

                $signup_data = [
                    "user_details"          => [
                        "first_name"    => isset($_SESSION['user_data']['firstname']) ? $_SESSION['user_data']['firstname'] : '',
                        "last_name"     => isset($_SESSION['user_data']['lastname']) ? $_SESSION['user_data']['lastname'] : '',
                        "company"       => "",
                        "email"         => isset($_SESSION['user_data']['email_address']) ? $_SESSION['user_data']['email_address'] : '',
                        "password"      => isset($_SESSION['user_data']['password']) ? $_SESSION['user_data']['password'] : '',
                        "phone"         => isset($_SESSION['user_data']['mobile_number']) ? $_SESSION['user_data']['mobile_number'] : '',
                        "web"           => "",
                        "street_address" => "",
                        "country"       => isset($_SESSION['user_data']['country']) ? $_SESSION['user_data']['country'] : '',
                        "state"         => isset($_SESSION['user_data']['state']) ? $_SESSION['user_data']['state'] : '',
                        "city"          => isset($_SESSION['user_data']['city']) ? $_SESSION['user_data']['city'] : '',
                        "zip"           => isset($_SESSION['user_data']['zip']) ? $_SESSION['user_data']['zip'] : '',
                        "is_email_verified" => true
                    ],
                    "is_user_registered"    => $_SESSION['already_registered'],
                    "default_template_uuid" => isset( $_SESSION['template']['tiered_id'] ) ? $_POST['template_id'] : $_SESSION['template']['id'],
                    "website_type"          => isset($_SESSION['user_data']['store_type']) ? $_SESSION['user_data']['store_type'] : ''
                ];
                // Init Provision
                $provisioning = $this->provision_init();
                $signup = $provisioning->account()->signup($signup_data);
                unset( $_SESSION[ 'user_data' ] );
            }else {
                $signup = 'noinstance';
            }
        }else {
            $signup = 'noinstance';
        }
        
        echo wp_json_encode($signup);
        wp_die();
    }

    /**
    * Payment Process
    * @author Rabiul
    * @since 1.0.0
    */
    public function payment_process() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if(isset( $_POST['fields'] )) {
            parse_str( $_POST['fields'], $fields );

            // Setting Session Data
            $_SESSION['payment_info'] = array(
                'card_holder_name'  => $fields['card_holder_name'],
                'card_number'       => $fields['card_number'],
                'expire'            => $fields['expire_month'].$fields['expire_year'],
                'cvv'               => $fields['cvv']
            );

            // Init Provision
            $provisioning = $this->provision_init();

            // Invoice Array
            $invoice_array = [];
            if( isset( $_SESSION['template'] ) && !empty( $_SESSION['template']['tiered_id'] ) ) {
                $template_array = [
                    "item_uuid" => $_SESSION['template']['id'],
                    "item_type" => "TEMPLATE",
                    "tiered_uuid" => $_SESSION['template']['tiered_id'],
                    "tax_uuid" => ""
                ];
                array_push( $invoice_array, $template_array);
            }

            if( isset( $_SESSION['packages'] ) ) {
                foreach( $_SESSION['packages'] as $package ) {
                    $package_list = [
                        "item_uuid" => $package['id'],
                        "item_type" => "PACKAGE",
                        "tiered_uuid" => $package['tiered_id'],
                        "tax_uuid" => ""
                    ];
                    array_push( $invoice_array, $package_list);
                }
            }

            // if( !empty($_SESSION['user_data']['default_card']) ) {
            //     $use_default_card = true;
            // }else {
            //     $use_default_card = false;
            // }

            $signup_data = [
                "user_details" => [
                    "first_name"    => $_SESSION['user_data']['firstname'],
                    "last_name"     => $_SESSION['user_data']['lastname'],
                    "company"       => "",
                    "email"         => $_SESSION['user_data']['email_address'],
                    "password"      => $_SESSION['user_data']['password'],
                    "phone"         => $_SESSION['user_data']['mobile_number'],
                    "web"           => "",
                    "street_address" => "",
                    "country"       => $_SESSION['user_data']['country'],
                    "state"         => $_SESSION['user_data']['state'],
                    "city"          => $_SESSION['user_data']['city'],
                    "zip"           => $_SESSION['user_data']['zip'],
                    "is_email_verified" => true
                ],
                "invoice" => $invoice_array,
                'payment' => [
                    'card_number'   => $_SESSION['payment_info']['card_number'],
                    'expires'       => $_SESSION['payment_info']['expire'],
                    'cvv'           => $_SESSION['payment_info']['cvv'],
                    'use_default'   => false,
                ],
                "is_user_registered" => $_SESSION['already_registered'],
                "default_template_uuid" => $_SESSION['template']['id'],
                "website_type"      => $_SESSION['user_data']['store_type']
            ];

            $signup = $provisioning->account()->signup($signup_data);
        }else {
            $_SESSION['payment_info'] = false;
            $signup = false;
        }

        echo wp_json_encode($signup);
        wp_die();
    }

    /**
<<<<<<< HEAD
    * Invocie Info 
=======
    * Payment Process With Default Card
    * @author Rabiul
    * @since 1.0.0
    */
    public function payment_process_with_default_card() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        // Init Provision
        $provisioning = $this->provision_init();

        // Invoice Array
        $invoice_array = [];
        if( isset( $_SESSION['template'] ) && !empty( $_SESSION['template']['tiered_id'] ) ) {
            $template_array = [
                "item_uuid" => $_SESSION['template']['id'],
                "item_type" => "TEMPLATE",
                "tiered_uuid" => $_SESSION['template']['tiered_id'],
                "tax_uuid" => ""
            ];
            array_push( $invoice_array, $template_array);
        }

        if( isset( $_SESSION['packages'] ) ) {
            foreach( $_SESSION['packages'] as $package ) {
                $package_list = [
                    "item_uuid" => $package['id'],
                    "item_type" => "PACKAGE",
                    "tiered_uuid" => $package['tiered_id'],
                    "tax_uuid" => ""
                ];
                array_push( $invoice_array, $package_list);
            }
        }

        $signup_data = [
            "user_details" => [
                "first_name"    => $_SESSION['user_data']['firstname'],
                "last_name"     => $_SESSION['user_data']['lastname'],
                "company"       => "",
                "email"         => $_SESSION['user_data']['email_address'],
                "password"      => $_SESSION['user_data']['password'],
                "phone"         => $_SESSION['user_data']['mobile_number'],
                "web"           => "",
                "street_address" => "",
                "country"       => $_SESSION['user_data']['country'],
                "state"         => $_SESSION['user_data']['state'],
                "city"          => $_SESSION['user_data']['city'],
                "zip"           => $_SESSION['user_data']['zip'],
                "is_email_verified" => true
            ],
            "invoice" => $invoice_array,
            'payment' => [
                'use_default'   => true,
            ],
            "is_user_registered" => $_SESSION['already_registered'],
            "default_template_uuid" => $_SESSION['template']['id'],
            "website_type"      => $_SESSION['user_data']['store_type']
        ];

        $signup = $provisioning->account()->signup($signup_data);

        echo wp_json_encode($signup);
        wp_die();
    }

    /**
    * Invocie Info
>>>>>>> 11d26ed950e1cc9cf5620409a686b29fdec9cafa
    * @author Rabiul
    * @since 1.0.0
    */
    public function invocie_details() {
        // Init Provision
        $provisioning = $this->provision_init();
        ?>
        <!-- <h3>INV NO-3912</h3> -->
        <div class="order-details-table order-price-info">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                            $total_price = 0; 
                            if( isset($_SESSION['packages']) ) :
                                foreach( $_SESSION['packages'] as $package ) : 
                                // Price With Tax
                                $price_with_tax = $provisioning->price()->getAmountWithTax($package['tiered_id'], $_SESSION['user_data']['country']);
                                $total_price += $price_with_tax['responseData']['total_amount']; 
                        ?>
                            <tr>
                                <td data-title="Name:"><?php echo $package['name']; ?></td>
                                <td data-title="Price:"><?php echo number_format($price_with_tax['responseData']['total_amount'], 2); ?>/<small><?php echo $package['duration']; ?></small></td>
                                <td data-title="Quantity:">1</td>
                                <td data-title="Total:">$<?php echo number_format($price_with_tax['responseData']['total_amount'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: $total_price = number_format(floatval($_SESSION['default_package']['tiered_pricing'][0]['amount']), 2);?>
                            <tr>
                                <td data-title="Name:"><?php echo $_SESSION['default_package']['name']; ?></td>
                                <td data-title="Price:"><?php echo number_format(floatval($_SESSION['default_package']['tiered_pricing'][0]['amount']), 2); ?>/<small><?php echo $_SESSION['default_package']['tiered_pricing'][0]['duration']; ?></small></td>
                                <td data-title="Quantity:">1</td>
                                <td data-title="Total:">$<?php echo number_format(floatval($_SESSION['default_package']['tiered_pricing'][0]['amount']), 2); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody></table>
                                <p>Subtotal <?php if( !empty($price_with_tax['responseData']['tax_details']['amount']) ) : ?>(inc GST <?php echo $price_with_tax['responseData']['tax_details']['amount']; ?>%)<?php endif; ?>:<span>$<?php echo number_format($total_price, 2); ?></span></p>
                    <p>Paid Amount:<span>$<?php echo number_format($total_price, 2); ?></span></p>
            </div>
        </div>
        <?php
    }
    
    /**
    * Invoice Template Info
    * @author Rabiul
    * @since 1.0.0
    */
    public function invoice_template_info() {
        // Init Provision
        $provisioning = $this->provision_init();
        if( isset( $_SESSION['template']['id'] ) ) {
            $template = $provisioning->template()->details($_SESSION['template']['id']);
            if( $template['isSuccess'] ) :
            ?>
            <div class="order-details-table template_information_wrap">
                <h4>Template Information</h4>
                <div class="table-responsive template_information">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Demo Link</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <img src="<?php echo esc_url( $template['responseData']['imageURL'] ); ?>" title="Restaurant" alt="<?php echo esc_attr($template['responseData']['name']); ?>" height="80">
                            </td>
                            <td data-title="Type:"><?php echo $_SESSION['user_data']['store_type']; ?></td>
                            <td data-title="Category:"><?php echo $template['responseData']['type']; ?></td>
                            <td data-title="Name:"><?php echo $template['responseData']['name']; ?></td>
                            <td data-title="Demo Link:">
                                <a target="_blank" href="<?php echo esc_url( $template['responseData']['liveURL'] ); ?>" style="text-decoration:none;">View Demo</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            endif;
        }
        
    }

    /**
    * Adding Login Url
    * @author Rabiul
    * @since 1.0.0
    */
    public function login_url_link() {
        ?>
        <div class="row">
            <div class="col-md-12 text-center js-success-url">
                <a href="#" class="button-style-2-indp js-wcc-success-login startforfree-btn">Please Login</a>
            </div>
        </div>
        <?php
    }

    /**
    * Set Selected Template ID
    * @author Rabiul
    * @since 1.0.0
    */
    public function set_template_id() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if(isset($_POST['template_id'])) {
            $_SESSION['template'] = array(
                'id'         => $_POST['template_id'],
                'tiered_id'  => isset( $_POST['tiered_id'] ) ? $_POST['tiered_id']: '',
                'tax_amount' => $_POST['tax_amount']
            );
        }else {
            return;
        }

        echo wp_json_encode($_SESSION['template']);
        wp_die();
    }

    /**
    * Check For Already Exsits User Email
    * @author Rabiul
    * @since 1.0.0
    */
    public function check_email_address() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );
        if(isset( $_POST['typed_email'] )) {
            // Init Provision
            $provisioning = $this->provision_init();
            $typed_email  = $_POST['typed_email'];
            $check_email  = $provisioning->account()->isEmailExists($typed_email);
            if( $check_email['responsData']['isEmailExists'] == true ) {
                $_SESSION['already_registered'] = true;
            }else {
                $_SESSION['already_registered'] = false;
            }
            
            $result = [
                'response' => $check_email,
                'email'    => $typed_email,
                'storeName' => $_POST['store_name'],
                'websiteType' => $_POST['website_type'],
                'country' => $_POST['country_name']
            ];
        }else {
            $result = [
                'response' => false,
                'email'    => false
            ];
        }

        echo wp_json_encode($result);
        wp_die();
    }

    /**
    * Payment Process Summary
    * @author Rabiul
    * @since 1.0.0
    */
    public function payment_process_summary() {
        // Init Provision
        $provisioning = $this->provision_init();
        ?>
        <div class="payment-summary">
            <h5 class="finalise-title">Summary (AUD)</h5>
            <?php $total_price = 0;
            if( isset($_SESSION['packages']) ) :
                foreach( $_SESSION['packages'] as $package ) : 
                    $duration = '/'.$package['duration'];
                    if (strtoupper($package['duration']) == 'MONTHLY'){
                        $duration = 'mo';
                    }
                    else if (strtoupper($package['duration']) == 'YEARLY'){
                        $duration = 'yr';
                    }
                    elseif (strtoupper($package['duration']) == 'LIFE_TIME'){
                        $duration = 'One-off';
                    }
                    // Price With Tax
                    $price_with_tax = $provisioning->price()->getAmountWithTax($package['tiered_id'], $_SESSION['user_data']['country']);
                    
                    // echo '<pre>';print_r($price_with_tax); echo '</pre>';
                    $total_price += $price_with_tax['responseData']['total_amount']; ?>
                    <p class="summary-info"><?php echo $package['name']; ?> <span class="main">$<?php echo number_format($price_with_tax['responseData']['total_amount'], 2); ?> /<small><?php echo $duration ?></small></span></p>
                <?php endforeach; ?>  
            <?php else : ?>
                <h4>No Package Available</h4>
            <?php endif; ?>
            <!-- Grand Total -->
            <p class="grand-total">
                Grand Total : <span class="main">$<?php echo number_format( $total_price, 2 ); ?> <?php if( isset($_SESSION['packages']) ) : ?>
                <?php if( !empty($price_with_tax['responseData']['tax_details']['amount']) ) : ?>
                <span class="under">(inc GST <?php echo $price_with_tax['responseData']['tax_details']['amount']; ?>%)</span><?php endif; ?></span>
                <?php endif; ?>
            </p>
            <!-- Coupon -->
            <div class="have-cuppon">
                <label>Have a coupon?</label>
                <div class="input-box">
                    <input type="text">
                    <button>Apply</button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
    * Save User Data After Login
    * @author Rabiul
    * @since 1.0.0
    */
    public function save_user_data_after_login() {
        \check_ajax_referer( WCC_NONCE, 'nonce' );

        if(isset($_POST['fields'])) {
            parse_str($_POST['fields'], $fields);
            if( empty($fields['store_name']) || empty($fields['country_name']) ) {
                echo wp_json_encode('required');
            }else {

                $website_type = $_POST['website_type'];

                if( 'true' == $website_type ) {
                    $store_type = 'E-COMMERCE';
                }else {
                    $store_type = 'CONTENT';
                }

                $update_user_data['store_name'] = $fields['store_name']; 
                $update_user_data['store_type'] = $store_type; 
                $update_user_data['country']    = $fields['country_name']; 

                $user_data = $_SESSION['user_data'];

                $new_user_data = array_replace( $user_data, $update_user_data );

                $_SESSION['user_data'] = $new_user_data;
                echo wp_json_encode('success');
            }
        }else {
            echo wp_json_encode('failed');
        }
        wp_die();
    }
}
