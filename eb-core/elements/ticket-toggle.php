<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.

class Widget_Event_Booking_Mobile_Toggle_2 extends Widget_Base
{

    public function get_name()
    {
        return 'eb-mobile-toggle-2';
    }

    public function get_title()
    {
        return esc_html__('EV Ticket Toggle', 'eb-core');
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
            'content',
            [
                'label' => __('Content', 'eb-core'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Default description', 'eb-core'),
                'placeholder' => __('Enter your description here', 'eb-core'),
            ]
        );

        $this->add_control(
            'eb_ticket_toggle',
            [
                'label' => __('EB', 'eb-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'main_title' => __('Ticket Toggle Title', 'eb-core'),
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


        <div id="ebaccordion" class="ticket-tab-container">
        <?php 
        $i = 0;
        foreach ($eb['eb_ticket_toggle'] as $slide) : ?>
        <div class="eb-accordion-ticket" id="ev-ticket-<?php echo $i ?>">
            <h4 class="ebaccordion-toggle-ticket" id="eb-to-<?php echo $i ?>">
                <span class="step step-t0">Step <?php echo $i+1; ?></span>
                <span class="ebtitle-t1"><?php echo $slide['main_title']; ?></span>
            </h4>
            <div class="ebaccordion-content-ticket"  id="eb-co-<?php echo $i ?>">
                <?php echo $slide['content']; ?>
            </div>
        </div>
            
        <?php 
        $i = $i + 1;
        endforeach; ?>
        </div>




        <script>
            jQuery(function($) {
                $('#ev-ticket-0').addClass('active-ticket');
                $('#eb-to-0').addClass('active');
                $('#eb-co-0').addClass('default');

                $('#ebaccordion').find('.ebaccordion-toggle-ticket').click(function(){
                // modified from union deisgn+code at http://uniondesign.ca/simple-ebaccordion-without-jquery-ui/
                // mc 4/2/2015
                //Expand or collapse this panel
                var isActive = $(this).hasClass("active");
                        $('.ebaccordion-toggle-ticket').removeClass('active')
                if (!isActive) {
                    $(this).toggleClass('active');
                }
                    

                var isActive = $(this).parent().hasClass("active-ticket");
                        $('.eb-accordion-ticket').removeClass('active-ticket');
                if (!isActive) {
                    $(this).parent().toggleClass('active-ticket');
                }



                $(this).next().slideToggle('fast');     
                //Hide the other panels
                $(".ebaccordion-content-ticket").not($(this).next()).slideUp('fast');

                });
            });
        </script>

        <!-- Add Markup Ends -->
<?php
    }

    protected function content_template()
    {
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_Event_Booking_Mobile_Toggle_2());
