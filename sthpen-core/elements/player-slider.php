<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Hero_Player_Slider extends Widget_Base {

	public function get_name() {
		return 'sthpen-player-slider';
	}

	public function get_title() {
		return esc_html__( 'Player Slider', 'sthpen-core' );
	}

	public function get_script_depends() {
        return [
            'sthpen-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
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
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Title', 'sthpen-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'sthpen-core' ),
				'placeholder' => __( 'Type your title here', 'sthpen-core' ),
			]
        );
		// Team 
		$this->add_control('team_name', [
			'label' => __('Select Team', 'sthpen-core'),
			'type' => Controls_Manager::SELECT2,
			'options' => get_team_list_as_select_box_for_sportspress_plugin(), //<-- Check this line.
			'multiple' => false,
			'label_block' => true,
			'default' => ''
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
			'mmvc_page_heading_options',
			[
				'id' => 'sthpen-player-slider-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <?php 
		$team_id = $webalive['team_name'];
		// var_dump($team_id);
		// $team_id = $webalive['page_title'];
		// echo postSlider($team_id); 
		echo getTeamMemberSportsPress($team_id); ?>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}



Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mmvc_Hero_Player_Slider() );