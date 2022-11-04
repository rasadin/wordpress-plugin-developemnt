<?php
function webalive_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/portfolio-grid.php';
	require_once WAE_PLUGIN_PATH . '/elements/selected-portfolio.php';
	require_once WAE_PLUGIN_PATH . '/elements/featured-portfolio.php';
	require_once WAE_PLUGIN_PATH . '/elements/portfolio-sort-list.php';
	require_once WAE_PLUGIN_PATH . '/elements/post-thumbnail-grid.php';
	require_once WAE_PLUGIN_PATH . '/elements/popup-offgrid-video.php';
	require_once WAE_PLUGIN_PATH . '/elements/history-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/history-tabs.php';
	require_once WAE_PLUGIN_PATH . '/elements/testimonial-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/project-slider.php';
	require_once WAE_PLUGIN_PATH . '/elements/clients-reviews-carousel.php';
}
add_action('elementor/widgets/widgets_registered','webalive_elements_activator');