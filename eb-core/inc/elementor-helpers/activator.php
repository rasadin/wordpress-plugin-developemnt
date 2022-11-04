<?php
function eb_elements_activator() {
	require_once WAE_PLUGIN_PATH . '/elements/home-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/page-header.php';
	require_once WAE_PLUGIN_PATH . '/elements/text-tooltip.php';
	require_once WAE_PLUGIN_PATH . '/elements/bootstrap-vertical-tabs.php';
	require_once WAE_PLUGIN_PATH . '/elements/hero-carousel.php';
	require_once WAE_PLUGIN_PATH . '/elements/eb-pricing-calculator.php';
	require_once WAE_PLUGIN_PATH . '/elements/mobile-toggle-acc.php';
    require_once WAE_PLUGIN_PATH . '/elements/ticket-toggle.php';
    require_once WAE_PLUGIN_PATH . '/elements/faq-acc.php';
    require_once WAE_PLUGIN_PATH . '/elements/one-open-faq.php';
    require_once WAE_PLUGIN_PATH . '/elements/reviews-slider.php';
    require_once WAE_PLUGIN_PATH . '/elements/image-change.php';
    require_once WAE_PLUGIN_PATH . '/elements/client-review-slider.php';


}
add_action('elementor/widgets/widgets_registered','eb_elements_activator');