<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Portfolio_Grid extends Widget_Base {

	public function get_name() {
		return 'webalive-portfolio-grid';
	}

	public function get_title() {
		return esc_html__( 'Portfolio Grids', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-th';
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
				'label' => __( 'Content Settings', 'webalive2019-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        
        $this->add_control(
			'title',
			[
				'label'     => __( 'Title', 'webalive2019-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( 'You may also like', 'webalive2019-core' ),
			]
        );
        $this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Posts Per Page', 'webalive2019-core' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => __( '4', 'webalive2019-core' ),
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
			'webalive_projects_grid_options',
			[
				'id' => 'webalive-projects-grid-'.$this->get_id(),
			]
        );
    ?>
        <!-- Add Markup Starts -->
        <section class="feature-section">
            <div class="container">
                <h2><?php echo $webalive['title']; ?></h2>
                <div class="row">
                    <?php do_shortcode('[projects-grid per_page="'.$webalive['posts_per_page'].'"]'); ?>
                </div>
            </div>
        </section>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Portfolio_Grid() );