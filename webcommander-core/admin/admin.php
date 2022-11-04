<?php 
namespace WCC\Admin;

use WCC\Admin\Modules\Packages;
use WCC\Admin\Modules\Settings;
use WCC\Admin\Modules\Portfolio;
use WCC\Admin\Modules\Provision;
use WCC\Admin\Modules\Search;
use WCC\Admin\Modules\TrialSignup;

class Admin {
    /**
     * Construct Function
     * 
     * @since 1.0.0
     */
    public function __construct() {

        /**
         * Init Modules
         */
        $portfolio = new Portfolio();
        $packages = new Packages();
        $trial_signup = new TrialSignup();
        $provision = new Provision();
        $search = new Search();
        $settings = new Settings();

        /**
         * Loading Necessary Hooks
         */
        add_action( 'admin_enqueue_scripts', array($this, 'admin_styles_scripts') );
    }

    /**
     * Requireing Necessary Styles & Scripts
     * 
     * @since 1.0.0
     */
    public function admin_styles_scripts() {
        // Styles
        wp_enqueue_style( 'wcc-admin', WCC_PLUGIN_RESOURCE_URL . '/admin/dist/css/admin.min.css', array(), rand() );

        // Scripts
        wp_enqueue_script( 'wcc-admin', WCC_PLUGIN_RESOURCE_URL . '/admin/dist/js/admin.min.js', array('jquery'), rand(), true );
    
        // Localizer
        $options = array(
            'homeUrl'           => home_url('/'),
            'adminUrl'          => admin_url('/'),
            'ajaxUrl'           => admin_url('/admin-ajax.php'),
            'nonce' 	        => wp_create_nonce('*9^8Nm4O8Aj)@Z[~hF=2b;{jecbo5/]2qWo^c-/Xm~=-0DuRt*}U<CV2>+e/q!e8'),
            'posts_per_page' 	=> get_option( 'posts_per_page' ),
        );
        wp_localize_script( 'wcc-admin', 'adminLocalizer', $options );

    }
}