<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Selected_Portfolios extends Widget_Base {

	public function get_name() {
		return 'webalive-Selected-portfolios';
	}

	public function get_title() {
		return esc_html__( 'Selected Portfolios', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-th-large';
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
				'default'   => __( 'Featured Projects', 'webalive2019-core' ),
				'label_block' => true
			]
        );
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
		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Grid Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => 'Default',
					'push-down' => 'Push Down'
				],
			]
		);

		$this->end_controls_section();
        

		/**
		 * Style Tab
		 */
		$this->style_tab();

	}
	
	public function featured_terms() {
		global $post;
		$terms = get_terms( 'projectcats', array(
			'orderby'    => 'count',
			'hide_empty' => 0
		));
		$terms_list = [];
		foreach($terms as $term) {
			$terms_list[$term->slug] = $term->name; 
		}
		return $terms_list;
	}

	private function style_tab() {}

	protected function render() {
		$webalive = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_selected_portfolios_options',
			[
				'id' => 'webalive-selected-portfolio-'.$this->get_id(),
			]
		);
		
    ?>
        <!-- Add Markup Starts -->
        <section class="feature-section <?php echo $webalive['grid_style']; ?>">
            <div class="container">
                <h2><?php echo $webalive['title']; ?></h2>
                <div class="row">
                    <?php do_shortcode('[selected-portfolio ids="'.$webalive['post_ids'].'" per_page="'.$webalive['posts_per_page'].'"]'); ?>
                </div>
            </div>
        </section>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Selected_Portfolios() );