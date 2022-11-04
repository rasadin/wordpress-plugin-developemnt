<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Smsf_Page_Heading extends Widget_Base {

	public function get_name() {
		return 'smsf-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Breadcrumb Heading', 'smsf-core' );
	}

	public function get_script_depends() {
        return [
            'smsf-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'smsf-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'smsf-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Page Title', 'smsf-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'smsf-core' ),
				'placeholder' => __( 'Type your title here', 'smsf-core' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'smsf-core' ),
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
			'smsf_page_heading_options',
			[
				'id' => 'smsf-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->

	<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
	<div class="container">
		<div class="page-head-content">
			<div class="box-content">
				<div class="breadcrumb">
					<?php global $post; ?>
					<!-- <a href="<?php echo home_url('/') ?>">Home</a><span class="separator"> &nbsp;&gt; </span> <?php the_title(); ?> -->
					<a href="<?php echo home_url('/') ?>">Home</a><span class="separator"> &nbsp;&nbsp;/&nbsp;&nbsp; </span> <?php my_breadcrumb('main-menu'); ?>
				</div>
				<?php echo '<h1>' . $webalive['page_title'] . '</h1>'; ?>
			</div>
		</div>
	</div>
	</div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Smsf_Page_Heading() );