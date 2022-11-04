<?php 
namespace WCC\Admin\Modules;

class Settings {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'create_menu'));
        add_action( 'wp_ajax_general_tab_settings', array( $this, 'general_tab_settings' ) );
    }

    /**
    * Admin Menu
    * @author Rabiul
    * @since 1.0.0
    */
    public function create_menu() {
        add_menu_page(
            __('Web Commander', 'webcommander-core'),
            'Web Commander',
            'manage_options',
            'webcommander',
            [$this, 'template'], // Callback function
            '',
            100
        );
    }

    /**
    * Settings Template
    * @author Rabiul
    * @since 1.0.0
    */
    public function template() {
        $wcc_pages = wcc_pages();
        $wcc_settings = get_option('_wcc_settings');
        ?>
        <div class="wcc-wrapper">
            <div class="wcc-header">
                <h2><span class="dashicons dashicons-admin-settings"></span> Settings</h2>
            </div>

            <div class="wcc-row">
            <div class="wcc-settings-tabs">
                <ul class="wcc-tabs">
                    <li><a href="#general" class="active"><span class="fas fa-home"></span> <span>General</span></a></li>
                    <li><a href="#others" class=""><span class="fas fa-home"></span> <span>Others</span></a></li>
                    
                </ul>
                <!-- General Settings -->
                <div id="general" class="wcc-settings-tab active">
                    <div class="wcc-card">
                        <form id="general-form-settings">
                            <!-- Template Library Page -->
                            <div class="field-group">
                                <label for="template-library">Template Library Page</label>
                                <select name="wcc_template_library_page" class="wcc_select">
                                    <option value="">Select One</option>
                                    <?php foreach( $wcc_pages as $page ) : ?>
                                    <option value="<?php echo $page->post_name; ?>" <?php selected( $page->post_name, isset( $wcc_settings['template-library-slug'] ) ? $wcc_settings['template-library-slug'] : '' ); ?>><?php echo $page->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Additional Packages Page -->
                            <div class="field-group">
                                <label for="template-library">Additional Pakcages Page</label>
                                <select name="wcc_additional_packages_page" class="wcc_select">
                                    <option value="">Select One</option>
                                    <?php foreach( $wcc_pages as $page ) : ?>
                                    <option value="<?php echo $page->post_name; ?>" <?php selected( $page->post_name, isset( $wcc_settings['additional-packages-slug'] ) ? $wcc_settings['additional-packages-slug'] : '' ); ?>><?php echo $page->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Payment Process Page -->
                            <div class="field-group">
                                <label for="template-library">Payment Process Page</label>
                                <select name="wcc_payment_process_page" class="wcc_select">
                                    <option value="">Select One</option>
                                    <?php foreach( $wcc_pages as $page ) : ?>
                                    <option value="<?php echo $page->post_name; ?>" <?php selected( $page->post_name, isset( $wcc_settings['payment-process-slug'] ) ? $wcc_settings['payment-process-slug'] : '' ); ?>><?php echo $page->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Payment Success Page -->
                            <div class="field-group">
                                <label for="template-library">Payment Success Page</label>
                                <select name="wcc_payment_success_page" class="wcc_select">
                                    <option value="">Select One</option>
                                    <?php foreach( $wcc_pages as $page ) : ?>
                                    <option value="<?php echo $page->post_name; ?>" <?php selected( $page->post_name, isset( $wcc_settings['payment-success-slug'] ) ? $wcc_settings['payment-success-slug'] : '' ); ?>><?php echo $page->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="submit" class="button button-primary button-wcc" value="Save Changes">
                        </form>
                    </div>
                </div>
                <!-- Others Settings -->
                <div id="others" class="wcc-settings-tab">
                    <div class="wcc-card">
                        <form id="other_form_settings">

                            <input type="submit" class="button button-primary button-wcc" value="Save Changes">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
    * Save General Settings Data
    * @author Rabiul
    * @since 1.0.0
    */
    public function general_tab_settings() {

        \check_ajax_referer( WCC_NONCE, 'nonce' );

        if( isset($_POST['fields']) ) {
            parse_str( $_POST['fields'], $fields );

            $wcc_settings = array(
                'template-library-slug'     => $fields['wcc_template_library_page'],
                'additional-packages-slug'  => $fields['wcc_additional_packages_page'],
                'payment-process-slug'      => $fields['wcc_payment_process_page'],
                'payment-success-slug'      => $fields['wcc_payment_success_page'],
            );

            update_option( '_wcc_settings', $wcc_settings );
        }else {
            return;
        }

        echo wp_json_encode('saved');
        wp_die();
    }
}