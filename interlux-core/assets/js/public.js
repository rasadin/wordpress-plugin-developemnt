;
(function($) {
    "use strict";

    /**
     * interlux slider
     */
    var Interlux_slider_addons =
        $('.owl-slider-ild').on('initialized.owl.carousel changed.owl.carousel', function(e) {
            if (!e.namespace) {
                return;
            }
            var carousel = e.relatedTarget;
            $('.slider-counter').text(carousel.relative(carousel.current()) + 1 + '/' + carousel.items().length);
        }).owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true
        });



    // function($scope, $) {
    //   var $_this = $scope.find('.owl-carousel');
    //   var $currentId =  '#'+$_this.attr('id'),
    //       $slides = $_this.data('slide');

    //   $($currentId).owlCarousel({
    //       loop: false,
    //       rewind: true,
    //       margin:0,
    //       nav:true,
    //       dots: true,
    //       autoWidth:false,
    //       items: 1,
    //       smartSpeed: 1000,
    //       autoplay:true,
    //       autoplayTimeout:8000,
    //       autoplayHoverPause:true

    //   })
    // }




    /**
     * interlux reviews slider
     */
    var Interlux_Reviews_slider_addons =
        $('.owl-slider-rev').on('initialized.owl.carousel changed.owl.carousel', function(e) {
            if (!e.namespace) {
                return;
            }
            var carousel = e.relatedTarget;
            $('.slider-counter-rev').text(carousel.relative(carousel.current()) + 1 + '/' + carousel.items().length);
        }).owlCarousel({
            items: 2,
            loop: true,
            margin: 0,
            nav: true,
            // slideBy: 2
                  responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    }
                }
        });



    // function($scope, $) {
    //   var $_this = $scope.find('.owl-carousel');
    //   var $currentId =  '#'+$_this.attr('id'),
    //       $slides = $_this.data('slide');

    //   $($currentId).owlCarousel({
    //       loop:true,
    //       margin:0,
    //       nav:true,
    //       dots: true,
    //       autoWidth:false,
    //       smartSpeed: 1000,
    //       responsive:{
    //         0:{
    //             items:2
    //         },
    //         600:{
    //             items:2
    //         },
    //         1000:{
    //             items:2
    //         }
    //     }

    //   })
    // }


    var faqAcc = function($scope, $) {
        $("#accordion ul li").each(function() {
            var trigger = $(this).find('a')
            var acc_text = $(this).find('.accordion')
            $(trigger).click(function(e) {
                e.preventDefault();

                $(acc_text).slideToggle()

            });
        });
    };


    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/interlux-hero-carousel.default', Interlux_slider_addons);
        elementorFrontend.hooks.addAction('frontend/element_ready/interlux-reviews-carousel.default', Interlux_Reviews_slider_addons);
        elementorFrontend.hooks.addAction('frontend/element_ready/interlux-faq-acc.default', faqAcc);
    });
})(jQuery);