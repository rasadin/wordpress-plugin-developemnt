<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Bayside_Hero_Carousel extends Widget_Base {

	public function get_name() {
		return 'bayside-hero-carousel';
	}

	public function get_title() {
		return esc_html__( 'Hero Carousel', 'bayside-core' );
	}

	public function get_script_depends() {
        return [
            'bayside-public'
        ];
    }

	public function get_icon() {
		return 'eicon-carousel';
	}

    public function get_categories() {
		return [ 'bayside-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'bayside-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Carousel Title' , 'bayside-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Button Text', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Read More' , 'bayside-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Button Link', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'bayside-core' ),
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
				'label' => __( 'Hero Slides', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Carousel Title #1', 'bayside-core' ),
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
		$bayside = $this->get_settings_for_display();
		$this->add_render_attribute(
			'webalive_project_showcase_options',
			[
				'id' => 'bayside-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class = "hero-slide-show">
        <div class="owl-carousel owl-theme">
			<?php foreach( $bayside['hero_slides'] as $slide ) : ?>
			<div class="item">
				<img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" />
				<div class="banner-detail">
					<h5><?php echo $slide['title']; ?></h5>
					<a href="<?php echo esc_url($slide['cta_link']['url']); ?>"><?php echo $slide['cta_name']; ?></a>
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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Bayside_Hero_Carousel() );