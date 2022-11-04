<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Hero_Page_heading extends Widget_Base {

	public function get_name() {
		return 'sharecare-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Heading', 'sharecare-core' );
	}

	public function get_script_depends() {
        return [
            'sharecare-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'sharecare-for-elementor' ];
	}

	
	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'sharecare-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Title', 'sharecare-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'sharecare-core' ),
				'placeholder' => __( 'Type your title here', 'sharecare-core' ),
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
				'id' => 'sharecare-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="page-header-default">
 				<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
				<div class="sharecare-container-s container">
					<div class="page-header-content">

						<h1 class="page-title-sharecare">
							<?php echo $webalive['page_title'] ; ?> 
						</h1>         
						<div class="sharecare-breadcrumb">
						<span class="home-menu"><a href="<?php echo home_url('/'); ?>">Home</a></span>
						<span class="dynamic-menu-s"><?php echo " " ?></span>
						<span class="dynamic-menu-line">/</span>
						<span class="dynamic-menu-s"><?php echo " " ?></span>
						<span class="dynamic-menu"><?php get_breadcrumb(); ?></span>
						
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