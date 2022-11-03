<?php 
namespace Elementor;

function bayside_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'bayside-for-elementor',
        [
            'title'     => 'Fast track Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\bayside_elementor_init');