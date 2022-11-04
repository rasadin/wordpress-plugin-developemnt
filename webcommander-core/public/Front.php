<?php 
namespace WCC\Front;

use WCC\Front\Modules\Elementor;
use WCC\Front\Modules\Portfolio;
use WCC\Front\Modules\ChoosePackage;

class Front {
    /**
     * Construct Function
     * 
     * @since 1.0.0
     */
    public function __construct() {

        /**
         * Init Modules
         */
        $elementor_widgets  = new Elementor();
        $choose_package     = new ChoosePackage();
        $portfolio          = new Portfolio();

        /**
         * Loading Necessary Hooks
         */
        add_action( 'wp_enqueue_scripts', array($this, 'front_styles_scripts') );
    }

    /**
     * Requireing Necessary Styles & Scripts
     * 
     * @since 1.0.0
     */
    public function front_styles_scripts() {
        // Styles
        wp_enqueue_style( 'wcc-public', WCC_PLUGIN_RESOURCE_URL . '/public/dist/css/public.min.css', array(), rand() );

        // Scripts
        wp_enqueue_script( 'jquery-validator', WCC_PLUGIN_RESOURCE_URL . '/public/dist/js/jquery.validate.min.js', array('jquery',), rand(), true );
        wp_enqueue_script( 'additional-methods', WCC_PLUGIN_RESOURCE_URL . '/public/dist/js/additional-methods.min.js', array('jquery', 'jquery-validate'), rand(), true );
        wp_enqueue_script( 'wcc-public', WCC_PLUGIN_RESOURCE_URL . '/public/dist/js/public.min.js', array('jquery', 'jquery-validator', 'wp-util'), rand(), true );
    
        // Localizer
        $options = array(
            'homeUrl'           => home_url('/'),
            'adminUrl'          => admin_url('/'),
            'ajaxUrl'           => admin_url('/admin-ajax.php'),
            'nonce' 	        => wp_create_nonce('*9^8Nm4O8Aj)@Z[~hF=2b;{jecbo5/]2qWo^c-/Xm~=-0DuRt*}U<CV2>+e/q!e8'),
            'posts_per_page' 	=> get_option( 'posts_per_page' ),
            'wccSettings'       => get_option( '_wcc_settings' ),
            'signupType'        => isset( $_SESSION[ 'signup_type' ] ) ? $_SESSION[ 'signup_type' ] : false,
            'template'          => isset( $_SESSION[ 'template' ] ) ? $_SESSION[ 'template' ] : ''
        );
        wp_localize_script( 'wcc-public', 'publicLocalizer', $options );
    }
}