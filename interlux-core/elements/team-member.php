<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_MontPillar_Team_Member extends Widget_Base {

	public function get_name() {
		return 'interlux-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'interlux-core' );
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
			'member_name',
			[
				'label' => __( 'Name', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default Name', 'interlux-core' ),
				'placeholder' => __( 'Type your name here', 'interlux-core' ),
			]
		);
        $this->add_control(
			'member_designation',
			[
				'label' => __( 'Designation', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default designation', 'interlux-core' ),
				'placeholder' => __( 'Type your designation here', 'interlux-core' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'interlux-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
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
				'id' => 'interlux-team-member-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<div class="team">
			<img src="<?php echo esc_url($webalive['image']['url']) ?>" alt="">
			<div class="info">
				<div class="designation">
					<?php echo '<span>' . $webalive['member_designation'] . '</span>'; ?>
					<?php echo '<h6>' . $webalive['member_name'] . '</h6>'; ?>
				</div>
			</div>
   		</div>
        <!-- Add Markup Ends-->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_MontPillar_Team_Member() );