<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Clients_Reviews extends Widget_Base {

	public function get_name() {
		return 'clients-testimonial-carousel';
	}

	public function get_title() {
		return esc_html__( 'Clients Reviews Carousel', 'webalive2019-core' );
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
			'webalive_slider_slide_clients',
			[
				'label' => __( 'Choose Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'clients_slider_title', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Title', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Title Here', 'webalive2019-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'clients_slider_author_text', [
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label' => esc_html__( 'Text', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Text Here...', 'webalive2019-core' ),
				'label_block' => true,
			]
		);		
		$repeater->add_control(
			'clients_slider_author_name', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Author Name', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Author Name', 'webalive2019-core' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'clients_slider_author_position', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Author Designation', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Author Designation', 'webalive2019-core' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'testimonial_slider_slides_clients',
			[
				'label' => __( 'Repeater List', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'placeholder' => [
					[
						'clients_slider_author_name' => __( 'Enter Author Name', 'webalive2019-core' ),
					],
				],
				'title_field' => '{{{ clients_slider_author_name }}}',
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
			'testimonial_clients_carousel_options',
			[
				'id' => 'clients-testimonial-carousel-'.$this->get_id(),
			]
		);

		
    ?>
		<section class="swiper-container-clients <?php echo $this->get_render_attribute_string( 'testimonial_clients_carousel_options' ); ?>">
			<div class="swiper-wrapper">
				<?php foreach($webalive['testimonial_slider_slides_clients'] as $slide) :?>
						<!-- <div class="swiper-slide"> -->
							<div class="cont-testimonial-clients">
								<img src="<?php echo esc_url( $slide['webalive_slider_slide_clients']['url'] ) ?>" class="clients-testimonial-entity-img" />
								<p class="txt-testimonial-clients-title"><?php echo $slide['clients_slider_title']; ?></p>		
								<p class="txt-testimonial-author-text"><?php echo $slide['clients_slider_author_text']; ?></p>
								<p class="tit-testimonial-author-name"><?php echo $slide['clients_slider_author_name']; ?></p>
								<p class="tit-testimonial-author-position"><?php echo $slide['clients_slider_author_position']; ?></p>
							</div>
						<!-- </div> -->
				<?php endforeach; ?>
			</div>
			<div class="nav-sw tes-pagination-clients">
				<div class="swiper-button-prev swiper-button-prev-clients">&nbsp;</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next swiper-button-next-clients">&nbsp;</div>
			</div>
		</section>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Clients_Reviews() );