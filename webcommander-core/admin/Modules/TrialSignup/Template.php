<?php 
namespace WCC\Admin\Modules\TrialSignup;

class Template {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_filter('theme_page_templates', array( $this, 'add_page_template' ));
        add_filter('template_include', array( $this, 'update_page_template' ), 99);
    }

    /**
     * Include Page Template
     * @author Rabiul
     * @since 1.0.0
     */
    public function add_page_template( $templates ) {
        $templates[WCC_PLUGIN_URL . 'templates/trial-signup/template-library.php'] = __('Template Library', 'webcommander-core');
        $templates[WCC_PLUGIN_URL . 'templates/trial-signup/additional-package.php'] = __('Additional Package', 'webcommander-core');
        $templates[WCC_PLUGIN_URL . 'templates/trial-signup/payment-process.php'] = __('Payment Process', 'webcommander-core');
        $templates[WCC_PLUGIN_URL . 'templates/trial-signup/payment-success.php'] = __('Payment Success', 'webcommander-core');

        return $templates;
    }

    /**
     * Update Page Template
     * @author Rabiul
     * @since 1.0.0
     */
    public function update_page_template($template) {
        if( is_page('template-library') ) {
            $files = array( 'template-library.php', 'webcommander-core/trial-signup/template-library.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . '/templates/trial-signup/template-library.php';
            }
        }else if( is_page('additional-packages') ) {
            $files = array( 'additional-packages.php', 'webcommander-core/trial-signup/additional-packages.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . '/templates/trial-signup/additional-packages.php';
            }
        }else if( is_page('payment-process') ) {
            $files = array( 'payment-process.php', 'webcommander-core/trial-signup/payment-process.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . '/templates/trial-signup/payment-process.php';
            }
        }else if( is_page('payment-success') ) {
            $files = array( 'payment-success.php', 'webcommander-core/trial-signup/payment-success.php' );
            $exists_in_theme = locate_template( $files, true );
            if( $exists_in_theme != '' ) {
                return $exists_in_theme;
            }else {
                return WCC_PLUGIN_PATH . '/templates/trial-signup/payment-success.php';
            }
        }
        return $template;
    }

}