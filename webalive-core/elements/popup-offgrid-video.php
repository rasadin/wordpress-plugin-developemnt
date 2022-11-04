<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Popup_Offgrid_Video extends Widget_Base {

	public function get_name() {
		return 'webalive-popup-offgrid-video';
	}

	public function get_title() {
		return esc_html__( 'Popup Offgrid Video', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-photo-video';
	}

    public function get_categories() {
		return [ 'webalive-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'image',
			[
				'label' => __( 'Background Image', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );
        $this->add_control(
			'youtube_video_id',
			[
				'label' => __( 'Video ID (YouTube)', 'webalive2019-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true
			]
        );
        $this->add_control(
			'frame_height',
			[
				'label' => __( 'iFrame Height', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 80,
				'max' => 1200,
				'step' => 10,
                'default' => 800,
                'description' => 'Keep frame height 800px for HD'
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
			'webalive_popup_offgrid_video',
			[
                'id' => 'webalive-popup-offgrid-video-'.$this->get_id(),
                'data-bg' => $webalive['image']['url'],
                'data-frame-height' => $webalive['frame_height']
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="webalive-offgrid-canvas" <?php echo $this->get_render_attribute_string('webalive_popup_offgrid_video'); ?>>
            <div class="play-btn"><i class="fas fa-play"></i></div>
            <div class="offgrid-video-player">
                <div class="frame-close"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/img/close.png" alt=""></div>
				<iframe class="youtube-frame" src="" data-src="https://www.youtube.com/embed/<?php echo $webalive['youtube_video_id']; ?>?rel=0&VQ=HD720&autoplay=0" frameborder="0" allowfullscreen></iframe>
			</div>
        </div>
        
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Popup_Offgrid_Video() );