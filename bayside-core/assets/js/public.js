;(function($) {
    "use strict";

    /**
     * Home slider
     */
    var heroCarousel = function($scope, $) {
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
     * Logo slider
     */
    var heroCarousellogo = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        var $currentId =  '#'+$_this.attr('id'),
            $slides = $_this.data('slide');

        $($currentId).owlCarousel({
            loop:true,
            margin:100,
            nav:true,
            dots: false,
            autoWidth:true,
            responsiveClass:true,
            responsive:{
                0:{
                    items: 2,
                    margin:10,
                    autoWidth:false
                },
                600:{
                    items: 5,
                    margin:30,
                    autoWidth:false
                },
                1500:{
                    items: 6,
                    margin:30,
                    autoWidth:false
                },
                1340:{
                    items: $slides
                }

            }
        })
    }

     /**
     * cost slider
     */

    var costCarousel = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            items: 1,
            dots: false
        })
    }

     /**
     * auto scroll contact-us button to contact-us section
     */
    var goToContact = function() {
        $('a[href*=#]').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
        });
    }
    goToContact();


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/bayside-hero-carousel.default', heroCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/bayside-hero-carousel-logo.default', heroCarousellogo);
        elementorFrontend.hooks.addAction('frontend/element_ready/bayside-cost-carousel.default', costCarousel);
    });
})(jQuery);
