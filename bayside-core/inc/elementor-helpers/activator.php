<?php
function bayside_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/hero-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/logo-slider.php';
	require_once WAE_PLUGIN_PATH . '/elements/cost-slider.php';
	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
}
add_action('elementor/widgets/widgets_registered','bayside_elements_activator');