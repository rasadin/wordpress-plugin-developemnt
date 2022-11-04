<?php 
namespace Elementor;

function mmvc_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'shb-for-elementor',
        [
            'title'     => 'SHB Custom Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\mmvc_elementor_init');