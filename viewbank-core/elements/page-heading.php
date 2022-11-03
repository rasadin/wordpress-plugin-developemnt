<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_ViewBank_Page_Heading extends Widget_Base {

	public function get_name() {
		return 'viewbank-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Breadcrumb Heading', 'viewbank-core' );
	}

	public function get_script_depends() {
        return [
            'viewbank-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'viewbank-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'viewbank-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Page Title', 'viewbank-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'viewbank-core' ),
				'placeholder' => __( 'Type your title here', 'viewbank-core' ),
			]
		);
		$this->add_control(
			'page_title_text',
			[
				'label' => __( 'Text', 'viewbank-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Default Text', 'viewbank-core' ),
				'placeholder' => __( 'Type your text here', 'viewbank-core' ),
			]
        );
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'viewbank-core' ),
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
			'viewbank_page_heading_options',
			[
				'id' => 'viewbank-page-heading-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->

	<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
	<div class="container">
		<div class="page-head-content">
			<div class="page-breadcrumb-content">
				<?php global $post; ?>
					<!-- <a href="<?php echo home_url('/') ?>">Home</a><span class="separator"> &nbsp;&gt; </span> <?php the_title(); ?> -->
					<a href="<?php echo home_url('/') ?>">Home</a><span class="separator"> &nbsp;&gt;&nbsp;&gt; </span> <?php my_breadcrumb('main-menu'); ?>
			</div>
			<div class="page-title">
			    <?php echo '<h1>' . $webalive['page_title'] . '</h1>'; ?>
			</div>
			<div class="page-title-text">
			    <?php echo '<p>' . $webalive['page_title_text'] . '</p>'; ?>
			</div>
		</div>
	</div>
	</div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_ViewBank_Page_Heading() );