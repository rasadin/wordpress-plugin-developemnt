<?php  
/**
 * Plugin Name: Webalive Theme Helper
 * Plugin URI: http://webalive.com
 * Author: Webalive
 * Description: Webalive theme helper plugin
 * Text-Domain: wth
 * Version: 1.0.0
 */

if( !defined( 'ABSPATH' ) ) exit; // No direct access allowed

define( 'WTH_URL', plugins_url( '/', __FILE__ ) );
define( 'WTH_PATH', plugin_dir_path( __FILE__ ) );

require_once WTH_PATH.'inc/elementor/helper.php';
require_once WTH_PATH.'inc/elementor/elements.php';

/**
 * Include Essential Scripts
 */
// Public
function wth_public_scripts() {

    wp_enqueue_style( 'wth-bx-slider', WTH_URL . 'assets/vendor/bx-slider/jquery.bxslider.css' );
    wp_enqueue_style( 'wth-public', WTH_URL . 'assets/css/public.css' );

    wp_enqueue_script( 'wth-bx-slider', WTH_URL . 'assets/vendor/bx-slider/jquery.bxslider.min.js', array('jquery'), true );
    wp_enqueue_script( 'wth-public', WTH_URL . 'assets/js/public.js', array('jquery'), true );
}
add_action( 'wp_enqueue_scripts', 'wth_public_scripts' );
  
// Admin
function wth_admin_scripts() {
    wp_enqueue_style( 'wth-admin', WTH_URL . 'assets/css/admin.css' );
    wp_enqueue_script( 'wth-admin', WTH_URL . 'assets/js/admin.js', array('jquery'), true );
}
add_action( 'admin_enqueue_scripts', 'wth_admin_scripts' );