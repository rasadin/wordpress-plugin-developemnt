<?php
function webalive_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/webalive-carousel/webalive-carousel.php';
}
add_action('elementor/widgets/widgets_registered','webalive_elements_activator');