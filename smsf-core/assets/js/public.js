;(function($) {
    "use strict";

    /**
     * Image Text slider
     */
    var imageTextSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            items: 1,
            dots: false,
            nav:true,

        })
    }

     /**
     * Doctor slider
     */
    var doctorSliderSmsf = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        var $currentId =  '#'+$_this.attr('id'),
            $slides = $_this.data('slide');

        $($currentId).owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            items: 1,
            dots: false,
            nav:true,

        })
    }

     /**
     * auto scroll contact-us button to contact-us section
     */
    // var goToContact = function() {
    //     $('a[href*=#]').on('click', function(e) {
    //         e.preventDefault();
    //         $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
    //     });
    // }
    // goToContact();


    $(window).on('elementor/frontend/init', function () {
       // elementorFrontend.hooks.addAction('frontend/element_ready/smsf-hero-carousel.default', imageTextSlider);
        //elementorFrontend.hooks.addAction('frontend/element_ready/smsf-doctor-slider.default', doctorSliderSmsf);
    });
})(jQuery);
