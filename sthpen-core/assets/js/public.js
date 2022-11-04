;
(function($) {
    "use strict";

    /**
     * Image Text slider
     */
    var imageTextSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            autoplay: true,
            rewind: true,
            loop: false,
            autoplay: true,
            autoplayTimeout: 12000,
            margin: 0,
            nav: true,
            items: 1,
            dots: true,
            nav: true,
            // animateOut: 'fadeOut',
            // animateIn: 'flipInX',
            smartSpeed: 700

        })

        $("#for-owl-item-0").addClass("important-active-item");
        var owl = $(".owl-carousel");
        owl.owlCarousel({
            autoplay: true,
            loop: false,
            rewind: true,
            autoplay: true,
            autoplayTimeout: 12000,
            items: 1,
            animateOut: 'fadeOut',
            smartSpeed: 700
        });

        // jQuery method on
        owl.on('changed.owl.carousel', function(property) {
            var current = property.item.index;
            var src = $(property.target).find(".owl-item").eq(current).find("img").attr('src');
            console.log('Image current is ' + src);
            console.log('Image index is ' + current);
            console.log("#for-owl-item-" + current);
            $(".tob-colume-content").removeClass("important-active-item");
            $("#for-owl-item-0").removeClass("important-active-item");
            $("#for-owl-item-" + current).addClass("important-active-item");

        });
    }

    /**
     * Player-Post slider js
     */
    var postSliderMmvc = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop: false,
            rewind: true,
            margin: 0,
            nav: true,
            items: 1,
            dots: true,
            nav: true,

        })
    }



    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/sthpen-hero-carousel.default', imageTextSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/sthpen-player-slider.default', postSliderMmvc);

    });
})(jQuery);