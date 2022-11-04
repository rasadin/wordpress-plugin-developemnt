<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Portfolio_Sort_List extends Widget_Base {

	public function get_name() {
		return 'webalive-portfolio-sort-list';
	}

	public function get_title() {
		return esc_html__( 'Portfolio List', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-th-list';
	}

    public function get_categories() {
		return [ 'webalive-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label'     => __( 'Content Settings', 'webalive2019-core' ),
				'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'per_page',
			[
				'label'     => __( 'Per Page', 'webalive2019-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => 4,
			]
		);

		$this->end_controls_section();
        

		/**
		 * Style Tab
		 */
		$this->style_tab();

    }

	private function style_tab() {}

	protected function render() {
        $webalive = $this->get_settings_for_display();
        $project_count = count_posts_by_taxonomy('project', 'projectcats');
		$this->add_render_attribute(
			'webalive_portfolio_list',
			[
                'id' => 'webalive-postfolio-list-'.$this->get_id(),
                'data-per-page' => $webalive['per_page']
			]
        );
        $args = array(
            'post_type'         => 'project',
            'posts_per_page'    => $webalive['per_page'],

        );
        $query = new \WP_Query($args);
        $terms = get_custom_taxonomy_terms('projectcats');
        $count = 1;
    ?>
        <!-- Add Markup Starts -->
        <div class="our-work-list-section" <?php echo $this->get_render_attribute_string('webalive_portfolio_list'); ?>>
            <ul class="work-filter">
                <li data-term="all" class="current">All</li>
                <?php foreach( $terms as $key=>$value ) : ?>
                <li data-term="<?php echo $key; ?>"><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="work-list-wrap">
                <?php foreach( $query->posts as $project ) : 
                    $technology = get_post_meta($project->ID, '_wa_project_tech', true);    
                    $industry   = get_post_meta($project->ID, '_wa_is_project_industry', true);  
                    $terms      = get_the_terms( $project->ID, 'projectcats' )
                ?>
                <div class="work-item js-work-item">
                    <?php if( $count % 2 != 0 ) : $order_top = 'order-1'; $order_bottom = 'order-2'; else: $order_top = 'order-2'; $order_bottom = 'order-1'; endif;?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 <?php echo $order_top; ?>">
                            <div class="work-item-description">
                                <div class="work-category">
                                    <?php foreach( (array)$terms as $term ) : ?>
                                    <span><?php echo $term->name; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="work-details-wrap">
                                    <div class="work-title">
                                        <h3><?php echo $project->post_title; ?></h3>
                                        <?php echo $project->post_excerpt; ?>
                                    </div>
                                    <?php if( !empty($technology) || !empty($industry)) : ?>
                                    <div class="work-data">
                                        <div class="row">
                                            <?php if(!empty($technology)) : ?>
                                                <div class="col-6 col-sm-6">
                                                    <h5>Technology</h5>
                                                    <p><?php echo $technology; ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($industry)) : ?>
                                            <div class="col-6 col-sm-6">
                                                <h5>Industry</h5>
                                                <p><?php echo $industry; ?></p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <a href="<?php echo get_the_permalink($project->ID); ?>">View Project</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 <?php echo $order_bottom; ?>">
                            <div class="work-item-img">
                                <a href="<?php echo get_the_permalink($project->ID); ?>">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url($project->ID, 'webalive-project-thumbnail')) ?>" alt="<?php $project->post_title; ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $count++; endforeach; ?>

            </div>
            <!-- For Ajax Loading -->
            <div id="js-append-work-item">
                <script type="text/html" id="tmpl-projects">
                    <# _.each(data.projects, function(project, index) { #>
                    <div class="work-item js-row-list">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 <# if( (index + 1) % 2 != 0 ) { #>order-1<# }else {  #>order-2<# } #>">
                                <div class="work-item-description">
                                    <div class="work-category">
                                        <# _.each(project.terms, function(term, index) { #>
                                        <span>{{term.name}}</span>
                                        <# }); #>
                                    </div>
                                    <div class="work-details-wrap">
                                        <div class="work-title">
                                            <h3>{{project.title}}</h3>
                                            <p>{{project.excerpt}}</p>
                                        </div>
                                        <# if( project.technologies != '' || project.industry != '' ) { #>
                                        <div class="work-data">
                                            <div class="row">
                                                <# if( project.technologies != '' ) { #>
                                                <div class="col-6 col-sm-6">
                                                    <h5>Technology</h5>
                                                    <p>{{project.technologies}}</p>
                                                </div>
                                                <# } #>
                                                <# if( project.industry != '' ) { #>
                                                <div class="col-6 col-sm-6">
                                                    <h5>Industry</h5>
                                                    <p>{{project.industry}}</p>
                                                </div>
                                                <# } #>
                                            </div>
                                        </div>
                                        <# } #>
                                        <a href="{{project.permalink}}">View Project</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6 <# if( (index + 1) % 2 != 0 ) { #>order-2<# }else {  #>order-1<# } #>">
                                <div class="work-item-img">
                                    <a href="{{project.permalink}}">
                                        <img src="{{project.image_url}}" alt="{{project.title}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <# }); #>
                </script>

                <!-- Load More Proejct Template Starts -->
                <script type="text/html" id="tmpl-loadmore-projects">
                    <# _.each(data.projects, function(project, index) { #>
                    <div class="work-item js-row-list">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 <# if( (index + 1) % 2 != 0 ) { #>order-1<# }else {  #>order-2<# } #>">
                                <div class="work-item-description">
                                    <div class="work-category">
                                        <# _.each(project.terms, function(term, index) { #>
                                        <span>{{term.name}}</span>
                                        <# }); #>
                                    </div>
                                    <div class="work-details-wrap">
                                        <div class="work-title">
                                            <h3>{{project.title}}</h3>
                                            <p>{{project.excerpt}}</p>
                                        </div>
                                        <# if( project.technologies != '' || project.industry != '' ) { #>
                                        <div class="work-data">
                                            <div class="row">
                                                <# if( project.technologies != '' ) { #>
                                                <div class="col-6 col-sm-6">
                                                    <h5>Technology</h5>
                                                    <p>{{project.technologies}}</p>
                                                </div>
                                                <# } #>
                                                <# if( project.industry != '' ) { #>
                                                <div class="col-6 col-sm-6">
                                                    <h5>Industry</h5>
                                                    <p>{{project.industry}}</p>
                                                </div>
                                                <# } #>
                                            </div>
                                        </div>
                                        <# } #>
                                        <a href="{{project.permalink}}">View Project</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6 <# if( (index + 1) % 2 != 0 ) { #>order-2<# }else {  #>order-1<# } #>">
                                <div class="work-item-img">
                                    <a href="{{project.permalink}}">
                                        <img src="{{project.image_url}}" alt="{{project.title}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <# }); #>
                </script>
                <!-- Load More Project Template Ends -->
            </div>

            <!-- Loader Starts-->
            <div class="lds-ellipsis fade-me"><div></div><div></div><div></div><div></div></div>
            <!-- Loader Ends -->
            <?php if( $project_count > $webalive['per_page'] ) : ?>                                        
            <!-- Load More Button Starts -->
            <div class="loadmore-wrap text-center mb-5">
                <button class="btn btn-default load-more" id="js-loadmore-projects">Load More Projects</button>
            </div>
            <!-- Load More Button Ends -->
            <?php endif; ?>
        </div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Portfolio_Sort_List() );
