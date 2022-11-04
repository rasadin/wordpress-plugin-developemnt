<?php 
/**
 * ========================================================
 * - Post Type: Quote
 * - Slug: quote
 * ========================================================
 */

 class Webalive_Quotes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_filter( 'enter_title_here', array( $this, 'change_title_placeholder_text' ));
		add_action( 'init', array( $this, 'quote_post_type' ));
    }

    /**
     * Chagne Default Post TItle Placeholder Text
     */
    public function change_title_placeholder_text($title) {
        $screen = get_current_screen();
        $title = "Add {$screen->post_type} title";
        return $title;
    }

    /**
     * Projct Post Type
     */
    public function quote_post_type() {
        $labels = array(
			'name'               => _x( 'Quote', 'post type general name', 'webalive2019-core' ),
			'singular_name'      => _x( 'Quote', 'post type singular name', 'webalive2019-core' ),
			'menu_name'          => _x( 'Quote', 'admin menu', 'webalive2019-core' ),
			'name_admin_bar'     => _x( 'Quote', 'add new on admin bar', 'webalive2019-core' ),
			'add_new'            => _x( 'Add New', 'Quote', 'webalive2019-core' ),
			'add_new_item'       => __( 'Add New Quote', 'webalive2019-core' ),
			'new_item'           => __( 'New Quote', 'webalive2019-core' ),
			'edit_item'          => __( 'Edit Quote', 'webalive2019-core' ),
			'view_item'          => __( 'View Quote', 'webalive2019-core' ),
			'all_items'          => __( 'All Quote', 'webalive2019-core' ),
			'search_items'       => __( 'Search Quote', 'webalive2019-core' ),
			'parent_item_colon'  => __( 'Parent Quote:', 'webalive2019-core' ),
			'not_found'          => __( 'No Quote found.', 'webalive2019-core' ),
			'not_found_in_trash' => __( 'No Quote found in Trash.', 'webalive2019-core' ),
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'webalive2019-core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'quote' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'       => true,
		);
		register_post_type( 'quote', $args );
	}

 }
 new Webalive_Quotes();
