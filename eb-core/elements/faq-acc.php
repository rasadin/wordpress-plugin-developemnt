<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.
class Widget_EV_FAQ_ACC extends Widget_Base
{
    public function get_name()
    {
        return 'eb-faq-acc';
    }
    public function get_title()
    {
        return esc_html__('FAQ Accordion', 'eb-core');
    }
    public function get_script_depends()
    {
        return [
            'eb-public',
        ];
    }
    public function get_icon()
    {
        return 'fa fa-slideshare';
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
            'main_title', [
                'label' => __('Accordion Title', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Title Here', 'eb-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'accordian_serial', [
                'label' => __('Accordian Number', 'eb-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('545', 'eb-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'discription', [
                'label' => __('Accordion Description', 'eb-core'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Enter Description Text Here', 'eb-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'hero_slides',
            [
                'label' => __('EB FAQ Accordion', 'eb-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_title' => __('Accordion Title', 'eb-core'),
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
<div id="accordion">
    <ul>
        <?php foreach ($eb['hero_slides'] as $slide): ?>
            <li class="title-tog">
                <a href="#<?php echo $slide['accordian_serial']; ?>"><?php echo $slide['main_title']; ?></a>
                <div id="<?php echo $slide['accordian_serial']; ?>" class="accordion">
                <?php echo $slide['discription']; ?>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
</div>

<!-- Add Markup Ends -->
        <?php
}
    protected function content_template()
    {}
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_EV_FAQ_ACC());