<?php
function include_wth_elementor_elements() {
	require_once WTH_PATH . 'inc/elementor/elements/bx-slider.php';
	//require_once WTH_PATH . 'inc/elementor/elements/products.php';
}
add_action('elementor/widgets/widgets_registered','include_wth_elementor_elements');