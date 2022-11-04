<?php 
namespace WCC\Admin\Modules;

use WCC\Admin\Modules\TrialSignup\Template;
use WCC\Admin\Modules\TrialSignup\SignupForm;
use WCC\Admin\Modules\TrialSignup\PaidSignupForm;

class TrialSignup {
    /**
     * Construct Functions
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        $trial_form         = new SignupForm();
        $paid_form          = new PaidSignupForm();
        $template           = new Template();
    }
}