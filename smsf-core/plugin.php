<?php 
/**
 * @link            https://www.webalive.com.au/
 * @since           1.0.0
 * @package         Smsf Core
 * 
 * Plugin Name:     Smsf Core
 * Plugin URI:      https://www.webalive.com.au/
 * Description:     Core plguin for the WebAlive2019
 * Version:         1.0.0 
 * Author:          WebAlive
 * Author URI:      https://www.webalive.com.au/webalive
 * License:         Webalive 
 * License URI:     https://www.webalive.com.au/product-license
 * Text Domain:     smsf-core
 */

if( !defined( 'ABSPATH' ) ) exit();

define( 'WAE_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'WAE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once WAE_PLUGIN_PATH .'/inc/elementor-helpers/helper.php';
require_once WAE_PLUGIN_PATH .'/inc/elementor-helpers/activator.php';

/**
 * Init Styles and Scripts
 */
add_action( 'wp_enqueue_scripts', 'batside_elementor_core_scripts_styles' );
function batside_elementor_core_scripts_styles() {
    wp_enqueue_style('smsf-owl-carousel', plugins_url('/assets/css/owl.carousel.min.css', __FILE__), '', rand());
    wp_enqueue_style('smsf-owl-theme', plugins_url('/assets/css/owl.theme.default.min.css', __FILE__), '', rand());
    wp_enqueue_style('smsf-public', plugins_url('/assets/css/public.css', __FILE__), '', rand());

    wp_enqueue_script('smsf-owl-carousel', plugins_url('/assets/js/owl.carousel.min.js', __FILE__), array('jquery'), rand(), true);
    wp_enqueue_script('smsf-public', plugins_url('/assets/js/public.js', __FILE__), array('jquery'), rand(), true);
    
    $options = array(
        'admin_url'         => admin_url(''),
        'ajax_url'          => admin_url('admin-ajax.php'),
        'ajax_nonce'        => wp_create_nonce('ah3jhlk(765%^&ksk!@45'),
    );
    wp_localize_script('smsf-public', 'public_localizer', $options);
}