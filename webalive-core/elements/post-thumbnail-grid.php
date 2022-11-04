<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Post_Thumbnail_Grid extends Widget_Base {

	public function get_name() {
		return 'webalive-post-thumbnail-grid';
	}

	public function get_title() {
		return esc_html__( 'Post Thumbnail Grid', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-grip-horizontal';
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
				'label' 	=> __( 'Content Settings', 'webalive2019-core' ),
				'tab' 		=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label' 		=> __( 'Title', 'webalive2019-core' ),
				'type' 			=> \Elementor\Controls_Manager::CODE,
				'default' 		=> __('<h2>Check our latest <span>insights</span> </h2>', 'webaive2019-core'),
				'language' 		=> 'html',
				'rows'			=> 20
			]
		);
		// $this->add_control(
		// 	'per_page',
		// 	[
		// 		'label' 		=> __( 'Per Page', 'webalive2019-core' ),
		// 		'type' 			=> \Elementor\Controls_Manager::TEXT,
		// 		'default' 		=> 2,
		// 	]
		// );
		$this->add_control(
			'post_ids',
			[
				'label'     => __( 'Post ID(s)', 'webalive2019-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( '', 'webalive2019-core' ),
				'placeholder'   => __( '1,2,3,4', 'webalive2019-core' ),
				'description'	=> __( 'Please add id with coma separator with no space in between' ),
				'label_block'	=> true
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
		$this->add_render_attribute(
			'webalive_post_thumbnail_grid_options',
			[
				'id' => 'webalive-post-thumbnail-grid-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <section class="home-latest-blog-section">
            <div class="row">
                <div class="col-sm-5 col-md-5">
                    <?php echo $webalive['title']; ?>
                </div>
                <div class="col-sm-7 col-md-7">
                    <div class="right-blog-side">
                        <?php do_shortcode('[post-thumb-grid ids="'.$webalive['post_ids'].'"]'); ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Post_Thumbnail_Grid() );