<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.
class Widget_Product_API_ACC extends Widget_Base
{
    public function get_name()
    {
        return 'product-api-acc';
    }
    public function get_title()
    {
        return esc_html__('EB Org API List', 'apihub-core');
    }
    public function get_script_depends()
    {
        return [
            'apihub-public',
        ];
    }
    public function get_icon()
    {
        return 'eicon-accordion';
    }
    public function get_categories()
    {
        return ['apihub-for-elementor'];
    }
    protected function _register_controls()
    {
        /**
         * Content Settings
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content Settings', 'apihub-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
            'method', [
                'label' => __('Method', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Method', 'apihub-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'main_title', [
                'label' => __('Accordion Title', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Enter Title Here', 'apihub-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'accordian_serial', [
                'label' => __('Accordian Number', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('545', 'apihub-core'),
                'label_block' => true,
            ]
        );



        $repeater->add_control(
            'shortcode-1', [
                'label' => __('Shortcode 1', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('[shortcode-1]', 'apihub-core'),
                'label_block' => true,
            ]
        );



 
        $repeater->add_control(
            'shortcode-2', [
                'label' => __('Enter Default Output Code Here', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default Outout For This API', 'apihub-core'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'hero_slides',
            [
                'label' => __('API Accordion', 'apihub-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_title' => __('Accordion Title', 'apihub-core'),
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
<div id="product-accordion" class="commomn-api">
    <ul>
        <?php foreach ($eb['hero_slides'] as $slide): ?>
            <li class="title-tog <?php echo do_shortcode(strtolower($slide['method'])); ?>">
                <a href="#<?php echo $slide['accordian_serial']; ?>" id="ti-<?php echo $slide['accordian_serial']; ?>"><span class="method-res"><?php echo do_shortcode($slide['method']); ?></span><span class="method-ti"><?php echo $slide['main_title']; ?></span></a>
                <div id="<?php echo $slide['accordian_serial']; ?>" class="accordion">
                <div class="try-or-cancel" style="display:none;">
                        <div class="try-it" id="try-<?php echo $slide['accordian_serial']; ?>">Try It Now</div>
                        <div class="auth-it" id="go-to-auth-form" data-toggle="modal" data-target="#exampleModalLong">Authorize</div>
                        <div class="cancel-ex" style="display:none;" id="can-<?php echo $slide['accordian_serial']; ?>">Cancel</div>
                    </div>                
                    <div class="result-shortcode" style="display:none;" id="result1-<?php echo $slide['accordian_serial']; ?>">                            <?php echo do_shortcode($slide['shortcode-1']); ?>
                        </div>
                        <div class="result-shortcode-2" style="display:none;" id="res-<?php echo $slide['accordian_serial']; ?>">
                            <div class="response-btn">Example Response</div>
                                <table class="exam-response-tb">
                                    <tr>
                                        <th>Code</th>
                                        <th>Description	</th>
                                        <th>Links</th>
                                    </tr>
                                    <tr>
                                        <td>200</td>
                                        <td>
                                        OK - return response
                                        <div class="scrollable-content">
                                            <pre class="response" name="response"><?php echo do_shortcode($slide['shortcode-2']); ?></pre>
                                        </div>
                                        </td>
                                        <td>No links</td>
                                    </tr>
                                    <tr>
                                        <td>400</td>
                                        <td>Request could not be understood</td>
                                        <td>No links</td>
                                    </tr>
                                    <tr>
                                        <td>401</td>
                                        <td>Unauthorized access</td>
                                        <td>No links</td>
                                    </tr>
                                    <tr>
                                        <td>403</td>
                                        <td>Permission to access resource denied</td>
                                        <td>No links</td>
                                    </tr>
                                </table>
                        </div>  
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

Plugin::instance()->widgets_manager->register_widget_type(new Widget_Product_API_ACC());