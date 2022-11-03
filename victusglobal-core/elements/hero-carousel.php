<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Victus_Global_Image_Text_Carousel extends Widget_Base {

	public function get_name() {
		return 'victusglobal-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'Main Home Carousel', 'victusglobal-core' );
	}

	public function get_script_depends() {
        return [
            'victusglobal-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'victusglobal-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'victusglobal-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'upper_title', [
				'label' => __( 'Upper Title', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Upper Title Here' , 'victusglobal-core' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'main_title', [
				'label' => __( 'Main Title', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Main Title Here' , 'victusglobal-core' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'discription', [
				'label' => __( 'Description', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Description Text Here' , 'victusglobal-core' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Button Text', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Learn More' , 'victusglobal-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Button Link', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'victusglobal-core' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);		
		$repeater->add_control(
			'cta_link_scroll', [
				'label' => __( 'Scroll Link', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'victusglobal-core' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'Victus Global Image Text Slides', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'main_title' => __( 'Carousel Title', 'victusglobal-core' ),
					],
				],
				'title_field' => '{{{ main_title }}}',
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
		$victusglobal = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_project_showcase_options',
			[
				'id' => 'victusglobal-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class = "hero-home-slide-show">
			<div class="homeSliderOwl owl-carousel owl-theme" id="homeSliderOwlJs">
				<?php foreach( $victusglobal['hero_slides'] as $slide ) : 
					$target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
					?>
					<div class="item" data-dot="<button><?php echo $slide['main_title']; ?></button>">
						<div class="main-home-slider-part">
							<div class="slider-home-img"> <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" /></div>
							<div class="image-text-detail">
								<div class="slider-upper-title"><?php echo $slide['upper_title']; ?></div>
								<div class="slider-number-title"></div>
								<div class="slider-main-title"><?php echo $slide['main_title']; ?></div>
								<div class="slider-text-dis"><?php echo $slide['discription']; ?></div>
								<div class="slider-text-btn"><a href="<?php echo esc_url($slide['cta_link']['url']); ?>"<?php echo $target; ?> <?php echo $nofollow; ?>><?php echo $slide['cta_name']; ?></a></div>
							</div>	
						</div>
					</div>
				<?php endforeach; ?>
			</div>

	
			<div class="total-count-part">
				<span class="current"></span>
				<span class="divider">/</span>
				<span class="total"></span>
			</div>

			<style>
				.homeSliderOwl {
				height: auto;
				width: 800px;
				margin: 10px auto;
				}
				.homeSliderOwl .item {
				height: auto;
				width: 100%;
				background: #eeeeee;
				}
				.homeSliderOwl .item img {
				height: auto;
				width: 100%;
				}
				.owl-dots .owl-dot {
				margin: 0px 5px;
				}
				.owl-dots .owl-dot button {
				background: none;
				border: none;
				padding: 0;
				color: #555555;
				font-size: 14px;
				font-weight: bold;
				cursor: pointer;
				}
				.owl-dots .owl-dot button:focus {
				outline: none;
				}
				.owl-dots .owl-dot.active button {
				color: #000000;
				}
				.owl-theme .owl-dots .owl-dot {
				margin-right: 10px;
				}
			</style>

		</div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Victus_Global_Image_Text_Carousel() );