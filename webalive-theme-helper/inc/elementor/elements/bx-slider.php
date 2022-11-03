<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WTH_BX_Slider extends Widget_Base {

	public function get_name() {
		return 'wth-bx-slider';
	}

	public function get_title() {
		return esc_html__( 'Webalive Slider', 'wth' );
	}

	public function get_script_depends() {
        return [
            'wth-public'
        ];
    }

	public function get_icon() {
		return 'eicon-carousel';
	}

    public function get_categories() {
		return [ 'wth-elements-elementor' ];
	}

	protected function _register_controls() {
        /**
         * General Settings
         */
        $this->start_controls_section(
            'wth_general_settings',
            [
                'label' => esc_html__( 'General Settings', 'wth' )
            ]
        );
        $this->add_control(
            'wth_slider_mode',
            [
                'label'       	=> esc_html__( 'Mode', 'wth' ),
                'type' 			=> Controls_Manager::SELECT,
                'default' 		=> 'fade',
                'label_block' 	=> false,
                'description'   => 'Type of transition between slides',
                'options' 		=> [
                    'fade'  		=> esc_html__( 'Fade', 'wth' ),
                    'vertical'  	=> esc_html__( 'Vertical', 'wth' ),
                    'horizontal'  	=> esc_html__( 'Horizontal', 'wth' ),
                ],
            ]
        );
        $this->add_control(
            'wth_slider_caption',
            [
                'label' => __( 'Caption', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'Slider caption content.',
            ]
        );
        $this->add_control(
            'wth_slider_speed',
            [
                'label'       	=> esc_html__( 'Speed', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 500,
                'label_block' 	=> false,
                'description'   => 'Slide transition duration (in ms)',
            ]
        );
        $this->add_control(
            'wth_slider_pause',
            [
                'label'       	=> esc_html__( 'Pause', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 4000,
                'label_block' 	=> false,
                'description'   => 'The amount of time (in ms) between each auto transition',
            ]
        );
        $this->add_control(
            'wth_slider_autoplay',
            [
                'label' => __( 'Autoplay', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'Slides will automatically transition',
            ]
        );
        $this->add_control(
            'wth_slider_pager',
            [
                'label' => __( 'Pager Dots', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'If true, a pager will be added',
            ]
        );
        
        
        $this->end_controls_section();
        /**
         * Content Settings
         */
        $this->start_controls_section(
            'wth_content_settings',
            [
                'label' => esc_html__( 'Content Settings', 'wth' )
            ]
        );
        $this->add_control(
			'wth_slider_slides',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'wth_slider_slide' => 'https://placeimg.com/1000/600/any' ],
					[ 'wth_slider_slide' => 'https://placeimg.com/1000/600/arch' ],
					[ 'wth_slider_slide' => 'https://placeimg.com/1000/600/nature' ],
				],
				'fields' => [
                    [
						'name' => 'wth_slider_slide_title',
						'label' => esc_html__( 'Content', 'wth' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( '#1 Slider Title', 'wth' ),
						'label_block' => true,
					],
                    [
                        'name' => 'wth_slider_slide',
                        'label' => __( 'Choose Image', 'wth' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            // 'url' => \Elementor\Utils::get_placeholder_image_src(),
                            'url' => 'https://placeimg.com/1000/600/any',
                        ],
                    ],
				  	[
						'name' => 'wth_slider_slide_content',
						'label' => esc_html__( 'Content', 'wth' ),
						'type' => Controls_Manager::WYSIWYG,
						'default' => esc_html__( 'Add some content to show on the slider slide caption', 'wth' ),
						'condition' => [],
					],
				],
				'title_field' => '{{wth_slider_slide_title}}',
			]
		);
          $this->end_controls_section();
          
        /**
         * Advance Settings
         */
        $this->start_controls_section(
            'wth_advance_settings',
            [
                'label' => esc_html__( 'Advance Settings', 'wth' )
            ]
        );
        $this->add_control(
            'wth_slider_slide_margin',
            [
                'label'       	=> esc_html__( 'Slide Margin', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 0,
                'label_block' 	=> false,
                'description'   => 'Margin between each slide',
            ]
        );
        $this->add_control(
            'wth_slider_start_slide',
            [
                'label'       	=> esc_html__( 'Start Slide', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 0,
                'label_block' 	=> false,
                'description'   => 'Starting slide index (zero-based)',
            ]
        );
        $this->add_control(
            'wth_slider_random_start',
            [
                'label' => __( 'Random Start', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'Start slider on a random slide',
            ]
        );
        $this->add_control(
            'wth_slider_infinite_loop',
            [
                'label' => __( 'Infinite Loop', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'If true, clicking "Next" while on the last slide will transition to the first slide and vice-versa',
            ]
        );
        $this->add_control(
            'wth_slider_hide_ctrl_on_end',
            [
                'label' => __( 'Hide Control On End', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'If true, "Prev" and "Next" controls will receive a class disabled when slide is the first or the last
                Note: Only used when infiniteLoop: false',
            ]
        );
        $this->add_control(
            'wth_slider_easing',
            [
                'label' => __( 'Easing', 'wth' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ease',
				'options' => [
					'linear'        => __( 'linear', 'wth' ),
					'ease'          => __( 'ease', 'wth' ),
					'ease-in'       => __( 'ease-in', 'wth' ),
					'ease-out'      => __( 'ease-out', 'wth' ),
					'ease-in-out'   => __( 'ease-in-out', 'wth' ),
                ],
                'description'   => 'The type of "easing" to use during transitions.'
            ]
        );
        $this->add_control(
            'wth_slider_ticker',
            [
                'label' => __( 'Ticker', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'Use slider in ticker mode (similar to a news ticker)',
            ]
        );
        $this->add_control(
            'wth_slider_ticker_hover',
            [
                'label' => __( 'Ticker Hover', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'Ticker will pause when mouse hovers over slider',
                'condition' => [
                    'wth_slider_ticker' => 'true'
                ]
            ]
        );
        $this->add_control(
            'wth_slider_adaptive_height',
            [
                'label' => __( 'Adaptive Height', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'Dynamically adjust slider height based on each slide\'s height',
            ]
        );
        $this->add_control(
            'wth_slider_adaptive_hieght_speed',
            [
                'label'       	=> esc_html__( 'Adaptive Height Speed', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 500,
                'label_block' 	=> false,
                'description'   => 'Slide height transition duration (in ms). Note: only used if adaptiveHeight: true',
                'condition' => [
                    'wth_slider_adaptive_height' => 'true'
                ]
            ]
        );
        $this->add_control(
            'wth_slider_autoplay_start',
            [
                'label' => __( 'Autoplay Start', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'Auto show starts playing on load. If false, slideshow will start when the "Start" control is clicked',
            ]
        );
        $this->add_control(
            'wth_slider_autoplay_direction',
            [
                'label' => __( 'Autoplay Direction', 'wth' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'next',
				'options' => [
					'next'        => __( 'Next', 'wth' ),
					'prev'        => __( 'Prev', 'wth' ),
                ],
                'description'   => 'The direction of auto show slide transitions'
            ]
        );
        $this->add_control(
            'wth_slider_autoplay_hover',
            [
                'label' => __( 'Autoplay Start', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => false,
                'description'   => 'Auto show will pause when mouse hovers over slider',
            ]
        );
        $this->add_control(
            'wth_slider_min_slide',
            [
                'label'       	=> esc_html__( 'Min Slide', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 1,
                'label_block' 	=> false,
                'description'   => 'The minimum number of slides to be shown',
            ]
        );
        $this->add_control(
            'wth_slider_max_slide',
            [
                'label'       	=> esc_html__( 'Max Slide', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 1,
                'label_block' 	=> false,
                'description'   => 'The maximum number of slides to be shown',
            ]
        );
        $this->add_control(
            'wth_slider_controls',
            [
                'label' => __( 'Controls', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'If true, "Next" / "Prev" controls will be added',
            ]
        );
        $this->add_control(
            'wth_slider_keyboard_enable',
            [
                'label' => __( 'Keyboard Enable', 'wth' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'wth' ),
				'label_off' => __( 'Off', 'wth' ),
				'return_value' => true,
                'default' => true,
                'description'   => 'Allows for keyboard control of visible slider. Keypress ignored if slider not visible',
            ]
        );
  		$this->end_controls_section();
    }

	protected function render() {

   		$wth = $this->get_settings_for_display();
		   
		$this->add_render_attribute(
			'wth_bx_slider_options',
			[
				'id'                         => 'wth-bx-slider-'.$this->get_id(),
                'data-mode'                  => $wth['wth_slider_mode'],
                'data-caption'               => $wth['wth_slider_caption'],
                'data-speed'                 => $wth['wth_slider_speed'],
                'data-slide-margin'          => $wth['wth_slider_slide_margin'],
                'data-start-slide'           => $wth['wth_slider_start_slide'],
                'data-random-start'          => $wth['wth_slider_random_start'],
                'data-infinite-loop'         => $wth['wth_slider_infinite_loop'],
                'data-hide-ctrl-on-end'      => $wth['wth_slider_hide_ctrl_on_end'],
                'data-easing'                => $wth['wth_slider_easing'],
                'data-ticker'                => $wth['wth_slider_ticker'],
                'data-ticker-hover'          => $wth['wth_slider_ticker_hover'],
                'data-adaptive-height'       => $wth['wth_slider_adaptive_height'],
                'data-adaptive-height-speed' => $wth['wth_slider_adaptive_height_speed'],
                'data-auto'                  => $wth['wth_slider_autoplay'],
                'data-pause'                 => $wth['wth_slider_pause'],
                'data-auto-start'            => $wth['wth_slider_autoplay_start'],
                'data-auto-direction'        => $wth['wth_slider_autoplay_direction'],
                'data-auto-hover'            => $wth['wth_slider_autoplay_hover'],
                'data-min-lide'              => $wth['wth_slider_min_slide'],
                'data-max-slide'             => $wth['wth_slider_max_slide'],
                'data-controls'              => $wth['wth_slider_controls'],
                'data-keyboard-enable'       => $wth['wth_slider_keyboard_enable'],
                'data-pager'                 => $wth['wth_slider_pager'],
			]
		);
		
	?>
	<div class="wth-bx-slider" <?php echo $this->get_render_attribute_string( 'wth_bx_slider_options' ); ?>>
        <ul class="bxslider">
            <?php foreach( $wth['wth_slider_slides'] as $slide ) : ?>
                <li><img src="<?php echo esc_url( $slide['wth_slider_slide']['url'] ); ?>" title="<?php echo $slide['wth_slider_slide_content']; ?>" /></li>
            <?php endforeach; ?>
        </ul>
    </div>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WTH_BX_Slider() );