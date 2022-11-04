<?php  
namespace WCC\Admin\Modules\Portfolio;

class Metaboxes {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
        add_action( 'save_post', array( $this, 'save_metabox_value' ) );
    }

    /**
     * Add Metabox
     */
    public function add_metabox() {
        $screens = array( 'portfolio' );
        foreach( $screens as $screen ) {
            add_meta_box(
                'wcc-portfolio-metaboxes',
                'Portfolio Settings',
                array( $this, 'metabox_template' ),
                $screen
            );
        }
    }
    /**
     * Metabox Template
     */
    public function metabox_template($post) {
        $site_label = get_post_meta( $post->ID, '_site_label', true );
        $site_url   = get_post_meta( $post->ID, '_site_url', true );
        $signup_url = get_post_meta( $post->ID, '_signup_url', true );
        ?>
        <table style="width: 100%">
            <tr>
                <td style="width: 20%">Site Label:</td>
                <td>
                    <input type="text" name="site_label" value="<?php echo $this->get_field_value($site_label); ?>">
                </td>
            </tr>
            <tr>
                <td style="width: 20%">Site URL:</td>
                <td>
                    <input type="text" name="site_url" value="<?php echo $this->get_field_value($site_url); ?>">
                </td>
            </tr>
            <tr>
                <td style="width: 20%">Signup URL:</td>
                <td>
                    <input type="text" name="signup_url" value="<?php echo $this->get_field_value($signup_url); ?>">
                </td>
            </tr>
        </table>
        <?php
    }
    /**
     * Save Metabox Value
     */
    public function save_metabox_value($post_id) {
        if( isset($_POST['site_label']) ) {
            update_post_meta( $post_id, '_site_label', sanitize_text_field($_POST['site_label']) );
        }
        if( isset($_POST['site_url']) ) {
            update_post_meta( $post_id, '_site_url', sanitize_text_field($_POST['site_url']) );
        }
        if( isset($_POST['signup_url']) ) {
            update_post_meta( $post_id, '_signup_url', sanitize_text_field($_POST['signup_url']) );
        }
    }
    /**
     * Get Field Value
     */
    public function get_field_value($value) {
        if( isset($value) && !empty($value) ) {
            return $value;
        }else {
            return '';
        }
    }
}