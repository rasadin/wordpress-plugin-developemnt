<?php 
namespace Elementor;

function montpellier_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'interlux-for-elementor',
        [
            'title'     => 'Interlux Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\montpellier_elementor_init');