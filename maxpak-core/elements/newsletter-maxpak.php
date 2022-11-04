<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Maxpak_Newsletter extends Widget_Base {

	public function get_name() {
		return 'maxpak-maxpak-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Maxpak Newsletter', 'maxpak-core' );
	}

	public function get_script_depends() {
        return [
            'maxpak-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-newspaper-o';
	}

    public function get_categories() {
		return [ 'maxpak-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'maxpak-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title',
			[
				'label' => __( 'Page Title', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'maxpak-core' ),
				'placeholder' => __( 'Type your title here', 'maxpak-core' ),
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
		$maxpak = $this->get_settings_for_display();
    ?>
        <!-- Add Markup Starts -->
		<form class="newsletter_form" name="newsletter_form" id="newsletter_form">
				<?php echo '<h2>' . $maxpak['page_title'] . '</h2>'; ?> 
				<input type="staticEmail" 
					class="newsletter_email"
					name="newsletter_email" 
					id="newsletter_email" 
					placeholder="Enter your email to sign up*" 
					required="required"><br><br>
				
				<input type="submit" 
					class="newsletter_submit"
					name="newsletter_submit" 
					id="newsletter_submit" 
					value="SIGNUP">
		<form>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maxpak_Newsletter() );