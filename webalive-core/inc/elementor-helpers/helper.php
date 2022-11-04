<?php 
namespace Elementor;

function webalive_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'webalive-for-elementor',
        [
            'title'     => 'WebAlive Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\webalive_elementor_init');