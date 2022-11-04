<?php
function mmvc_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/hero-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
	require_once WAE_PLUGIN_PATH . '/elements/player-slider.php';
	
}
add_action('elementor/widgets/widgets_registered','mmvc_elements_activator');