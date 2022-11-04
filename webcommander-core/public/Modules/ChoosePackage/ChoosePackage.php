<?php 
namespace WCC\Front\Modules;

class ChoosePackage {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action('wp_ajax_free_package', array($this, 'free_package'));
        add_action('wp_ajax_nopriv_free_package', array($this, 'free_package'));

        add_action('wp_ajax_paid_package', array($this, 'paid_package'));
        add_action('wp_ajax_nopriv_paid_package', array($this, 'paid_package'));
    }

    /**
     * Free Package (Ajax Call)
     * @author Rabiul
     * @since 1.0.0
     */
    public function free_package() {
        if( isset( $_POST['is_free'] ) ) {
            $is_free = $_POST['is_free'];

            if($is_free) {
                $_SESSION['free_package'] = true;
                $_SESSION['paid_package'] = false;
            }else {
                $_SESSION['free_package'] = false;
                $_SESSION['paid_package'] = true;
            }

        }else {
            return;
        }

        $response = [
            'free' => $_SESSION['free_package'],
            'paid' => $_SESSION['paid_package'],
        ];

        echo wp_json_encode($response);
        wp_die();
    }

    /**
     * Paid Package (Ajax Call)
     * @author Rabiul
     * @since 1.0.0
     */
    public function paid_package() {
        if( isset( $_POST['is_paid'] ) ) {
            $is_paid = $_POST['is_paid'];

            if($is_paid) {
                $_SESSION['paid_package'] = true;
                $_SESSION['free_package'] = false;
            }else {
                $_SESSION['paid_package'] = false;
                $_SESSION['free_package'] = true;
            }

        }else {
            return;
        }
        $response = [
            'free' => $_SESSION['free_package'],
            'paid' => $_SESSION['paid_package'],
        ];
        echo wp_json_encode($response);
        wp_die();
    }
}