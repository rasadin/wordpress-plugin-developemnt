<?php 
namespace WCC\Front\Modules;

class Elementor {
    /**
     * Construct Function
     */
    public function __construct() {
        require_once WCC_PLUGIN_PATH . '/public/Modules/Elementor/Helpers/Init.php';
        require_once WCC_PLUGIN_PATH . '/public/Modules/Elementor/Helpers/Activator.php';
    }
}