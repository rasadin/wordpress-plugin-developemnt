<?php 
/**
 * @link            http://wp-plugin-boilerplate.com
 * @since           1.0.0
 * @package         WP_Plugin_Boilerplate
 * 
 * Plugin Name:     Web Commander Core
 * Plugin URI:      https://webalive.com.au/plugins/webcommander-core
 * Description:     A core plugin for web commander
 * Version:         1.0.0 
 * Author:          Webalive Team
 * Author URI:      https://webalive.com.au/
 * License:         GPLv3 or later
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:     webcommander-core
 */
if( !defined( 'ABSPATH' ) ) exit();

/**
 * Fixing the Header Already sent Issue
*/
if( ob_get_length() > 0 ) : ob_clean(); endif; ob_start();

/**
 * Enabling Session
 */
if (!session_id()) : session_start(); endif;
/**
 * Init Package Vars
 */
$_SESSION['free_package'] = false;
$_SESSION['paid_package'] = false;

/**
 * Require Autoloader
 */
require_once 'vendor/autoload.php';
/**
 * Require Helper Functions
 */
require_once 'helpers/helpers.php';

use WCC\Admin\Admin;
use WCC\Front\Front;
use WCC\Blocks\Blocks;

/**
 * Define Plugin Constants
 * 
 * @since 1.0.0
 */
define( 'WCC_VERISON', '1.0.0' );
define( 'WCC_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'WCC_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)) );
define( 'WCC_PLUGIN_RESOURCE_URL', WCC_PLUGIN_URL . 'resources' );
define( 'WCC_NONCE', '*9^8Nm4O8Aj)@Z[~hF=2b;{jecbo5/]2qWo^c-/Xm~=-0DuRt*}U<CV2>+e/q!e8' );

class WebCommander_Core {

    /**
     * Construct Function
     */
    public function __construct() {
        $admin                  = new Admin();
        $front                  = new Front();
    }

}
new WebCommander_Core();


function create_provision_table() {
    global $wpdb;
    $table_name = $wpdb->prefix.'provision';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            client_id varchar(100) NOT NULL,
            client_secret varchar(100) NOT NULL,
            access_token varchar(100) NOT NULL,
            refresh_token varchar(100) NOT NULL,
            code varchar(100) NOT NULL,
            url varchar(100) NOT NULL,
            PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function insert_initial_provision_data() {
    global $wpdb;
    $table = $wpdb->prefix.'provision';
    $data = array(
        'client_id' => '7b094dfc84e841c2844be6cf79d09221',
        'client_secret' => '16910ae7cd624b629109e7dc55457495',
        'access_token' => 'c94e4ff66bed4d79ad458f1c5ea7c725',
        'refresh_token' => 'fcd3444c91384c5ea0d1d929df2e43da',
        'code' => '05f8dba1d01f44d9aacacb46213d0d8e',
        'url' => 'http://bm-npps.webcommander.biz/',
    );
    $format = array('%s', '%s', '%s', '%s', '%s', '%s');
    $wpdb->insert($table,$data,$format);
}

register_activation_hook( __FILE__, 'create_provision_table' );
register_activation_hook( __FILE__, 'insert_initial_provision_data' );

