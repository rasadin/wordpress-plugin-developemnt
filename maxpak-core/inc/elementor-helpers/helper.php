<?php 
namespace Elementor;

function maxpak_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'maxpak-for-elementor',
        [
            'title'     => 'maxpak Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\maxpak_elementor_init');