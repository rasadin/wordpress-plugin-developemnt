<?php 
namespace WCC\Admin\Modules\Portfolio;

class Template {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_filter( 'template_include', array($this, 'create_archive_template') );
        // add_filter( 'single_template', array($this, 'create_single_page_template') );
    }

    /**
     * Create Archive Template
     * 
     * @since 1.0.0
     */
    public function create_archive_template( $template ) {
        if( is_post_type_archive( 'portfolio' ) ) {
            $files = array( 'archive-portfolio.php', 'webcommander-core/portfolio/archive-portfolio.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . 'templates/portfolio/archive-portfolio.php';
            }
        }
        return $template;
    }
    /**
     * Create Single Page Template
     * 
     * @since 1.0.0
     */
    public function create_single_page_template( $template ) {
        global $post;
        if( 'actor' === $post->post_type ) {
            $files = array( 'single-portfolio.php', 'wp-moviepress/portfolio/single-porfolio.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . 'templates/portfolio/single-portfolio.php';
            }
        }
        return $template;
    }
}