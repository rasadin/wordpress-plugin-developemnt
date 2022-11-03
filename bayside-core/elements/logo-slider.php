<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Bayside_Hero_Carousel_Logo extends Widget_Base {

	public function get_name() {
		return 'bayside-hero-carousel-logo';
	}

	public function get_title() {
		return esc_html__( 'Logo Slider', 'bayside-core' );
	}

	public function get_script_depends() {
        return [
            'bayside-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'bayside-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'bayside-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Carousel Title' , 'bayside-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'Hero Slides', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Carousel Title #1', 'bayside-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		/**
         * Slider Settings
         */
		$this->start_controls_section(
			'slider_section',
			[
				'label' => __( 'Slider Settings', 'bayside-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'num_of_slides',
			[
				'label' => __( 'Number of Slides', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'placeholder' => __( 'Enter the number of slides', 'plugin-domain' ),
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
		$bayside = $this->get_settings_for_display();
		$this->add_render_attribute(
			'fasttrac_logo_slider_options',
			[
				'id' => 'fasttrac-logo-carousel-'.$this->get_id(),
				'data-slide' => $bayside['num_of_slides'],
			]
		);
    ?>
        <!-- Add Markup Starts -->
	<div class="logo-slider-fasttrack">
			<div class="owl-carousel owl-theme" <?php echo $this->get_render_attribute_string('fasttrac_logo_slider_options'); ?>>
				<?php foreach( $bayside['hero_slides'] as $slide ) : ?>
				<div class="item">
					<img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" />
				</div>
				<?php endforeach; ?>
			</div>
	</div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Bayside_Hero_Carousel_Logo() );