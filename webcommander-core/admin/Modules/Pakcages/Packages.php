<?php 
namespace WCC\Admin\Modules;

use WCC\Admin\Modules\Pakcages\CustomPost;

class Packages {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        $custom_post = new CustomPost();
    }
}