<?php 
/**
 * ========================================================
 * # Project metaboxes
 * ========================================================
 */

 class Webalive_Project_Metaboxes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_action( 'add_meta_boxes',   array( $this, 'add_metabox' ) );
        add_action( 'save_post',        array( $this, 'save_metabox_value' ) );
    }

    /**
     * Add Metabox
     */
    public function add_metabox() {
        $screens = array( 'project' );
        foreach( $screens as $screen ) {
            add_meta_box(
                'webalive_project_metabox_id',
                'Project Settings',
                array( $this, 'metabox_template' ),
                $screen,
                'side'
            );
        }
    }
    /**
     * Metabox Template
     */
    public function metabox_template($post) {
        $featured   = get_post_meta( $post->ID, '_wa_is_project_featured', true );
        $technology = get_post_meta( $post->ID, '_wa_project_tech', true );
        $industry   = get_post_meta( $post->ID, '_wa_is_project_industry', true );
        ?>
        <div class="metabox-side-context">
            <p><strong>Featured: </strong></p>
            <select name="wa_is_project_featured" class="form-control">
                <option value="no" <?php selected( 'no', $featured ) ?>>No</option>
                <option value="yes" <?php selected( 'yes', $featured ) ?>>Yes</option>
            </select>
        </div>
        <div class="metabox-side-context">
            <p><strong>Technology: </strong></p>
            <input type="text" name="wa_project_tech" class="regular-text" value="<?php if( isset($technology) ) : echo $technology; else: ''; endif; ?>">
        </div>
        <div class="metabox-side-context">
            <p><strong>Industry: </strong></p>
            <input type="text" name="wa_project_industry" class="regular-text" value="<?php if( isset($industry) ) : echo $industry; else: ''; endif; ?>">
        </div>
        <?php
    }
    /**
     * Save Metabox Value
     */
    public function save_metabox_value($post_id) {
        if(isset($_POST['wa_is_project_featured'])) { 
            update_post_meta( $post_id, '_wa_is_project_industry',  $_POST['wa_project_industry'] );
        }
        if(isset($_POST['wa_project_tech'])) {
            update_post_meta( $post_id, '_wa_project_tech',         $_POST['wa_project_tech'] );
        }
        if(isset($_POST['wa_is_project_featured'])) {
            update_post_meta( $post_id, '_wa_is_project_featured',  $_POST['wa_is_project_featured'] );
        }
    }

 }
 new Webalive_Project_Metaboxes();