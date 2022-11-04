<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Team_Text_Carousel extends Widget_Base {

	public function get_name() {
		return 'shb-team-carousel';
	}

	public function get_title() {
		return esc_html__( 'SHB TEAM SLIDER', 'shb-core' );
	}

	public function get_script_depends() {
        return [
            'shb-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'shb-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'shb-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Name', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Name Here' , 'shb-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'dig', [
				'label' => __( 'Designation ', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter designation Here' , 'shb-core' ),
				'label_block' => true,
			]
		);

	
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'SHB TESTIMONIALS', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Person Name', 'shb-core' ),
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
		$shb = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_project_showcase_options',
			[
				'id' => 'shb-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class = "hero-team-show">
			<div class="owl-carousel owl-theme">
				<?php foreach( $shb['hero_slides'] as $slide ) : 
					// $target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
					// $nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
					?>
					<div class="item">
						<div class="image-text-mainitem">
							<div class="image-text-img"> <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="" /></div>
							<div class="image-text-detail">
								<div class="image-text-title"><?php echo $slide['title']; ?></div>
								<div class="image-text-btn"><?php echo $slide['dig']; ?></div>
							</div>
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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Team_Text_Carousel() );