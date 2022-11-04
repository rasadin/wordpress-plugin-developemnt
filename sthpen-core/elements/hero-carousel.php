<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Image_Text_Carousel extends Widget_Base {

	public function get_name() {
		return 'sthpen-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'Image Text Carousel', 'sthpen-core' );
	}

	public function get_script_depends() {
        return [
            'sthpen-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'sthpen-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'sthpen-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Title Here' , 'sthpen-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'discription', [
				'label' => __( 'Discription', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Enter Discription Text Here' , 'sthpen-core' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Button Text', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'READ MORE' , 'sthpen-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Button Link', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sthpen-core' ),
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
				'label' => __( 'Scroll Link', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sthpen-core' ),
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
				'label' => __( 'Sthpen Image Text Slides', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Carousel Title #1', 'sthpen-core' ),
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
		$sthpen = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_project_showcase_options',
			[
				'id' => 'sthpen-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class = "hero-slide-show">
			<div class="owl-carousel owl-theme">
				<?php foreach( $sthpen['hero_slides'] as $slide ) : 
					$target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
					$nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
					?>
					<div class="item">
						<div class="image-text-mainitem">
							<div class="image-text-detail">
								<div class="image-text-title"><?php echo $slide['title']; ?></div>
								<div class="image-text-dis"><?php echo $slide['discription']; ?></div>
								<div class="image-text-btn"><a href="<?php echo esc_url($slide['cta_link']['url']); ?>"<?php echo $target; ?> <?php echo $nofollow; ?>><?php echo $slide['cta_name']; ?></a></div>
							</div>
                            <div class="image-text-img"> <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" /></div>
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