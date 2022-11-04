<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Project_Slider extends Widget_Base {

	public function get_name() {
		return 'project-slider';
	}

	public function get_title() {
		return esc_html__( 'Project Slider', 'webalive2019-core' );
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
			'project_slider_url',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$repeater->add_control(
			'project_slider_title', [
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Project Name', 'webalive2019-core' ),
				'placeholder' => __( 'Enter Project Name', 'webalive2019-core' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'project_slider_slides',
			[
				'label' => __( 'Repeater List', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'placeholder' => [
					[
						'project_slider_title' => __( 'Enter Project Name', 'webalive2019-core' ),
					],
				],
				'title_field' => '{{{ project_slider_title }}}',
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
			'project_hero_carousel_options',
			[
				'id' => 'project-slider-'.$this->get_id(),
			]
		);

		
    ?>
		<section class="swiper-container-project <?php echo $this->get_render_attribute_string( 'project_hero_carousel_options' ); ?>">
			<div class="swiper-wrapper">
				<?php foreach($webalive['project_slider_slides'] as $slide) :
					$target = $slide['project_slider_url']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $slide['project_slider_url']['nofollow'] ? ' rel="nofollow"' : '';				
				?>
						<div class="swiper-slide">
							<div class="cont-project">
								<img src="<?php echo esc_url( $slide['webalive_slider_slide']['url'] ) ?>" class="testimonial-entity-img" />
								<p class="project-url">
									<?php echo '<a href="' . $slide['project_slider_url']['url'] . '"' . $target . $nofollow . '> view project </a>'; ?>
								</p>
								<p class="project-title"><?php echo $slide['project_slider_title']; ?></p>
							</div>
						</div>
				<?php endforeach; ?>
			</div>
			<div class="nav-sw tes-pagination">
				<div class="swiper-button-prev-super swiper-button-prev">&nbsp;</div>
				<div class="swiper-pagination-super"></div>
				<div class="swiper-button-next-super swiper-button-next">&nbsp;</div>
			</div>
		</section>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Project_Slider() );