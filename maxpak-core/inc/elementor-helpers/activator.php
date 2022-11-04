<?php
function maxpak_elements_activator() {
	require_once MAXPAK_PLUGIN_PATH . '/elements/home-carousel-max.php';
	require_once MAXPAK_PLUGIN_PATH . '/elements/selected-woo-categories.php';
	require_once MAXPAK_PLUGIN_PATH . '/elements/all-categories.php';
	require_once MAXPAK_PLUGIN_PATH . '/elements/maxpak-tab.php';
	require_once MAXPAK_PLUGIN_PATH . '/elements/newsletter-maxpak.php';
	
	
}
add_action('elementor/widgets/widgets_registered','maxpak_elements_activator');