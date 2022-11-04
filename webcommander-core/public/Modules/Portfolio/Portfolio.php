<?php 
namespace WCC\Front\Modules;

class Portfolio {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'wp_ajax_loadmore_portfolios', [$this, 'loadmore_portfolios'] );
        add_action( 'wp_ajax_nopriv_loadmore_portfolios', [$this, 'loadmore_portfolios'] );
    }
    
    /**
    * Load More Portfolios
    * @author Rabiul
    * @since 1.0.0
    */
    public function loadmore_portfolios() {
        \check_ajax_referer( WCC_NONCE, 'nonce' ); // csrf protection 
        if(isset($_POST['per_page']) && $_POST['offset'] ) {
            $args = array(
                'post_type' 		=> 'portfolio',
                'posts_per_page'	=> $_POST['per_page'],
                'offset'			=> $_POST['offset'],
                'post_status'		=> 'publish',
            );
    
            $wp_posts = wp_count_posts('portfolio');
            $total_posts = $wp_posts->publish;
        
            $query = new \WP_Query($args); \wp_reset_postdata();
            $results = [];
            foreach($query->posts as $post) {
                $results[] = array(
                    'id'			=> $post->ID,
                    'title'         => get_the_title($post->ID),
                    'permalink'     => get_the_permalink($post->ID),
                    'thumbanil_url' => get_the_post_thumbnail_url($post->ID),
                    'portfolio_site_label' => get_post_meta( $post->ID, '_site_label', true ),
                    'portfolio_site_url' => get_post_meta( $post->ID, '_site_url', true )
                );
            }
            
            $data = array(
                'portfolios' 	        => $results,
                'totalPortfolios'    	=> $total_posts,
            );
        }else {
            return $data = false;
        }    
        

		echo wp_json_encode($data);

		die();
        
    }
}