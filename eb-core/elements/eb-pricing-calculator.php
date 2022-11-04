<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.

class Widget_Event_Booking_Pricing_Calculator extends Widget_Base
{

    public function get_name()
    {
        return 'eb-pricing-calculator';
    }

    public function get_title()
    {
        return esc_html__('Pricing Calculator', 'eb-core');
    }

    public function get_script_depends()
    {
        return [
            'eb-public',
        ];
    }

    public function get_icon()
    {
        return 'fas fa-calculator';
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
        $this->add_control(
            'eb_vertical_tab',
            [
                'label' => __('EB Pricing Tab', 'eb-core'),
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
            <div class="col-lg-7 col-sm-12">
                <div class="ranger-slieds">
                    <!-- Entry Fee  -->

                    <div class="range-slider entry-fee-slide">
                        <div class="slider-label">Average Entry Fee </div>
                        <input id="first_field" class="range-slider__range" type="range" value="100" min="50" max="1500">
                        <!-- <span class="range-dollar">$</span> -->
                        <span class="range-slider__value1 range-value">$100.00</span>
                    </div>


                    <!-- Attendees Per Event  -->
                    <div class="range-slider per-event-slide">
                        <div class="slider-label">Attendees Per Event </div>
                        <input id="second_field" class="range-slider__range" type="range" value="100" min="100" max="450">
                        <span class="range-slider__value2 range-value">0</span>
                    </div>


                    <!-- Events Per Year  -->
                    <div class="range-slider events-year-slide">
                        <div class="slider-label">Events Per Year </div>
                        <input id="third_field" class="range-slider__range" type="range" value="12" min="4" max="12">
                        <span class="range-slider__value2 range-value">0</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div id="total-dynamic-value-js" class="total-dynamic-value">
                    <div class="total1">Total Savings</div>
                    <div class="total_save">
                        <span class="total2"></span>
                        <span class="total3">/year</span>
                    </div>
                    <div class="total_save_5">
                        <span class="total4">or</span>
                        <span class="total5"></span>
                        <span class="total6">every 5 years</span>
                    </div>
                </div>
            </div>

        </div>

        <div id="vs-dynamic-value-js" class="vs-dynamic-value">

            <div class="vs_save_1">See how EventBookings compares to the others</div>

            <div class="values">
                <div class="vs_save_2">
                    <div class="vs1 title">VS EventBrite Pro</div>
                    <div class="vs2 amount yellow"></div>
                    <div class="vs3 per-yr">Savings per year</div>
                    <div class="vs-z1 per-yr-zm">(excluding ZOOM fee)</div>
                </div>

                <div class="vs_save_3">
                    <div class="vs4 title">VS Hoping Starter</div>
                    <div class="vs5 amount theme"></div>
                    <div class="vs6 per-yr">Savings per year</div>
                </div>

                <div class="vs_save_4">
                    <div class="vs7 title">VS Run The World Pro</div>
                    <div class="vs8 amount green"></div>
                    <div class="vs9 per-yr">Savings per year</div>
                </div>
            </div>

        </div>


        <script>
            jQuery(function($) {

                const settings = {
                    fill: '#22B0AF',
                    background: '#EDEDED'
                }
                const sliders = document.querySelectorAll('.range-slider');

                Array.prototype.forEach.call(sliders, (slider) => {
                    slider.querySelector('input').addEventListener('input', (event) => {
                        // slider.querySelector('span').innerHTML = event.target.value;
                        applyFill(event.target);
                    });
                    applyFill(slider.querySelector('input'));
                });

                function applyFill(slider) {
                    const percentage = 100 * (slider.value - slider.min) / (slider.max - slider.min);
                    const bg = `linear-gradient(90deg, ${settings.fill} ${percentage}%, ${settings.background} ${percentage+0.1}%)`;
                    slider.style.background = bg;
                }




                //Start--> Main Calculator <-- Start//
                // Event booking total Equation
                // var eb_subscription_fee = 99;
                var eb_subscription_fee = 0;
                var f1 = 0.3 * $("#second_field").val() * $("#third_field").val();
                var f2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                var f3 = eb_subscription_fee * 11;
                var f4 = (3.4 * f2) / 100;
                var eb_total = f1 + f4 + f3;


                // Eventbrite Professional
                // var brite_subscription_fee = 56;
                var brite_subscription_fee = 0;
                // var z1 = 3.09 * $("#second_field").val() * $("#third_field").val();
                var z1 = 0.99 * $("#second_field").val() * $("#third_field").val();
                var z2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                var z3 = brite_subscription_fee * 12;
                // var z4 = (3.5 * z2) / 100;
                var z4 = (5 * z2) / 100;
                var brite_total = z1 + z4 + z3;


                // Hoping Starter
                var hoping_subscription_fee = 99;
                var k2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                var k3 = hoping_subscription_fee * 12;
                var k4 = (7 * k2) / 100;
                var hoping_total = k4 + k3;


                // Run The World Professional
                var run_subscription_fee = 79;
                var r2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                var r3 = run_subscription_fee * 12;
                var r4 = (15 * r2) / 100;
                var run_total = r4 + r3;



                var vs_eventbrite_pro_savings = Math.ceil(brite_total - eb_total);
                var vs_hoping_pro_savings = Math.ceil(hoping_total - eb_total);
                var vs_run_pro_savings = Math.ceil(run_total - eb_total);
                $(".vs2").html('$' + vs_eventbrite_pro_savings);
                $(".vs5").html('$' + vs_hoping_pro_savings);
                $(".vs8").html('$' + vs_run_pro_savings);




                var numbers_array = [vs_eventbrite_pro_savings, vs_hoping_pro_savings, vs_run_pro_savings];
                var biggest = Math.max.apply(Math, numbers_array);
                var lowest = Math.min.apply(Math, numbers_array);
                var biggest5 = biggest * 5;
                var lowest5 = lowest * 5;
                $(".total2").html('$' + lowest + ' - ' + '$' + biggest);
                $(".total5").html('$' + lowest5 + ' - ' + '$' + biggest5);
                //End--> Main Calculator <-- End//


                var rangeSlider = function() {
                    var slider = $('.range-slider'),
                        range = $('.range-slider__range'),
                        value = $('.range-slider__value2');

                    slider.each(function() {
                        value.each(function() {
                            var value = $(this).prev().attr('value');
                            $(this).html(value);
                        });

                        range.on('input', function() {
                            // $(this).next(value).html(this.value);
                            $(this).nextAll(".range-slider__value1").html("$" + this.value + ".00");
                            $(this).nextAll(".range-slider__value2").html(this.value);



                            //Start--> Main Calculator <-- Start//
                            // Event booking total Equation
                            // var eb_subscription_fee = 99;
                            var eb_subscription_fee = 0;
                            var f1 = 0.3 * $("#second_field").val() * $("#third_field").val();
                            var f2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                            var f3 = eb_subscription_fee * 11;
                            var f4 = (3.4 * f2) / 100;
                            var eb_total = f1 + f4 + f3;


                            // Eventbrite Professional
                            // var brite_subscription_fee = 56;
                            var brite_subscription_fee = 0;
                            // var z1 = 3.09 * $("#second_field").val() * $("#third_field").val();
                            var z1 = 0.99 * $("#second_field").val() * $("#third_field").val();
                            var z2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                            var z3 = brite_subscription_fee * 12;
                            // var z4 = (3.5 * z2) / 100;
                            var z4 = (5 * z2) / 100;
                            var brite_total = z1 + z4 + z3;


                            // Hoping Starter
                            var hoping_subscription_fee = 99;
                            var k2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                            var k3 = hoping_subscription_fee * 12;
                            var k4 = (7 * k2) / 100;
                            var hoping_total = k4 + k3;


                            // Run The World Professional
                            var run_subscription_fee = 79;
                            var r2 = $("#first_field").val() * $("#second_field").val() * $("#third_field").val();
                            var r3 = run_subscription_fee * 12;
                            var r4 = (15 * r2) / 100;
                            var run_total = r4 + r3;



                            var vs_eventbrite_pro_savings = Math.ceil(brite_total - eb_total);
                            var vs_hoping_pro_savings = Math.ceil(hoping_total - eb_total);
                            var vs_run_pro_savings = Math.ceil(run_total - eb_total);
                            $(".vs2").html('$' + vs_eventbrite_pro_savings);
                            $(".vs5").html('$' + vs_hoping_pro_savings);
                            $(".vs8").html('$' + vs_run_pro_savings);




                            var numbers_array = [vs_eventbrite_pro_savings, vs_hoping_pro_savings, vs_run_pro_savings];
                            var biggest = Math.max.apply(Math, numbers_array);
                            var lowest = Math.min.apply(Math, numbers_array);
                            var biggest5 = biggest * 5;
                            var lowest5 = lowest * 5;
                            $(".total2").html('$' + lowest + ' - ' + '$' + biggest);
                            $(".total5").html('$' + lowest5 + ' - ' + '$' + biggest5);
                            //End--> Main Calculator <-- End//



                        });
                    });
                };

                rangeSlider();
            });
        </script>

        <!-- Add Markup Ends -->
        <?php
    }

    protected function content_template()
    {
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Widget_Event_Booking_Pricing_Calculator());
