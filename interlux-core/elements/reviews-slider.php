<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Montpellier_Reviews_Carousel extends Widget_Base {

	public function get_name() {
		return 'interlux-reviews-carousel';
	}

	public function get_title() {
		return esc_html__( 'Reviews Slider', 'interlux-core' );
	}

	public function get_script_depends() {
        return [
            'interlux-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-star-half-alt';
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
			'user_name', [
				'label' => __( 'Author Information', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Author Information Here' , 'interlux-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'reviews_text', [
				'label' => __( 'Reviews Text', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Reviews Text Here' , 'interlux-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'reviews_style',
			[
				'label' => __( 'Review Star', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '5 Stars',
				'options' => [
					'<div class="five-star"></div>'  => __( '5 Stars', 'interlux-core' ),
					'<div class="four-star"></div>' => __( '4 Stars', 'interlux-core' ),
				],
			]
		);
		$this->add_control(
			'reviews_slides',
			[
				'label' => __( 'Interlux Reviews Slides', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'user_name' => __( 'Enter Author Name Here', 'interlux-core' ),  
					],
				],
				'title_field' => '{{{ user_name }}}',
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
			'reviews_slider_options',
			[
				'id' => 'reviews-carousel-'.$this->get_id(),
			]
		);
    ?>
    <!-- Add Markup Starts -->
	<div class="slider main-reviews-slider">

		<div class="owl-slider owl-carousel owl-theme owl-slider-rev" <?php echo $this->get_render_attribute_string('reviews_slider_options'); ?>>
			<?php foreach( $medival['reviews_slides'] as $slide ) : ?>
				<div class="item">
				<div class="reviews-slider-description">
						<div class="reviews-interlux-star"><?php echo ( $slide['reviews_style'] );?></div>
						<div class="reviews-interlux-text"><?php echo ( $slide['reviews_text'] );?></div>
						<div class="reviews-interlux-author"><?php echo ( $slide['user_name'] );?></div>
				</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="slider-counter-rev"></div>
	</div>
    <!-- Add Markup Ends -->
				<!-- Owl Carusol Pagination Nav with Style -->
				<!-- <style>
					.owl-dots {
					counter-reset: slides-num+1;
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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Montpellier_Reviews_Carousel() );