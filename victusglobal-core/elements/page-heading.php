<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Victusglobal_Hero_Page_heading extends Widget_Base {

	public function get_name() {
		return 'victusglobal-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Heading', 'victusglobal-core' );
	}

	public function get_script_depends() {
        return [
            'victusglobal-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'victusglobal-for-elementor' ];
	}

	
	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'victusglobal-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Title', 'victusglobal-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'victusglobal-core' ),
				'placeholder' => __( 'Type your title here', 'victusglobal-core' ),
			]
        );
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'victusglobal-core' ),
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
				'id' => 'victusglobal-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="page-header-default">
 				<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
				<div class="victusglobal-container-s container">
					<div class="page-header-content">

						<h1 class="page-title-victusglobal">
							<?php echo $webalive['page_title'] ; ?> 
						</h1>         
						<div class="victusglobal-breadcrumb">
						<span class="menu-name-part"><a href="<?php echo home_url('/'); ?>">Home</a></span>
						<span class="dynamic-menu-mid">></span>
						<?php wpd_nav_menu_breadcrumbs( 'main-menu' ); ?>
						</div> 
					</div>
				</div>
        </div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}



Plugin::instance()->widgets_manager->register_widget_type( new Widget_Victusglobal_Hero_Page_heading() );