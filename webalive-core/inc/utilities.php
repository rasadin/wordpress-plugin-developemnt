<?php 
/**
 * Get Custom Taxonomy Terms
 */
function get_custom_taxonomy_terms($taxonomy) {
    global $post;
    $terms = get_terms( $taxonomy, array(
        'orderby'    => 'name',
        'hide_empty' => true
    ));
    $terms_list = [];
    foreach($terms as $term) {
        $terms_list[$term->slug] = $term->name; 
    }
    return $terms_list;
}

/**
 * Count Posts by Term
 */
function count_posts_by_taxonomy( $post_type, $taxonomy=null ) {
    global $wp_query;
    $tax = $wp_query->get_queried_object();
    if( !empty($tax) ) {
        if( !is_search() && !is_404() ) {
            if( $tax->slug == '' ) {
                return wp_count_posts( $post_type )->publish;
            }else {
                $args = array(
                    'post_type' => $post_type,
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field'    => 'slug',
                            'terms'    => $tax->slug,
                        ),
                    ),
                );
    
                $query = new \WP_Query($args);
    
                return count($query->posts);
            }
        }
    }
    
}

function count_posts_by_term($post_type, $taxonomy, $term_name) {

    $args = array(
        'post_type'         => $post_type,
        'posts_per_page'    => -1,
        'tax_query'         => array(
        'relation'          => 'AND',
            array(
                'taxonomy'  => $taxonomy,
                'field'     => 'slug',
                'terms'     => $term_name
            )
        )
    );

    $query = new WP_Query( $args);

    return (int)$query->post_count;

}

/**
 * Portfolio Sorting List ( Ajax Request )
 */
add_action('wp_ajax_portfolio', 'portfolio');
add_action('wp_ajax_nopriv_portfolio', 'portfolio');

function portfolio() {
    if( isset($_POST['term_name']) && $_POST['term_name'] !== 'all' ) {
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => $_POST['per_page'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'projectcats',
                    'field' => 'slug',
                    'terms' => $_POST['term_name']
                )
            )
        );
        $total_projects = count_posts_by_term('project', 'projectcats', $_POST['term_name']);
        // die($_POST['term_name']);
    }else {
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => $_POST['per_page'],
        );
        $total_projects = wp_count_posts('project')->publish;
    }
    

    $query = new WP_Query($args);
    $results = [];
    foreach($query->posts as $post) {
        $results[] = array(
            'title'         => get_the_title($post->ID),
            'excerpt'       => get_the_excerpt($post->ID),
            'image_url'     => get_the_post_thumbnail_url($post->ID),
            'permalink'     => get_the_permalink($post->ID),
            'terms'         => get_the_terms($post->ID, 'projectcats'),
            'technologies'  => get_post_meta($post->ID, '_wa_project_tech', true),
            'industry'      => get_post_meta($post->ID, '_wa_is_project_industry', true)
        );
    }

    $data = array(
        'projects' 	=> $results,
        'total_projects' => $total_projects
    );
    

    echo wp_json_encode($data);

    die();
}

/**
 * Loadmore Portfolio Sorting List ( Ajax Request )
 */
add_action('wp_ajax_loadmore_portfolio', 'loadmore_portfolio');
add_action('wp_ajax_nopriv_loadmore_portfolio', 'loadmore_portfolio');

function loadmore_portfolio() {
    if( $_POST['offset'] && $_POST['perPage'] ) {
        $offset 	= $_POST['offset'];
        $per_page 	= $_POST['perPage'];
    }

    if( isset($_POST['termName']) && $_POST['termName'] !== 'all' ) {
        $args = array(
            'post_type'         => 'project',
            'posts_per_page'    => $per_page,
            'offset'            => $offset,
            'tax_query'         => array(
                array(
                    'taxonomy'  => 'projectcats',
                    'field'     => 'slug',
                    'terms'     => $_POST['termName']
                )
            )
        );
        $total_projects = count_posts_by_term('project', 'projectcats', $_POST['termName']);
    }else {
        $args = array(
            'post_type'         => 'project',
            'posts_per_page'    => $per_page,
            'offset'            => $offset,
        );
        $total_projects = wp_count_posts('project')->publish;
    }
    

    $query = new WP_Query($args);
    $results = [];
    foreach($query->posts as $post) {
        $results[] = array(
            'title'         => get_the_title($post->ID),
            'excerpt'       => get_the_excerpt($post->ID),
            'image_url'     => get_the_post_thumbnail_url($post->ID),
            'permalink'     => get_the_permalink($post->ID),
            'terms'         => get_the_terms($post->ID, 'projectcats'),
            'technologies'  => get_post_meta($post->ID, '_wa_project_tech', true),
            'industry'      => get_post_meta($post->ID, '_wa_is_project_industry', true)
        );
    }

    $data = array(
        'projects' 	        => $results,
        'total_projects'    => intval($total_projects)
    );

    echo wp_json_encode($data);

    die();
}

/**
 * Webalive Post Sharer
 */
if( !function_exists( 'webalive_post_sharer' ) ) :
	function webalive_post_sharer() {
		global $post;
		?>
		<div class="webalive-post-sharer">
			<span class="share-title">SHARE</span>
			<ul class="post-sharer">
				<li>
					<a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
				</li>
				<li>
					<a class="share-btn" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
				</li>
				<li>
					<a class="share-btn" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=&summary=&source=" target="_blank"><i class="fab fa-linkedin-in"></i></a>
				</li>
			</ul>
		</div>	
		<?php
	}
endif;

