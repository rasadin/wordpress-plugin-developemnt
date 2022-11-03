<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_Carousel extends Widget_Base {

	public function get_name() {
		return 'webalive-carousel';
	}

	public function get_title() {
		return esc_html__( 'Webalive Carousel', 'loanone-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public-script'
        ];
    }

	public function get_icon() {
		return 'eicon-carousel';
	}

    public function get_categories() {
		return [ 'webalive-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
        $this->start_controls_section(
            'webalive_content_settings',
            [
                'label' => esc_html__( 'Content Settings', 'webalive-core' ),
            ]
        );
        $this->add_control(
			'webalive_slider_slides',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'webalive_slider_slide_title' => '#1 Slider Title One' ],
					[ 'webalive_slider_slide_title' => '#2 Slider Title Two' ],
					[ 'webalive_slider_slide_title' => '#3 Slider Title Three' ],
                ],
                'fields' => [
                    [
						'name' => 'webalive_slider_slide_title',
						'label' => esc_html__( 'Title', 'webalive-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( '#1 Slider Title', 'webalive-core' ),
						'label_block' => true,
                    ],
                    [
                        'name' => 'webalive_slider_slide',
                        'label' => esc_html__( 'Choose Image', 'webalive-core' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            // 'url' => \Elementor\Utils::get_placeholder_image_src(),
                            'url' => 'https://picsum.photos/1900/900/?image=430',
                        ],
                    ],
					[
                        'name' => 'webalive_slider_background_image',
                        'label' => esc_html__( 'Background Image', 'webalive-core' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => 'https://picsum.photos/1900/900/?image=430',
                        ],
                    ],
                    [
						'name' => 'webalive_slider_slide_content_title',
						'label' => esc_html__( 'Content Title', 'webalive-core' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Business Loan Australia', 'webalive-core' ),
						'label_block' => true,
                    ],
                    [
						'name' => 'webalive_slider_slide_content',
						'label' => esc_html__( 'Content', 'webalive-core' ),
						'type' => Controls_Manager::TEXTAREA,
						'default' => esc_html__( 'Funding your business has never been easier!', 'webalive-core' ),
						'condition' => [],
                    ],
                    [
                        'name' => 'webalive_slider_learn_more_link',
                        'label' => esc_html__( 'Learn More Link', 'webalive-core' ),
                        'type' => Controls_Manager::URL,
                        'placeholder' => esc_html__( 'https://your-link.com', 'webalive-core' ),
                        'show_external' => true,
                        'default' => [
                            'url' => 'https://your-link.com',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                        
                    ],
                ],
				'title_field' => '{{webalive_slider_slide_title}}',
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
			'webalive_hero_carousel_options',
			[
				'id'                         	=> 'webalive-carousel-'.$this->get_id(),
                // 'data-items'                 => $webalive['webalive_slide_item'],
                // 'data-autoplay'              => $webalive['webalive_slide_autoplay'],
                // 'data-stop-on-hover'         => $webalive['webalive_slide_autoplay_stop_on_hover'],
                // 'data-loop'                  => $webalive['webalive_slide_loop'],
                // 'data-nav'                   => $webalive['webalive_slide_nav'],
                // 'data-dot'                   => $webalive['webalive_slide_dot'],
                // 'data-mouse-drag'            => $webalive['webalive_slide_mouse_drag'],
                // 'data-touch-drag'            => $webalive['webalive_slide_touch_drag'],
                // 'data-autoplay-timeout'      => $webalive['webalive_slide_autoplay_timeout'],
                // 'data-animation-in'          => $webalive['webalive_slide_animate_in'],
                // 'data-animation-out'         => $webalive['webalive_slide_animate_out'],
                // 'data-caption-animation'     => $webalive['webalive_slide_caption_animation'],
                // 'data-nav-prev'     		 => $webalive['webalive_carousel_nav_prev_icon'],
                // 'data-nav-next'     		 => $webalive['webalive_carousel_nav_next_icon'],
			]
		);
    ?>



		<section class="swiper-container loading home-section <?php echo $this->get_render_attribute_string( 'webalive_hero_carousel_options' ); ?>">
			<div class="swiper-wrapper">
			<?php foreach($webalive['webalive_slider_slides'] as $slide) :
				?>
					<div class="swiper-slide" style="background-image:url(<?php echo esc_url( $slide['webalive_slider_background_image']['url'] ) ?>">
						<img src="<?php echo esc_url( $slide['webalive_slider_slide']['url'] ) ?>" class="entity-img" />
						<div class="content" data-swiper-parallax-opacity="0" data-swiper-parallax-scale="0.25">
							<h2 class="title" data-swiper-parallax="-20%" data-swiper-parallax-scale=".9"><?php echo $slide['webalive_slider_slide_content_title']; ?></h2>
							<a href="<?php echo esc_url($slide['webalive_slider_learn_more_link']['url']); ?>" class="btn ghost-btn" data-swiper-parallax="-20%">Read More</a>
							<div class="nav-sw">
								<div class="swiper-button-prev swiper-button-white">&nbsp;</div>
								<div class="swiper-pagination"></div>
								<div class="swiper-button-next swiper-button-white">&nbsp;</div>
							</div>
						</div>
					</div>
			<?php endforeach; ?>
			</div>
		</section>

	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_Carousel() );