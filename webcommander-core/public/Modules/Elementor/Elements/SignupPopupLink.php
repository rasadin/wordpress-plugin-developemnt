<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WCC_SignupPopupLink extends Widget_Base {

	public function get_name() {
		return 'wcc-signup-popup-link';
	}

	public function get_title() {
		return esc_html__( 'Signup Popup Link', 'webcommander-core' );
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
			'button_style',
			[
				'label' => __( 'Button Style', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => __( 'Style 1', 'webcommander-core' ),
					'style-2'  => __( 'Style 2', 'webcommander-core' ),
				],
				'label_block' => true
			]
        );
        $this->add_control(
			'button_label',
			[
				'label' => __( 'Label', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Get Started', 'webcommander-core' ),
				'placeholder' => __( 'Type your button label', 'webcommander-core' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'popup_type',
			[
				'label' => __( 'Popup Type', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'js-free-signup',
				'options' => [
					'js-free-signup'  => __( 'Free Sigup', 'webcommander-core' ),
					'js-paid-signup'  => __( 'Paid Sigup', 'webcommander-core' ),
				],
			]
        );
        $this->add_control(
			'button_alignment',
			[
				'label' => __( 'Alignment', 'webcommander-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'webcommander-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'webcommander-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'webcommander-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
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
	    $wcc = $this->get_settings_for_display();
	    $this->add_render_attribute(
			'wcc_atts',
			[
				'id' => 'wcc-signup-popup-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
		<?php if( 'style-1' == $wcc['button_style'] ) : ?>
			<div class="text-<?php echo esc_attr($wcc['button_alignment']); ?>">
				<a href="#" class="button-style-2-indp startforfree-btn <?php echo esc_attr($wcc['popup_type']); ?>"><?php echo $wcc['button_label']; ?></a>
			</div>
		<?php elseif( 'style-2' == $wcc['button_style'] ) : ?>
			<div class="get-started text-<?php echo esc_attr($wcc['button_alignment']); ?>">
				<a href="#" class="<?php echo esc_attr($wcc['popup_type']); ?>"><?php echo $wcc['button_label']; ?> <i aria-hidden="true" class="fas fa-chevron-right"></i></a> 
			</div>
		<?php endif; ?>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WCC_SignupPopupLink() );