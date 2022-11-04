<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Maxpak_Multi_Select_Categories extends Widget_Base {

	public function get_name() {
		return 'maxpak-multi-select-categories';
	}

	public function get_title() {
		return esc_html__( 'select Categories', 'maxpak-core' );
	}

	public function get_script_depends() {
        return [
            'maxpak-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'maxpak-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'maxpak-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'cat_number',
			[
				'label' => __( 'Enter Category ID', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 5,
				'default' => 10,
			]
        );
        
		$this->add_control(
			'show_elements',
			[
				'label' => __( 'Category ID List', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
                'options' =>getProductCategoriesList(),
               
				
                'default' => [ 'title', 'description' ],
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
		$settings = $this->get_settings_for_display();
		foreach ( $settings['show_elements'] as $element ) {
            getProductCategoriesList();
			
		}

		$this->add_render_attribute(
			'maxpak_multi_select_categories_options',
			[
                'id' => 'maxpak-multi-select-categories-'.$this->get_id(),
                'data-catid' => $settings['cat_number']
			
			]
			
		);
    ?>
		<!-- Add Markup Starts -->
        <?php
        global $catid;
        $catid = $settings['cat_number'];
        ?>
		<section class="maxpack-home-categories-section" <?php echo $this->get_render_attribute_string( 'maxpak_multi_select_categories_options' ); ?>>
				<div class="container-fluid">
					<div class="row">
						<?php do_shortcode('[display-category-by-id]'); ?>
                        <a class ="btn-cat" href="http://www.google.com" target="_parent">SHOP NOW</a>
					</div>
				</div>
		</section>
		<!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maxpak_Multi_Select_Categories() );