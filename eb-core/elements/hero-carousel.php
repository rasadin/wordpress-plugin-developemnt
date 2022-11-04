<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Widget_EV_Image_Text_Carousel extends Widget_Base {
    public function get_name() {
        return 'eb-hero-carousel';
    }
    public function get_title() {
        return esc_html__( 'Main Advanced Carousel', 'eb-core' );
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
        $repeater->add_control(
            'upper_title', [
                'label' => __( 'Upper Title', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Enter Upper Title Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'main_title', [
                'label' => __( 'Main Title', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Enter Main Title Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'dis_title', [
                'label' => __( 'Title Description', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Enter Title Description Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );
//        $repeater->add_control(
//            'image',
//            [
//                'label' => __( 'Choose Title Icon', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::MEDIA,
//                'default' => [
//                    'url' => \Elementor\Utils::get_placeholder_image_src(),
//                ],
//            ]
//        );

        $repeater->add_control(
            'discription', [
                'label' => __( 'Description', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Enter Description Text Here' , 'eb-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'editor', [
                'label' => __( 'Editor', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Enter Content here' , 'eb-core' ),
                'label_block' => true,
            ]
        );

//        $repeater->add_control(
//            'cta_name', [
//                'label' => __( 'Button Text', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::TEXT,
//                'default' => __( 'Learn More' , 'eb-core' ),
//                'label_block' => true,
//            ]
//        );
//        $repeater->add_control(
//            'cta_link', [
//                'label' => __( 'Button Link', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::URL,
//                'placeholder' => __( 'https://your-link.com', 'eb-core' ),
//                'show_external' => false,
//                'default' => [
//                    'url' => '',
//                    'is_external' => false,
//                    'nofollow' => true,
//                ],
//            ]
//        );
//        $repeater->add_control(
//            'cta_link_scroll', [
//                'label' => __( 'Scroll Link', 'eb-core' ),
//                'type' => \Elementor\Controls_Manager::URL,
//                'placeholder' => __( 'https://your-link.com', 'eb-core' ),
//                'show_external' => false,
//                'default' => [
//                    'url' => '',
//                    'is_external' => false,
//                    'nofollow' => true,
//                ],
//            ]
//        );
        $this->add_control(
            'hero_slides',
            [
                'label' => __( 'Victus Global Image Text Slides', 'eb-core' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_title' => __( 'Carousel Title', 'eb-core' ),
                    ],
                ],
                'title_field' => '{{{ main_title }}}',
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
        <div class = "hero-home-slide-show">
            <div class="homeSliderOwl owl-carousel owl-theme" id="homeSliderOwlJs">
                <?php foreach( $eb['hero_slides'] as $slide ) :
                    //$target = $slide['cta_link']['is_external'] ? ' target="_blank"' : '';
                    //$nofollow = $slide['cta_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                    <div class="item" data-dot="<button class='eb-owl-btnall'>
                    <button class='slider-upper-title'><?php echo $slide['upper_title']; ?></button>
<!--                     <button class='slider-img-title'>-->
<!--                          <img class='eb-slider-icon' src='--><?php //echo esc_url($slide['image']['url']) ?><!--' alt='slider title logo' />-->
<!--                    </button>-->

                    <button class='slider-mid-title'><?php echo $slide['main_title']; ?></button>
                    <button class='slider-dis-title'><?php echo $slide['dis_title']; ?></button>

                       </button>">
                        <div class="main-home-slider-part">
                            <div class="row">
                                <div class="col-5">
                                    <div class="slide-text-detaile">
                                        <!--
                                        <div class="slider-number-title"></div> -->
                                        <h4 class="slider-main-title"><?php echo $slide['main_title']; ?></h4>
                                        <p class="slider-text-dis"><?php echo $slide['discription']; ?></p>

                                        <!-- <div class="slider-text-btn"><a href="--><?php //echo esc_url($slide['cta_link']['url']); ?><!--"--><?php //echo $target; ?><!-- --><?php //echo $nofollow; ?><!--<?php //echo $slide['cta_name']; ?></a></div>-->

                                        </div>
                                </div>
                                <div class="col-7">
                                    <div class="slider-home-img">
                                        <?php echo $slide['editor']; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- <div class="total-count-part">
                <span class="current"></span>
                <span class="divider">/</span>
                <span class="total"></span>
            </div> -->
            <style>
                .homeSliderOwl {
                    height: auto;
                    margin: 10px auto;
                }
                .homeSliderOwl .item {
                    height: auto;
                    width: 100%;
                }
                .homeSliderOwl .item img {
                    height: auto;
                    max-width: 100%;
                }
                .owl-dots .owl-dot {
                    margin: 0px 5px;
                }
                .owl-dots .owl-dot button {
                    cursor: pointer;
                }
                .owl-dots .owl-dot button:focus {
                    outline: none;
                }
                .owl-dots .owl-dot.active button {
                }
                .owl-theme .owl-dots .owl-dot {
                    margin-right: 10px;
                }
            </style>
        </div>
        <!-- Add Markup Ends -->
        <?php
    }
    protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_EV_Image_Text_Carousel() );