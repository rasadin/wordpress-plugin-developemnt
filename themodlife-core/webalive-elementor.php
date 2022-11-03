<?php 
/**
 * @link            https://www.webalive.com.au/
 * @since           1.0.0
 * @package         TheModLife Core
 * 
 * Plugin Name:     TheModLife Core
 * Plugin URI:      https://www.webalive.com.au/
 * Description:     Core plguin for the modlife
 * Version:         1.0.0 
 * Author:          Webalive
 * Author URI:      https://www.webalive.com.au/
 * License:         Webalive 
 * License URI:     https://www.webalive.com.au/product-license
 * Text Domain:     modlife-core
 */

if( !defined( 'ABSPATH' ) ) exit();

define( 'WAE_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'WAE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once WAE_PLUGIN_PATH .'/inc/elementor-helpers/helper.php';
require_once WAE_PLUGIN_PATH .'/inc/elementor-helpers/activator.php';
require_once WAE_PLUGIN_PATH .'/mailchimp/popup.php';

/**
 * Init Styles and Scripts
 */
add_action( 'wp_enqueue_scripts', 'webalive_elementor_core_scripts_styles' );
function webalive_elementor_core_scripts_styles() {
    wp_enqueue_script('webalive-public-script', plugins_url('/assets/js/public.js', __FILE__), array('jquery', 'jquery-swiper'), '20190101', true);

}

/**
 * Settings mailchimp Cookies
 */
add_action( 'wp_ajax_set_cookies_for_mailchilp_popup', 'set_cookies_for_mailchilp_popup' );
add_action( 'wp_ajax_nopriv_set_cookies_for_mailchilp_popup', 'set_cookies_for_mailchilp_popup' );
function set_cookies_for_mailchilp_popup() {

    setcookie('tmlc_mailchimp_cookie', 'enabled');

    echo wp_json_encode($_COOKIE['tmlc_mailchimp_cookie']);
    die();
}

// setcookie('tmlctest__mailchimp_cookie', 'enabled');

