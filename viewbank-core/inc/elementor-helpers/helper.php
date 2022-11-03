<?php 
namespace Elementor;

function viewbank_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'viewbank-for-elementor',
        [
            'title'     => 'ViewBank Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\viewbank_elementor_init');