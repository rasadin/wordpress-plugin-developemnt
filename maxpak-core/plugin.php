<?php 
/**
 * @link            https://yourwebsitelink.com
 * @since           1.0.0
 * @package         Maxpak Core
 * 
 * Plugin Name:     Maxpak Core
 * Plugin URI:      https://yourwebsitelink.com
 * Description:     A standard Maxpak Core for elementor addons
 * Version:         1.0.0 
 * Author:          Webalive Team
 * Author URI:      https://authorswebsitelink.com
 * License:         Maxpak Core 
 * License URI:     https://www.license.com/product-license
 * Text Domain:     maxpak-core
 */

if( !defined( 'ABSPATH' ) ) exit();

define( 'MAXPAK_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'MAXPAK_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once MAXPAK_PLUGIN_PATH .'/inc/elementor-helpers/helper.php';
require_once MAXPAK_PLUGIN_PATH .'/inc/elementor-helpers/activator.php';
require_once MAXPAK_PLUGIN_PATH .'/inc/utilities.php';
require_once MAXPAK_PLUGIN_PATH .'/inc/shortcodes.php';

/**
 * Init Styles and Scripts
 */
add_action( 'wp_enqueue_scripts', 'maxpak_elementor_core_scripts_styles' );
function maxpak_elementor_core_scripts_styles() {
    wp_enqueue_style('maxpak-public', plugins_url('/assets/dist/css/public.min.css', __FILE__), '', rand());

    wp_enqueue_script('maxpak-owlcarousel', plugins_url('/assets/dist/js/owl.carousel.min.js', __FILE__), array('jquery'), rand(), true);
    wp_enqueue_script('maxpak-public', plugins_url('/assets/dist/js/public.min.js', __FILE__), array('jquery', 'wp-util'), rand(), true);
    
    $options = array(
        'admin_url'         => admin_url(''),
        'ajax_url'          => admin_url('admin-ajax.php'),
        'ajax_nonce'        => wp_create_nonce('ah3jhlk(765%^&ksk!@45'),
    );
    wp_localize_script('maxpak-public', 'public_localizer', $options);
}