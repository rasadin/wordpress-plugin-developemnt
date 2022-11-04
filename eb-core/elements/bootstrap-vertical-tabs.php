<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.

class Widget_Event_Booking_Boot_Vertical_Tab extends Widget_Base
{

    public function get_name()
    {
        return 'eb-boot-vertical-tab';
    }

    public function get_title()
    {
        return esc_html__('EV BT Vertical Tab', 'eb-core');
    }

    public function get_script_depends()
    {
        return [
            'eb-public',
        ];
    }

    public function get_icon()
    {
        return 'fa fa-ellipsis-v';
    }

    public function get_categories()
    {
        return ['eb-for-elementor'];
    }

    protected function register_controls()
    {
        /**
         * Content Settings
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content Settings', 'eb-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'main_title',
            [
                'label' => __('Main Title', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Main Title Here', 'eb-core'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
			'image',
			[
				'label' => __( 'Enter Title Icon', 'eb-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater->add_control(
            'discription',
            [
                'label' => __('Title Description', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Enter Title Description Text Here', 'eb-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __('Content', 'eb-core'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Default description', 'eb-core'),
                'placeholder' => __('Type your description here', 'eb-core'),
            ]
        );

        $this->add_control(
            'eb_vertical_tab',
            [
                'label' => __('EB Virtical Tab', 'eb-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_title' => __('Tab Title', 'eb-core'),
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

    private function style_tab()
    {
    }

    protected function render()
    {
        $eb = $this->get_settings_for_display();
        $this->add_render_attribute(
            'webalive_project_showcase_options',
            [
                'id' => 'eb-project-shocase-' . $this->get_id(),
            ]
        );
?>
        <!-- Add Markup Starts -->


        <div class="row">
            <div class="col-5">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <?php foreach ($eb['eb_vertical_tab'] as $slide) : ?>
                        <a class="nav-link" id="v-pills-<?php echo $slide['_id']; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $slide['_id']; ?>" role="tab" aria-controls="v-pills-<?php echo $slide['_id']; ?>" aria-selected="">
                            <div class="nav-heading"><span class="t0"><img src="<?php echo esc_url($slide['image']['url']) ?>" alt="this is title icon" /></span><h4 class="t1"><?php echo $slide['main_title']; ?> </h4></div>                            
                            <p class="t2"> <?php echo $slide['discription']; ?> </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-7">
                <div class="tab-content" id="v-pills-tabContent">
                    <?php foreach ($eb['eb_vertical_tab'] as $slide) : ?>
                        <div class="tab-pane fade" id="v-pills-<?php echo $slide['_id']; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $slide['_id']; ?>-tab">
                            <?php echo $slide['content']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <style>
            /* .fade { */
                /* -webkit-transition-duration: 1s; */
                /* Safari */
                /* transition-duration: 1s; */
            /* } */
        </style>

        <script>
            jQuery(function($) {
                $('#v-pills-tabContent > .tab-pane').eq(0).addClass("show active");
                $('#v-pills-tab > .nav-link').eq(0).addClass("active");
                $('#v-pills-tab > .nav-link').attr('aria-selected', 'false');
                $('#v-pills-tab > .nav-link').eq(0).attr('aria-selected', 'true');
            });
        </script>

        <!-- Add Markup Ends -->
<?php
    }

    protected function content_template()
    {
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_Event_Booking_Boot_Vertical_Tab());
