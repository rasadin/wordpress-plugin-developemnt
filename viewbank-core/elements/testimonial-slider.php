<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Viewbank_Hero_Carousel extends Widget_Base {

	public function get_name() {
		return 'viewbank-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'Mobile Slider', 'viewbank-core' );
	}

	public function get_script_depends() {
        return [
            'viewbank-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'viewbank-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'viewbank-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Name', 'viewbank-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Name Here' , 'viewbank-core' ),
				'label_block' => true,
			]
		);
	
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'viewbank-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'Mobile Slides', 'viewbank-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Enter Image Here', 'viewbank-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
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
		$medival = $this->get_settings_for_display();
		$this->add_render_attribute(
			'fasttrac_logo_slider_options',
			[
				'id' => 'fasttrac-logo-carousel-'.$this->get_id(),
			]
		);
    ?>
    <!-- Add Markup Starts -->
	<div class="logo-slider-fasttrack">
		<div class="owl-carousel owl-theme" <?php echo $this->get_render_attribute_string('fasttrac_logo_slider_options'); ?>>
			<?php foreach( $medival['hero_slides'] as $slide ) : ?>
				<div class="item">
				<div class="webalive-testimonials-detail">
						<div class="webalive-testimonials-picture"> <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="" /></div>
				</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
    <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Viewbank_Hero_Carousel() );