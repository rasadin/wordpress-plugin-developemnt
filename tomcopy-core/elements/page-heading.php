<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Hero_Page_heading extends Widget_Base {

	public function get_name() {
		return 'tomcopy-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Heading', 'tomcopy-core' );
	}

	public function get_script_depends() {
        return [
            'tomcopy-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
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
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Title', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'tomcopy-core' ),
				'placeholder' => __( 'Type your title here', 'tomcopy-core' ),
			]
        );
        $this->add_control(
			'page_dis',
			[
				'label' => __( 'Description', 'tomcopy-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Default title', 'tomcopy-core' ),
				'placeholder' => __( 'Type your title here', 'tomcopy-core' ),
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
				'id' => 'tomcopy-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="page-header-default">
            <div class="tomcopy-container-s container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="page-header-content">
                            <?php echo '<h1>' . $webalive['page_title'] . '</h1>'; ?>            
                            <?php echo '<p>' . $webalive['page_dis'] . '</p>'; ?>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}



Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mmvc_Hero_Page_heading() );