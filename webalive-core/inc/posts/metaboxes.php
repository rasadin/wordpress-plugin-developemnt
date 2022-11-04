<?php 
/**
 * ========================================================
 * # Post metaboxes
 * ========================================================
 */

 class Webalive_Post_Metaboxes {

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
        $screens = array( 'post' );
        foreach( $screens as $screen ) {
            add_meta_box(
                'webalive_post_metabox_id',
                'Post Settings',
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
        $use_guest_info         = get_post_meta( $post->ID, '_wa_user_guest_info', true );
        $guest_image_id         = get_post_meta( $post->ID, '_wa_guest_image_id', true );
        $guest_name             = get_post_meta( $post->ID, '_wa_guest_name', true );
        $guest_description      = get_post_meta( $post->ID, '_wa_guest_description', true );
        ?>

        <div class="metabox-side-context">
            <p><strong>Use Guset Information:</strong></p>
            <select name="wa_user_guest_info" class="components-textarea-control__input">
                <option value="no" <?php selected(  $use_guest_info, 'no' ); ?>>No</option>
                <option value="yes" <?php selected( $use_guest_info, 'yes' ); ?> >Yes</option>
            </select>
        </div>

        <div class="metabox-side-context">
            <p><strong>Guest Image: </strong></p>
            <div class="rir-upload-wrap">
                <img data-src="" src="<?php echo esc_url(wp_get_attachment_url( $guest_image_id )); ?>" width="250" />
                <div class="rir-upload-action">
                    <input type="hidden" name="wa_guest_image_id" value="<?php echo esc_attr($guest_image_id); ?>" />
                    <button type="submit" class="upload_image_button button button-primary">Add Image</button>
                    <button type="submit" class="remove_image_button button button-primary">Remove</button>
                </div>
            </div>
        </div>
        
        <div class="metabox-side-context">
            <p><strong>Guest Name:</strong></p>
            <input type="text" name="wa_guest_name" class="components-textarea-control__input" value="<?php if( isset($guest_name) ) : echo $guest_name; else: ''; endif; ?>">
        </div>

        <div class="metabox-side-context">
            <p><strong>Description:</strong></p>
            <textarea name="wa_guest_description" class="components-textarea-control__input" rows="6"><?php if( isset($guest_description) ) : echo $guest_description; else: ''; endif; ?></textarea>
        </div>


        <div class="metabox-side-context">
            <p><strong>Request PopUp Form:</strong></p>
            <select name="show_hide" id="show_hide">
                <option value="no"<?php selected( get_post_meta($post->ID,'show_hide',true ), 'no')?>>Not Selected</option>
                <option value="show"<?php selected( get_post_meta($post->ID,'show_hide',true ), 'show')?>>Show</option>
                <option value="hide"<?php selected( get_post_meta($post->ID,'show_hide',true), 'hide')?>>Hide</option>
            </select>       
        </div>

        <?php
    }
    /**
     * Save Metabox Value
     */
    public function save_metabox_value($post_id) {
        if(isset($_POST['wa_user_guest_info'])) {
            update_post_meta( $post_id, '_wa_user_guest_info',  $_POST['wa_user_guest_info'] );
        }
        if( isset($_POST['wa_guest_image_id']) ) {
            update_post_meta( $post_id, '_wa_guest_image_id',  $_POST['wa_guest_image_id'] );
        }
        if( isset($_POST['wa_guest_name']) ) {
            update_post_meta( $post_id, '_wa_guest_name',  $_POST['wa_guest_name'] );
        }
        if( isset($_POST['wa_guest_description']) ) {
            update_post_meta( $post_id, '_wa_guest_description',  $_POST['wa_guest_description'] );
        }
                
        if( isset($_POST['show_hide']) ) {
            update_post_meta($post_id, 'show_hide', sanitize_text_field( $_POST['show_hide'] ) );
        }


    }

 }
 new Webalive_Post_Metaboxes();