<?php 
namespace Elementor;

function Smsf_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'smsf-for-elementor',
        [
            'title'     => 'Smsf Custom Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\Smsf_elementor_init');