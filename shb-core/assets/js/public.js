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
            nav:false,
            items: 1,
            dots: true,
            autoplay: true

        })
    }

     /**
     * Image Text slider
     */
    var testimonialSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            items: 1,
            dots: false,

        })
    }


    /**
     * Image Text slider
     */
    var teamlSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            // items: 5,
            dots: false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:3,
                },
                1000:{
                    items:5,
                }
            }

        })
    }




    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/shb-hero-carousel.default', imageTextSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/shb-testimonial-carousel.default', testimonialSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/shb-team-carousel.default', teamlSlider);
    });
})(jQuery);
