<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Maxpak_Home_Carousel extends Widget_Base {

	public function get_name() {
		return 'maxpak-home-carousel';
	}

	public function get_title() {
		return esc_html__( 'Home Slider', 'maxpak-core' );
	}

	public function get_script_depends() {
        return [
            'maxpak-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'maxpak-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'maxpak-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Carousel Title' , 'maxpak-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => __( 'Default description', 'plugin-domain' ),
				'placeholder' => __( 'Type your description here', 'plugin-domain' ),
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'cta_name', [
				'label' => __( 'Button Text', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Read More' , 'maxpak-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'cta_link', [
				'label' => __( 'Button Link', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'maxpak-core' ),
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
				'label' => __( 'Hero Slides', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Carousel Title #1', 'maxpak-core' ),
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
		$maxpak_slider = $this->get_settings_for_display();
		$this->add_render_attribute(
			'maxpak_home_carousel_options',
			[
				'id' => 'maxpak-home-carousel-'.$this->get_id(),
			
			]
			
		);
    ?>
        <!-- Add Markup Starts -->
		<div class="maxpak-slider-show">
		<div class="owl-carousel owl-theme">
			<?php foreach( $maxpak_slider['hero_slides'] as $slide ) : ?>
			<div class="item">
			<div class="textoverlay">
					<h2><?php echo $slide['title']; ?></h2>
					<p><?php echo $slide['item_description']; ?></p>
					<a class= "read-btn" href="<?php echo esc_url($slide['cta_link']['url']); ?>"><?php echo $slide['cta_name']; ?></a>
				</div>
				<img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" />
				
			</div>
			<?php endforeach; ?>
		</div>
		</div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maxpak_Home_Carousel() );