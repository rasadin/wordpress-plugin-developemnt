<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Hero_Page_heading extends Widget_Base {

	public function get_name() {
		return 'sthpen-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Heading', 'sthpen-core' );
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
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'power-core' ),
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
			'mmvc_page_heading_options',
			[
				'id' => 'sthpen-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
  		<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
			<div class="page-head-content">
				<h1><?php echo $webalive['page_title'] ; ?></h1>
			</div>
		</div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}



Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mmvc_Hero_Page_heading() );