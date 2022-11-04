<?php
function mmvc_elements_activator() {

	require_once WAE_PLUGIN_PATH . '/elements/page-heading.php';
	require_once WAE_PLUGIN_PATH . '/elements/video-page-heading.php';
	
}
add_action('elementor/widgets/widgets_registered','mmvc_elements_activator');