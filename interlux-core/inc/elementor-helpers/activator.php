<?php
function montpellier_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/interlux-slider.php';
	require_once WAE_PLUGIN_PATH . '/elements/page-header.php';
	// require_once WAE_PLUGIN_PATH . '/elements/team-member.php';
	require_once WAE_PLUGIN_PATH . '/elements/reviews-slider.php';
	// require_once WAE_PLUGIN_PATH . '/elements/dance-classes.php';
	require_once WAE_PLUGIN_PATH . '/elements/faq-acc.php';

	
}
add_action('elementor/widgets/widgets_registered','montpellier_elements_activator');