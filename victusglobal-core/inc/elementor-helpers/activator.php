<?php
function victusglobal_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/hero-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/logo-slider.php';
	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
}
add_action('elementor/widgets/widgets_registered','victusglobal_elements_activator');