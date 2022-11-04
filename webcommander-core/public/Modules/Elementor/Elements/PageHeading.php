<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WCC_Page_Heading extends Widget_Base {

	public function get_name() {
		return 'wcc-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Page Heading', 'webcommander-core' );
	}

	public function get_script_depends() {
        return [
            'wcc-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'wcc-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'webcommander-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Title', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'webcommander-core' ),
				'placeholder' => __( 'Type your title here', 'webcommander-core' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'page_title_text',
			[
				'label' => __( 'Description', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Description', 'webcommander-core' ),
				'placeholder' => __( 'Type your title description here', 'webcommander-core' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'page_title_link_text',
			[
				'label' => __( 'Button Text', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Link Text', 'webcommander-core' ),
				'placeholder' => __( 'Type your title link text here', 'webcommander-core' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'page_title_link',
			[
				'label' => __( 'Link', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'webcommander-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'wcc-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->add_control(
			'button_control',
			[
				'label' => __( 'Show Button', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'yes', 'webcommander-core' ),
					'no' => __( 'no', 'webcommander-core' ),
				],
			]
		);


		$this->add_control(
			'text_control',
			[
				'label' => __( 'Show Description', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'yes', 'webcommander-core' ),
					'no' => __( 'no', 'webcommander-core' ),
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
			'wcc_page_heading_options',
			[
				'id' => 'amplio-hero-carousel-'.$this->get_id(),
			]
		);

		$target = $webalive['page_title_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $webalive['page_title_link']['nofollow'] ? ' rel="nofollow"' : '';
    ?>
        <!-- Add Markup Starts -->
	<div class="page-header-section" style="background-image:url('<?php echo esc_url($webalive['image']['url']) ?>')">
		<div class="page-heading">
			<div class="page-head-title"><?php echo '<h1>' . $webalive['page_title'] . '</h1>'; ?></div>

			<?php if($webalive['text_control'] != "no"){ ?>
			<div class="page-head-tile-text"><?php echo '<p>' . $webalive['page_title_text'] . '</p>'; ?></div>
			<?php } ?>

			<?php if($webalive['button_control'] != "no"){ ?>
				<div class="page-head-title-btn"><a href="<?php echo  $webalive['page_title_link']['url'] ?>"><?php echo '<p>' . $webalive['page_title_link_text'] . '</p>'; ?></a></div>
			<?php } ?>	
		</div>
    </div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WCC_Page_Heading() );