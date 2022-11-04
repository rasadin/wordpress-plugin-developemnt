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
            items: 2,
            dots: false,
            nav:true,

        })
    }





    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tomcopy-hero-carousel.default', imageTextSlider);
    });
})(jQuery);
