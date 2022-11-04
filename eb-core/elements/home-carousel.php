<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Widget_Power_Home_Reviews_Carousel extends Widget_Base {
    public function get_name() {
        return 'eb-home-carousel';
    }
    public function get_title() {
        return esc_html__( 'Home Carousel', 'eb-core' );
    }
    public function get_script_depends() {
        return [
            'eb-public'
        ];
    }
    public function get_icon() {
        return 'fa fa-slideshare';
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
        $repeater = new \Elementor\Repeater();
//        $repeater->add_control(
//            'uptext', [
//                'label' => __( 'Uper Text', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::TEXT,
//                'default' => __( 'Enter Uper Text Here' , 'eb-core' ),
//                'label_block' => true,
//            ]
//        );
        $repeater->add_control(
            'subtext', [
                'label' => __( 'Sub text', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Enter Sub Text Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );

//        $repeater->add_control(
//            'upyear', [
//                'label' => __( 'Uper Year', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::TEXT,
//                'default' => __( 'Enter Uper Year Here' , 'eb-core' ),
//                'label_block' => true,
//            ]
//        );
        $repeater->add_control(
            'title', [
                'label' => __( 'Title', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Enter Title Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'video_embedded', [
                'label' => __( 'Enter Embeded Code Here', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'cta_name', [
                'label' => __( 'Button Text', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Read More' , 'eb-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'cta_link', [
                'label' => __( 'Button Link', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'eb-core' ),
                'show_external' => false,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => true,
                ],
            ]
        );

        // $repeater->add_control(
		// 	'youtube_video_url_id',
		// 	[
		// 		'label' => __( 'YouTube Video URL ID', 'sharecare-core' ),
		// 		'type' => \Elementor\Controls_Manager::TEXTAREA,
		// 		// 'default' => __( 'Default title', 'sharecare-core' ),
		// 		'placeholder' => __( 'Enter Video Id Here. Ex: URL: https://www.youtube.com/watch?v=FsAfZxyw3r0 => ID:FsAfZxyw3r0  ', 'sharecare-core' ),
		// 	]
        // );
        

        // $repeater->add_control(
		// 	'you-image',
		// 	[
		// 		'label' => __( 'Choose Image for Youtube', 'eb-core' ),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 		'default' => [
		// 			'url' => \Elementor\Utils::get_placeholder_image_src(),
		// 		],
		// 	]
		// );



        $this->add_control(
            'hero_slides',
            [
                'label' => __( 'EventBookings Home Slides', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __( 'Carousel Title #1', 'eb-core' ),
                    ],
                ],
                'title_field' => '{{{ title }}}',
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
        $eb = $this->get_settings_for_display();
        $this->add_render_attribute(
            'webalive_project_showcase_options',
            [
                'id' => 'eb-project-shocase-'.$this->get_id(),
            ]
        );
        ?>
        <!-- Add Markup Starts -->
        <div class = "hero-slide-show">
            <div class="owl-carousel owl-theme">
                <?php foreach( $eb['hero_slides'] as $slide ) :
                    $target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                    <div class="item">
                        <div class="slider-item">
                            <div class="info-container">
                                <div class="uper-text-title">
                                    <div class="uper-text"><?php //echo $slide['uptext']; ?></div>
                                    <div class="uper-year"><?php //echo $slide['upyear']; ?></div>
                                </div>
                                <div class="image-text-detail">
                                    <h1 class="image-text-title"><?php echo $slide['title']; ?></h1>
                                    <p class="image-subtext-title m-0"><?php echo $slide['subtext']; ?></p>
                                    <div class="image-text-btn"><a href="<?php echo esc_url($slide['cta_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>><?php echo $slide['cta_name']; ?></a></div>
                                </div>
                            </div>

                            <div class="video-content-block">
                                <?php if($slide['image']['url'] != null && $slide['video_embedded'] == null){ ?>
                                    <div class="banner-img"> <img src="<?php  echo esc_url($slide['image']['url']) ?>" alt="" /></div>
                                <?php } ?>


                                <?php if($slide['video_embedded'] != null){ ?>
                                    <?php echo $slide['video_embedded']; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Add Markup Ends -->
        <?php
    }
    protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Power_Home_Reviews_Carousel() );