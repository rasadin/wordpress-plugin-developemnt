<?php 
namespace Elementor;
function wcc_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'wcc-for-elementor',
        [
            'title'     => 'WCC Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\wcc_elementor_init');