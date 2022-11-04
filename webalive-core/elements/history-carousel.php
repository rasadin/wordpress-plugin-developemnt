<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_History_Carousel extends Widget_Base {

	public function get_name() {
		return 'webalive-history-carousel';
	}

	public function get_title() {
		return esc_html__( 'History Carousel', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-book-open';
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
        
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'year', [
				'label'         => __( 'Year', 'webalive2019-core' ),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'label_block'   => true,
			]
        );
        $repeater->add_control(
			'year_content', [
				'label' => __( 'Content', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'show_label' => true,
			]
        );
        $repeater->add_control(
			'image', [
				'label' => __( 'Image', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
        );
        $this->add_control(
			'history_slides',
			[
				'label' => __( 'History Slides', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'year' => __( '2003', 'webalive2019-core' ),
						'year_content' => __( 'Item content. Click the edit button to change this text.', 'webalive2019-core' ),
					],
				],
				'title_field' => '{{{ year }}}',
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
		$year = [];
		foreach( $webalive['history_slides'] as $year ) {
			$years[] = $year['year'];
		}
		$year_string = implode(', ', $years);

		$this->add_render_attribute(
			'webalive_history_carousel_options',
			[
				'id' => 'webalive-history-carousel-'.$this->get_id(),
				'years' => $year_string,
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="history-block">
            <div class="arrow-block">
                <div class="history-pagination">
					<span class="current">01</span><span>/</span><span>0<?php echo count($webalive['history_slides']); ?></span>
				</div>
                <div class="history-line"></div>
                <button title="Next" class="top-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11.5" height="14.684" viewBox="0 0 11.5 14.684">
                        <g id="about-arrow-up" transform="translate(11.5 14.684) rotate(180)">
                            <path id="Path_20" data-name="Path 20" d="M11.5,8.934,10.371,7.79,6.554,11.608V0H4.946V11.608L1.128,7.79,0,8.934l5.75,5.75Z" transform="translate(0)"/>
                        </g>
                    </svg>
                </button>
                <button title="Previous" data-role="none" class="bottom-arrow" aria-label="Next" role="button" aria-disabled="false">
                    <svg id="about-arrow-down" xmlns="http://www.w3.org/2000/svg" width="11.5" height="14.684" viewBox="0 0 11.5 14.684">
                        <path id="Path_20" data-name="Path 20" d="M24.3,11.434,23.171,10.29l-3.818,3.818V2.5H17.746V14.108L13.928,10.29,12.8,11.434l5.75,5.75Z" transform="translate(-12.8 -2.5)"/>
                    </svg>
                </button>
            </div>
            <div class="history-year">
                <ul class="year">
                    <?php foreach( $webalive['history_slides'] as $key=>$slide ) : ?>
                        <li class="<?php if($key == 0) : echo 'current'; endif; ?>" data-year="<?php echo esc_attr($slide['year']); ?>"><?php echo $slide['year'];?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="slick-carousel history-carousel" <?php echo $this->get_render_attribute_string( 'webalive_history_carousel_options' ); ?>>
                <?php foreach( $webalive['history_slides'] as $slide ) : ?>
                <div class="item" data-year="<?php echo esc_attr($slide['year']); ?>">
                    <p><?php echo $slide['year_content']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_History_Carousel() );