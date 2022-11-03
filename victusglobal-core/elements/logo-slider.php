<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Victus_Global_Logo_Carousel extends Widget_Base {

	public function get_name() {
		return 'victusglobal-logo-carousel';
	}

	public function get_title() {
		return esc_html__( 'Logo Carousel', 'victusglobal-core' );
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
			'main_title', [
				'label' => __( 'Main Title', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Main Title Here' , 'victusglobal-core' ),
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
		<div class = "hero-logo-slide-show">
			<div class="logoSliderOwl owl-carousel owl-theme" id="logoSliderOwlJs">
				<?php foreach( $victusglobal['hero_slides'] as $slide ) : 
					?>
					<div class="item">
						<div class="main-logo-slider-part">
							<div class="slider-logo-img"> <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="This is logo slider." /></div>	
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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Victus_Global_Logo_Carousel() );