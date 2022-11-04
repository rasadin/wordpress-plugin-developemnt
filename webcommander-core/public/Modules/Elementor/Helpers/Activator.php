<?php
function wcc_elements_activator() {
	require_once WCC_PLUGIN_PATH . '/public/Modules/Elementor/Elements/PageHeading.php';
	require_once WCC_PLUGIN_PATH . '/public/Modules/Elementor/Elements/PortfolioSlider.php';
	require_once WCC_PLUGIN_PATH . '/public/Modules/Elementor/Elements/SignupPopupLink.php';
}
add_action('elementor/widgets/widgets_registered','wcc_elements_activator');