<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Image_Text_Carousel extends Widget_Base {

	public function get_name() {
		return 'tomcopy-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'TOMCOPY TESTIMONIALS SLIDER', 'tomcopy-core' );
	}

	public function get_script_depends() {
        return [
            'tomcopy-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'tomcopy-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'tomcopy-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Name', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Name Here' , 'tomcopy-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'dig', [
				'label' => __( 'Designation ', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter designation Here' , 'tomcopy-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Company Name', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Company' , 'tomcopy-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Company Link', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'tomcopy-core' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);		
		

		
		$repeater->add_control(
			'discription', [
				'label' => __( 'Description', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Description Text Here' , 'tomcopy-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'TOMCOPY TESTIMONIALS', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Carousel Title #1', 'tomcopy-core' ),
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
		$tomcopy = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_project_showcase_options',
			[
				'id' => 'tomcopy-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class = "hero-slide-show">
			<div class="owl-carousel owl-theme">
				<?php foreach( $tomcopy['hero_slides'] as $slide ) : 
					$target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
					?>
					<div class="item">
						<div class="image-text-mainitem">
							<div class="image-text-dis"><?php echo $slide['discription']; ?></div>
							<div class="image-text-detail">
								<div class="image-text-title"><?php echo $slide['title']; ?></div>
								<!-- <div class="image-text-btn"><?php //echo $slide['dig']; ?> <a href="<?php //echo esc_url($slide['cta_link']['url']); ?>"<?php //echo $target; ?> <?php //echo $nofollow; ?>><?php //echo $slide['cta_name']; ?></a></div> -->
								<div class="image-text-btn">
									<div class="image-text-btn2"><?php echo $slide['cta_name']; ?></div>
									<div class="image-text-btn1"><?php echo $slide['dig']; ?></div>		
								</div>

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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mmvc_Image_Text_Carousel() );