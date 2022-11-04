<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Testimonial extends Widget_Base {

	public function get_name() {
		return 'testimonial-carousel';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
             'webalive-public-script'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'webalive_slider_slide',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'testimonial_slider_author_text', [
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label' => esc_html__( 'Text', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Text Here...', 'webalive2019-core' ),
				'label_block' => true,
			]
		);		
		$repeater->add_control(
			'testimonial_slider_author_name', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Author Name', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Author Name', 'webalive2019-core' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'testimonial_slider_slides',
			[
				'label' => __( 'Repeater List', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'placeholder' => [
					[
						'testimonial_slider_author_name' => __( 'Enter Author Name', 'webalive2019-core' ),
					],
				],
				'title_field' => '{{{ testimonial_slider_author_name }}}',
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
			'testimonial_hero_carousel_options',
			[
				'id' => 'testimonial-carousel-'.$this->get_id(),
			]
		);

		
    ?>
		<section class="swiper-container-testimonial <?php echo $this->get_render_attribute_string( 'testimonial_hero_carousel_options' ); ?>">
			<div class="swiper-wrapper">
				<?php foreach($webalive['testimonial_slider_slides'] as $slide) :?>
						<div class="swiper-slide">
							<div class="cont-testimonial">
								<img src="<?php echo esc_url( $slide['webalive_slider_slide']['url'] ) ?>" class="testimonial-entity-img" />
								<p class="txt-testimonial"><?php echo $slide['testimonial_slider_author_text']; ?></p>
								<p class="tit-testimonial"><?php echo $slide['testimonial_slider_author_name']; ?></p>
								<div class="nav-sw tes-pagination">
									<div class="swiper-button-prev swiper-button-prev-nosuper">&nbsp;</div>
									<div class="swiper-pagination"></div>
									<div class="swiper-button-next swiper-button-next-nosuper">&nbsp;</div>
								</div>
							</div>
						</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Testimonial() );