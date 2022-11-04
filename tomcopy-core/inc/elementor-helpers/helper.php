<?php 
namespace Elementor;

function tomcopy_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'tomcopy-for-elementor',
        [
            'title'     => 'Tomcopy Custom Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\tomcopy_elementor_init');