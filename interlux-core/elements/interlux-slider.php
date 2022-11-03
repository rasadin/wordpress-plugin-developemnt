<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Montpellier_Hero_Carousel extends Widget_Base {

	public function get_name() {
		return 'interlux-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'Interlux Slider', 'interlux-core' );
	}

	public function get_script_depends() {
        return [
            'interlux-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'interlux-for-elementor' ];
	}

	protected function register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'interlux-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Slider Title Here' , 'interlux-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'button_text', [
				'label' => __( 'Quote Button Text', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Quote Button Text' , 'interlux-core' ),
				'label_block' => true,
			]
		);	
		$repeater->add_control(
			'button_url', [
				'label' => __( 'Quote Button URL', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-link.com', 'interlux-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'about_button_text', [
				'label' => __( 'About Us Button Text', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'About Us Button' , 'interlux-core' ),
				'label_block' => true,
			]
		);	
		$repeater->add_control(
			'about_button_url', [
				'label' => __( 'About Us Button URL', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-link.com', 'interlux-core' ),
				'label_block' => true,
			]
		);
	
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'Interlux Slides', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Enter Slider Title Here', 'interlux-core' ),  
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
	<div class="slider main-slider">

		<div class="owl-slider owl-carousel owl-theme owl-slider-ild" <?php echo $this->get_render_attribute_string('fasttrac_logo_slider_options'); ?>>
			<?php foreach( $medival['hero_slides'] as $slide ) : ?>
				<div class="item">
				<div class="slider-description">
						<div class="webalive-interlux-picture"> <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="" /></div>
						<div class="webalive-interlux-title"> 
							<div class="slider-title"><?php echo ( $slide['title'] );?></div>
							<div class="quotebtn"><a href="<?php echo esc_url($slide['button_url']); ?>"><?php echo ($slide['button_text']); ?></a></div>
							<div class="aboutbtn"><a href="<?php echo esc_url($slide['about_button_url']); ?>"><?php echo ($slide['about_button_text']); ?></a></div>
						</div>
				</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="slider-counter"></div>
	</div>


    <!-- Add Markup Ends -->

					<!-- Owl Carusol Pagination Nav with Style -->
					<!-- <style>
						.owl-dots {
						counter-reset: slides-num;
						position: absolute;
						}
						.owl-dots:after {
						content: counter(slides-num);
						display: inline-block;
						vertical-align: middle;
						padding-left: 5px;
						}
						.owl-dot {
						display: inline-block;
						counter-increment: slides-num;
						margin-right: 6px;
						}
						.owl-dot.active:before {
						content: counter(slides-num) " /";
						display: inline-block;
						vertical-align: middle;
						position: absolute;
						left: 0;
						top: 0;
						}
					</style> -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Montpellier_Hero_Carousel() );