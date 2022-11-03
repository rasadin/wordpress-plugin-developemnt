<?php
function viewbank_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
	require_once WAE_PLUGIN_PATH . '/elements/testimonial-slider.php';

	
}
add_action('elementor/widgets/widgets_registered','viewbank_elements_activator');