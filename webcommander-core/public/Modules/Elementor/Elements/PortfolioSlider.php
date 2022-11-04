<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WCC_Portfolio_Slider extends Widget_Base {

	public function get_name() {
		return 'wcc-portfolio-slider';
	}

	public function get_title() {
		return esc_html__( 'Portfolio Slider', 'webcommander-core' );
	}

	public function get_script_depends() {
        return [
            'wcc-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-sliders';
	}

    public function get_categories() {
		return [ 'wcc-for-elementor' ];
	}

    protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'webcommander-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Title' , 'webcommander-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Category', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Category' , 'webcommander-core' ),
				'label_block' => true,
			]
		);
		// $repeater->add_control(
		// 	'cta_link', [
		// 		'label' => __( 'Button Link', 'webcommander-core' ),
		// 		'type' => \Elementor\Controls_Manager::URL,
		// 		'placeholder' => __( 'https://your-link.com', 'webcommander-core' ),
		// 		'show_external' => false,
		// 		'default' => [
		// 			'url' => '',
		// 			'is_external' => false,
		// 			'nofollow' => true,
		// 		],
		// 	]
		// );

		$this->add_control(
			'portfolio_slides',
			[
				'label' => __( 'Portfolio Slides', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					['title' => __( 'Carousel Title #1', 'webcommander-core' )],
					['title' => __( 'Carousel Title #2', 'webcommander-core' )],
					['title' => __( 'Carousel Title #3', 'webcommander-core' )],
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
		$webcommander = $this->get_settings_for_display();
		$this->add_render_attribute(
			'wcc_atts',
			[
				'id' => 'wcc-portfolio-slider-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class="owl-carousel owl-theme wcc-portfolio-slider" <?php echo $this->get_render_attribute_string( 'wcc_atts' ); ?>>
			<?php foreach( $webcommander['portfolio_slides'] as $slide ) : ?>
				<div class="single-popular">
					<div class="img">
						<span class="selected-icon"><i class="fas fa-check"></i></span>
						<img src="<?php echo esc_url($slide['image']['url']) ?>" alt="">
						<div class="img-content">
							<input type="radio" name="popular" class="js-select-template" value="">
							<div class="img-content-inner">
								<p><a href="#" class="demo link link-style-1-indp" target="_blank">View Demo</a></p>
								<p><a href="" class="select link link-style-1-indp js-is-selected" target="_blank">Select</a></p>
							</div>
						</div>
					</div>
					<div class="content">					
						<h6 class="type"><?php echo $slide['title']; ?></h6>
						<h5 class="title"><?php echo $slide['cta_name']; ?></h5>					
					</div>
				</div>
			<?php endforeach; ?>
		</div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_WCC_Portfolio_Slider() );