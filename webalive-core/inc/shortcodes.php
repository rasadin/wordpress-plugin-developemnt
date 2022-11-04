<?php 
/**
 * =========================================================
 * All Shortcodes
 * ---------------------------------------------------------
 * - Featured Projects
 * =========================================================
 */

 class Webalive2019_Shortcodes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_shortcode('projects-grid',      array($this, 'projects_grid'));
        add_shortcode('selected-portfolio', array($this, 'selected_portfolios'));
        add_shortcode('featured-portfolio', array($this, 'featured_portfolios'));
        add_shortcode('portfolio-list',     array($this, 'portfolio_list'));
        add_shortcode('post-thumb-grid',    array($this, 'post_thumbnail_grid'));
    }

    /**
     * Selected Portfolios
     * Shortcode: [selected-portfolio ids=""]
     */
    public function selected_portfolios( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'ids'   => ''
        ), $atts));

        $id_list = explode(',', $ids);

        $args = array(
            'post_type' => 'project',
            'post__in' => $id_list,
            'orderby' => 'post__in'
        );
        $query = new WP_Query($args);
        
        ?>
        <?php foreach( $query->posts as $project ) : ?>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="feature-project-item <?php echo esc_attr($class); ?>">
                <div class="featured-project-img">
                    <a href="<?php echo esc_url(get_the_permalink($project->ID)); ?>">
                        <img src="<?php echo get_the_post_thumbnail_url($project->ID, 'webalive-project-thumbnail') ?>" alt="<?php esc_attr($project->post_title) ?>" class="img-responsive">
                    </a>
                </div>
               <span class="cat-name"><?php echo strip_tags(get_the_term_list($project->ID, 'projectcats', '', ', ', '')); ?></span>
                <h4 class="project-title"><a href="<?php echo get_the_permalink($project->ID) ?>"><?php echo get_the_title($project->ID); ?></a></h4>
                <p class="project-excerpt"><?php echo get_the_excerpt($project->ID); ?></p>
            </div>
        </div>
        <?php endforeach; 
    }

    /**
     * Featured Portfolios
     * Shortcode: [featured-portfolio class="" terms="" per_page=""]
     */
    public function featured_portfolios( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'per_page' => 4,
            'terms' => $terms,
            'class' => 'default'
        ), $atts));

        $args = array(
            'post_type' => 'project',
            'posts_per_page' => $per_page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'projectcats',
                    'field' => 'slug',
                    'terms' => $terms
                )
            ),
            'meta_query' => array(
                array(
                    'key' => '_wa_is_project_featured',
                    'value' => 'yes'
                )
            ),

        );
        $query = new WP_Query($args);
        
        ?>
        <?php foreach( $query->posts as $project ) : ?>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="feature-project-item <?php echo esc_attr($class); ?>">
                <div class="featured-project-img">
                    <a href="<?php echo esc_url(get_the_permalink($project->ID)); ?>">
                        <img src="<?php echo get_the_post_thumbnail_url($project->ID, 'webalive-project-thumbnail') ?>" alt="<?php esc_attr($project->post_title) ?>" class="img-responsive">
                    </a>
                </div>
                <span class="cat-name"><?php echo strip_tags(get_the_term_list($project->ID, 'projectcats', '', ', ', '')); ?></span>
                <h4 class="project-title"><a href="<?php echo get_the_permalink($project->ID) ?>"><?php echo get_the_title($project->ID); ?></a></h4>
                <p class="project-excerpt"><?php echo get_the_excerpt($project->ID); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
        <?php
    }

    /**
     * Projects Grid
     * Shortcode: [projects-grid per_page=""]
     */
    public function projects_grid( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'per_page' => 2,
        ), $atts));

        $args = array(
            'post_type' => 'project',
            'posts_per_page' => $per_page,

        );
        $query = new WP_Query($args);
        ?>
        <?php foreach( $query->posts as $project ) : ?>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="feature-project-item <?php echo esc_attr($class); ?>">
                <div class="featured-project-img">
                    <a href="<?php echo esc_url(get_the_permalink($project->ID)); ?>">
                        <img src="<?php echo get_the_post_thumbnail_url($project->ID, 'webalive-project-thumbnail') ?>" alt="<?php esc_attr($project->post_title) ?>" class="img-responsive">
                    </a>
                </div>
                <?php echo strip_tags(get_the_term_list($project->ID, 'projectcats', '', ', ', '')); ?>
                <h4 class="project-title"><a href="<?php echo get_the_permalink($project->ID) ?>"><?php echo get_the_title($project->ID); ?></a></h4>
            </div>
        </div>
        <?php endforeach;
    }

    /**
     * Post Thumbnail Grid
     * Shortcode: [post-thumb-grid per_page=""]
     */
    public function post_thumbnail_grid( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'ids' => ''
        ), $atts));

        $id_list = explode(',', $ids);

        $args = array(
            'post_type' => 'post',
            'post__in' => $id_list,
            'post__not_in'  => get_option( 'sticky_posts' )

        );
        $query = new WP_Query($args);
        ?>
        <?php foreach( $query->posts as $post ) : ?>
            <div class="latest-blog-thumble">
                <div class="letest-blog-img">
                    <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                        <?php if(wp_is_mobile()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'webalive-related-post-thumbnail-mobile'); ?>" alt="<?php echo $post->post_title; ?>">
                        <?php else : ?>
                            <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo $post->post_title; ?>">
                        <?php endif; ?>
                    </a>   
                </div>
                <div class="latest-blog-content">
                    <a href="<?php echo get_the_permalink($post->ID);?>"><p><?php echo $post->post_title; ?></p></a>
                    <a href="<?php echo get_the_permalink($post->ID) ?>" class="readmore">Read article</a>
                </div>
            </div>
        <?php endforeach;
    }
 } 

 new Webalive2019_Shortcodes();
