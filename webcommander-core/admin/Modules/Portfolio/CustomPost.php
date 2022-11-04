<?php 
namespace WCC\Admin\Modules\Portfolio;

class CustomPost {
    /**
     * Constuct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', array($this, 'create_post_type') );
        add_action( 'enter_title_here', array($this, 'update_title_placeholder') );
    }

    /**
     * Create Custom Post
     * @author Rabiul
     * @since 1.0.0
     */
    public function create_post_type() {
        $labels = array(
			'name'               => _x( 'Portfolio', 'post type general name', 'webcommander-core' ),
			'singular_name'      => _x( 'Portfolio', 'post type singular name', 'webcommander-core' ),
			'menu_name'          => _x( 'Portfolio', 'admin menu', 'webcommander-core' ),
			'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'webcommander-core' ),
			'add_new'            => _x( 'Add New', 'Portfolio', 'webcommander-core' ),
			'add_new_item'       => __( 'Add New Portfolio', 'webcommander-core' ),
			'new_item'           => __( 'New Portfolio', 'webcommander-core' ),
			'edit_item'          => __( 'Edit Portfolio', 'webcommander-core' ),
			'view_item'          => __( 'View Portfolio', 'webcommander-core' ),
			'all_items'          => __( 'All Portfolio', 'webcommander-core' ),
			'search_items'       => __( 'Search Portfolio', 'webcommander-core' ),
			'parent_item_colon'  => __( 'Parent Portfolio:', 'webcommander-core' ),
			'not_found'          => __( 'No Portfolio found.', 'webcommander-core' ),
			'not_found_in_trash' => __( 'No Portfolio found in Trash.', 'webcommander-core' ),
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'webcommander-core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolios' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'       => true,
		);
		register_post_type( 'portfolio', $args );
    }

    /**
     * Change Portfolio Title
     * @author Rabiul
     * @since 1.0.0
     */
    public function update_title_placeholder($title) {
        $screen = get_current_screen();
        if( 'portfolio' === $screen->post_type ) {
            $title = 'Add portfolio title';
        }
        return $title;
    }
}