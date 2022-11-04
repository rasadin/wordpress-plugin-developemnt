;(function($) {
    "use strict";

    /**
     * Hero Carousel
     */
    var heroCarousel = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');

        $_this.owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            items: 1,
            dots: false,
        });
    }

     /**
     * Home Search Tab 
     */
    var HomeSearchTab = function() {
		$('.search-link').click(function() {
		  $('.search-box-wrapper').slideToggle("slow");
		});
      }
    HomeSearchTab();
      


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/maxpak-home-carousel.default', heroCarousel);
     
    });
})(jQuery);