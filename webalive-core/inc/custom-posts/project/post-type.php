<?php 
/**
 * ========================================================
 * - Post Type: Project
 * - Slug: project
 * ========================================================
 */

 class Webalive_Projects {

    /**
     * Construct Function
     */
    public function __construct() {
        add_filter( 'enter_title_here', array( $this, 'change_titlez_placeholder_text' ));
		add_action( 'init', array( $this, 'project_post_type' ));
		add_action( 'init', array( $this, 'project_taxonomy' ) );
    }

    /**
     * Chagne Default Post TItle Placeholder Text
     */
    public function change_titlez_placeholder_text($title) {
        $screen = get_current_screen();
        $title = "Add {$screen->post_type} title";
        return $title;
    }

    /**
     * Projct Post Type
     */
    public function project_post_type() {
        $labels = array(
			'name'               => _x( 'Project', 'post type general name', 'webalive2019-core' ),
			'singular_name'      => _x( 'Project', 'post type singular name', 'webalive2019-core' ),
			'menu_name'          => _x( 'Project', 'admin menu', 'webalive2019-core' ),
			'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'webalive2019-core' ),
			'add_new'            => _x( 'Add New', 'Project', 'webalive2019-core' ),
			'add_new_item'       => __( 'Add New Project', 'webalive2019-core' ),
			'new_item'           => __( 'New Project', 'webalive2019-core' ),
			'edit_item'          => __( 'Edit Project', 'webalive2019-core' ),
			'view_item'          => __( 'View Project', 'webalive2019-core' ),
			'all_items'          => __( 'All Project', 'webalive2019-core' ),
			'search_items'       => __( 'Search Project', 'webalive2019-core' ),
			'parent_item_colon'  => __( 'Parent Project:', 'webalive2019-core' ),
			'not_found'          => __( 'No Project found.', 'webalive2019-core' ),
			'not_found_in_trash' => __( 'No Project found in Trash.', 'webalive2019-core' ),
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'webalive2019-core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'project' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => true,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'       => true,
		);
		register_post_type( 'project', $args );
	}
	
	/**
     * Create Project Taxonomy
     */
    public function project_taxonomy() {
        $labels = array(
            'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
            'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
            'menu_name'         => __( 'Categories', 'textdomain' ),
            'search_items'      => __( 'Search Categories', 'textdomain' ),
            'all_items'         => __( 'All Categories', 'textdomain' ),
            'parent_item'       => __( 'Parent Category', 'textdomain' ),
            'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
            'edit_item'         => __( 'Edit Category', 'textdomain' ),
            'update_item'       => __( 'Update Category', 'textdomain' ),
            'add_new_item'      => __( 'Add New Category', 'textdomain' ),
            'new_item_name'     => __( 'New Category Name', 'textdomain' ),
        );
    
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'projectcats' ),
            'show_in_rest'      => true,
        );
    
        register_taxonomy( 'projectcats', 'project', $args );
    }

 }
 new Webalive_Projects();
