<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.
class Widget_EV_Image_Change extends Widget_Base
{
    public function get_name()
    {
        return 'image-change-slider';
    }
    public function get_title()
    {
        return esc_html__('Image Change', 'eb-core');
    }
    public function get_script_depends()
    {
        return [
            'eb-public',
        ];
    }
    public function get_icon()
    {
        return 'eicon-slider-push';
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


        $this->add_control(
            'time', [
                'label' => __('Time ms(ex: 3000)', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('3000', 'eb-core'),
                'label_block' => true,
            ]
        );
 
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => __('Title', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Title Here', 'eb-core'),
                'label_block' => true,
            ]
        );

  
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);



        $this->add_control(
            'hero_slides',
            [
                'label' => __('Reviews Slider', 'eb-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Title', 'eb-core'),
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
    private function style_tab()
    {}
    protected function render()
    {
        $eb = $this->get_settings_for_display();
        $this->add_render_attribute(
            'webalive_project_showcase_options',
            [
                'id' => 'eb-project-shocase-' . $this->get_id(),
            ]
        );

        $rand =  rand(); 
        
        ?>


<!-- Add Markup Starts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet"/>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> -->




<input id="myField-<?php echo $rand; ?>" type="hidden" name="time" value="<?php echo $eb['time']; ?>"/>



    <div class="slick-carousel" id="<?php echo $rand; ?>">
        <?php foreach ($eb['hero_slides'] as $slide): ?>
            <div class="item">
                <div class="img-item">
                    <div class="image-slider-title"><?php echo $slide['title']; ?></div>
                    <img class="image-slider-img" src="<?php echo $slide['image']['url']; ?>">
                </div>
            </div>
        <?php endforeach;?>
 
  </div>


<style>
</style>





  
<!-- Add Markup Ends -->
        <?php
}
    protected function content_template()
    {}
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_EV_Image_Change());