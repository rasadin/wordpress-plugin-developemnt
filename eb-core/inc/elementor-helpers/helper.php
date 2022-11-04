<?php 
namespace Elementor;

function eb_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'eb-for-elementor',
        [
            'title'     => 'EB Custom Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\eb_elementor_init');