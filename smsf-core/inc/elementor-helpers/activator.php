<?php
function Smsf_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
	// require_once WAE_PLUGIN_PATH . '/elements/doctor-slider.php';
}
add_action('elementor/widgets/widgets_registered','Smsf_elements_activator');