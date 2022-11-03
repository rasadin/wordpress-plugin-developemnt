<?php 
namespace Elementor;

function loanone_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'webalive-for-elementor',
        [
            'title'  => 'WeAlive Elements',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\loanone_elementor_init');