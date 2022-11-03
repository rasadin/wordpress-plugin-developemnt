<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_MontPillar_Dance_Classes extends Widget_Base {

	public function get_name() {
		return 'interlux-dance-classes';
	}

	public function get_title() {
		return esc_html__( 'Dance Classes', 'interlux-core' );
	}

	public function get_script_depends() {
        return [
            'interlux-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-address-card';
	}

    public function get_categories() {
		return [ 'interlux-for-elementor' ];
	}

	protected function register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'interlux-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'dance_classes_title',
			[
				'label' => __( 'Title', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default Title', 'interlux-core' ),
				'placeholder' => __( 'Type your title here', 'interlux-core' ),
			]
		);
        $this->add_control(
			'dance_classes_dis',
			[
				'label' => __( 'Description', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default description', 'interlux-core' ),
				'placeholder' => __( 'Type your description here', 'interlux-core' ),
			]
		);
		$this->add_control(
			'dance_classes_link',
			[
				'label' => __( 'Link', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'www.yourlink.com', 'interlux-core' ),
				'placeholder' => __( 'Enter your div link here', 'interlux-core' ),
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
			'montpellier_team_member_options',
			[
				'id' => 'interlux-dance-classes-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class="dance-classes" id="dance-classes" data-href="<?php echo $webalive['dance_classes_link']?>">
				<div class="dance-classes-info">
					<div class="description">
						<?php echo '<h3>' . $webalive['dance_classes_title'] . '</h3>'; ?>
						<?php echo '<p>' . $webalive['dance_classes_dis'] . '</p>'; ?>
					</div>
				</div>
   		</div>
        <!-- Add Markup Ends-->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_MontPillar_Dance_Classes() );