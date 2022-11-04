<?php 
namespace WCC\Admin\Modules\Portfolio;

class Shortcode {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_shortcode( 'wcc_portfolios', array($this, 'portfolio_grid') );
    }

    /**
     * Create Portfolio Grid
     * @author Rabiul
     * @since 1.0.0
     * @usecase [wcc_portfolios items=6]
     */
    public function portfolio_grid($atts, $content=null) {
        $options = extract(shortcode_atts(array(
            'items' => get_option('posts_per_page')
        ), $atts));

        $args = array(
            'post_type'         => 'portfolio',
            'post_status'       => 'publish',
            'posts_per_page'    => $items,
        );

        $query = new \WP_Query($args); wp_reset_query();
        $html = '<div class="row">';
        if( !empty($query->posts) ) {
            foreach($query->posts as $post) {
                $popup_element = 'portfolio-popup-'.$post->ID;
                $site_label = get_post_meta( $post->ID, '_site_label', true );
                $site_url = get_post_meta( $post->ID, '_site_url', true );
                $singup_url = get_post_meta( $post->ID, '_signup_url', true );
                $html .= '
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="portfolio-item">
                        <div class="portfolio-img">
                            '.get_the_post_thumbnail( $post->ID, 'full' ).'
                            <div class="p-hover">
                                <a href="#" onclick="portfolioPopUp(event, '.$post->ID.')">Preview</a>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <h4>'.get_the_title($post->ID).'</h4>
                            <p>'.get_the_excerpt($post->ID).'</p>
                        </div>
                    </div>
                </div>';

                $html .= '
                <div class="portfolio-popup" id="portfolio-popup-'.$post->ID.'">
                    <div class="button-close">
                        <a href="#" class="btn btn-default" onclick="closePopup(event, '.$post->ID.')">Close</a>   
                    </div>
                    <div class="popup-topbar">                        
                        <div class="wrap-content">
                            <div class="left-part">
                                <h2>'.get_the_title($post->ID).'</h2>
                                <p>Visit Site: <a href="'.esc_attr($site_url).'" target="_blank">'.$site_label.'</a></p>
                            </div>
                            <div class="right-part">
                            <a href="https://www.webcommander.com.au/contact-us/" class="button-style-2-indp">Contact Us</a> 
                            </div>
                        </div>
                    </div>
                    <div class="popup-preview">
                        '.get_the_post_thumbnail($post->ID).'
                    </div>
                </div>';
            }
        }

        $html .= '</div>';

        return $html;
    }
}