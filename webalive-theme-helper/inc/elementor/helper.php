<?php
namespace Elementor;

function wth_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'wth-elements-elementor',
        [
            'title'  => 'Webalive Elements for Elementor',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\wth_elementor_init');