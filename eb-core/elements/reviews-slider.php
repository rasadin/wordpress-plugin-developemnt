<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.
class Widget_EV_Reviews_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'eb-reviews-slider';
    }
    public function get_title()
    {
        return esc_html__('Reviews Slider', 'eb-core');
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
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'client_name', [
                'label' => __('Client Name', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Client Name Here', 'eb-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'client_designation', [
                'label' => __('Client Designation', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Designation Here', 'eb-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'discription', [
                'label' => __('Description', 'eb-core'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Enter Description Text Here', 'eb-core'),
                'label_block' => true,
            ]
        );



        $repeater->add_control(
			'show_elements',
			[
				'label' => esc_html__( 'Stars', 'eb-core' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'three-stars'  => esc_html__( 'Three Stars', 'eb-core' ),
					'four-stars' => esc_html__( 'Four Stars', 'eb-core' ),
					'five-stars' => esc_html__( 'Five Stars', 'eb-core' ),
				],
				'default' => 'five-stars',
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
                        'client_name' => __('Client Name', 'eb-core'),
                    ],
                ],
                'title_field' => '{{{ client_name }}}',
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
        ?>
<!-- Add Markup Starts -->

<section class="carousel-section rev-section">
  <div class="carousel-container">
    <div class="owl-carousel owl-theme">
        <?php foreach ($eb['hero_slides'] as $slide): ?>
        <div class="item rev-item">
            <div class="carousel-item__card">
                <div class="client-star <?php echo $slide['show_elements']; ?>"><?php echo $slide['show_elements']; ?></div>
                <div class="client-dis"><?php echo $slide['discription']; ?></div>
                <div class="client-name-desi">
                    <div class="client-name"><?php echo $slide['client_name']; ?></div>
                    <div class="client-desi"><?php echo $slide['client_designation']; ?></div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
  </div>
</section>






  
<!-- Add Markup Ends -->
        <?php
}
    protected function content_template()
    {}
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_EV_Reviews_Slider());