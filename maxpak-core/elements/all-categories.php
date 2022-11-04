<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Maxpak_All_Categories extends Widget_Base {

	public function get_name() {
		return 'maxpak-all-categories';
	}

	public function get_title() {
		return esc_html__( 'All Categories', 'maxpak-core' );
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

		$this->end_controls_section();
		
		/**
		 * Style Tab
		 */
		$this->style_tab();

    }

	private function style_tab() {}

	protected function render() {
		$settings = $this->get_settings_for_display();	
		$this->add_render_attribute(
			'maxpak_all_categories_options',
			[
                'id' => 'maxpak-all-categories-'.$this->get_id(),
			
			]
			
		);
    ?>
		<!-- Add Markup Starts -->
        <?php
        global $catid;
        $catid = $settings['cat_number'];
        ?>
		<section class="maxpack-all-section" <?php echo $this->get_render_attribute_string( 'maxpak_all_categories_options' ); ?>>

						<?php do_shortcode('[get_all_product_categories_details]'); ?>
      

		</section>
		<!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maxpak_All_Categories() );