<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Bayside_Cost_Carousel extends Widget_Base {

	public function get_name() {
		return 'bayside-cost-carousel';
	}

	public function get_title() {
		return esc_html__( 'Cost Carousel', 'bayside-core' );
	}

	public function get_script_depends() {
        return [
            'bayside-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-television';
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
			'text',
			[
				'label' => __( 'Description', 'bayside-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'bayside-core' ),
				'placeholder' => __( 'Type your description here', 'bayside-core' ),
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
		<div class = "cost-slide-show">
        <div class="owl-carousel owl-theme">
			<?php foreach( $bayside['hero_slides'] as $slide ) : ?>
			<div class="item">
				<img src="<?php echo esc_url($slide['image']['url']) ?>" alt="<?php echo esc_attr($slide['cta_name']); ?>" />
				<div class="cost-detail">
				<?php echo $slide['text']; ?>
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


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Bayside_Cost_Carousel() );