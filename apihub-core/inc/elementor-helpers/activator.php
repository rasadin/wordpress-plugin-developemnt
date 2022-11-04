<?php
function eb_elements_activator() {
    // require_once WAE_PLUGIN_PATH . '/elements/faq-acc.php';
    // require_once WAE_PLUGIN_PATH . '/elements/event-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-me-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-users-api.php';
    // require_once WAE_PLUGIN_PATH . '/elements/webhook-api.php';
    // require_once WAE_PLUGIN_PATH . '/elements/purchase-api.php';
    // require_once WAE_PLUGIN_PATH . '/elements/order-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-event-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-reviews-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-org-api.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-common.php';
    require_once WAE_PLUGIN_PATH . '/elements/eb-orders-api.php';

}
add_action('elementor/widgets/widgets_registered','eb_elements_activator');