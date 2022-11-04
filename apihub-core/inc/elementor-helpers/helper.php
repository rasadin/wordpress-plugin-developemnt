<?php 
namespace Elementor;

function eb_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'apihub-for-elementor',
        [
            'title'     => 'API HUB CUSTOM ELEMENTS',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\eb_elementor_init');