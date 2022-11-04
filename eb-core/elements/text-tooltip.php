<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Pricing_Page_Text_Tooltip extends Widget_Base {

	public function get_name() {
		return 'eb-pricing-text-tooltip';
	}

	public function get_title() {
		return esc_html__( 'Pricing Text Tooltip', 'eb-core' );
	}

	public function get_script_depends() {
        return [
            'eb-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'eb-for-elementor' ];
	}

	protected function register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'eb-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Text', 'eb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'eb-core' ),
				'placeholder' => __( 'Type your title here', 'eb-core' ),
			]
		);
        $this->add_control(
			'page_tool',
			[
				'label' => __( 'Tooltip', 'eb-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				// 'default' => __( 'Default Tooltip', 'eb-core' ),
				'placeholder' => __( 'Type your tooltip here', 'eb-core' ),
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
			'montpellier_page_heading_options',
			[
				'id' => 'mc-page-heading-'.$this->get_id(),
			]
		);
    ?>
     
        <div class="tooltip-area">
            <ul>
                <li>
                    <span class="mail-title"><?php echo  $webalive['page_title']; ?></span>

					<?php if($webalive['page_tool'] != null){ ?>
						<div class="price-tooltip">
							<span class="tooltip-icon">d</span>
								<div class="tooltip-content">
									<?php echo  $webalive['page_tool']; ?>
								</div>
						</div>  
					<?php } ?>

                </li>
            </ul>
        </div>


        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Pricing_Page_Text_Tooltip() );