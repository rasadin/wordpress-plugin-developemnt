<?php 
namespace WCC\Admin\Modules;

use WCC\Admin\Modules\Portfolio\Template;
use WCC\Admin\Modules\Portfolio\Metaboxes;
use WCC\Admin\Modules\Portfolio\Shortcode;
use WCC\Admin\Modules\Portfolio\CustomPost;

class Portfolio {
    /**
     * Construct Class
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        $custom_post = new CustomPost();
        $shortcode = new Shortcode();
        $template = new Template();
        $metaboxes = new Metaboxes();
    }
}