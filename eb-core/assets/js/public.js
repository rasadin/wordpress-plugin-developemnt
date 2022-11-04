;
(function($) {
    "use strict";


    /**
     * Home Main slider
     */
    var homeMainSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            items: 1,
            dots: false,
            autoplay: false,
            autoplayTimeout: 10000,
            autoplayHoverPause: true,
            video: true,
            onTranslate: function() {
                $('.owl-item').find('video').each(function() {
                    //this.pause();
                    this.play();
                    $(".owl-item.active video")[0].pause();
                });
            }
        })
        $(".owl-item.active video")[0].play();
    }

    /**
     * Home Page Main slider
     */
    // this code for home slider pagination -start
    var owl = $("#homeSliderOwlJs");
    owl.on('changed.owl.carousel', function(e) {
        console.log("current: ", e.relatedTarget.current() + 1)
        console.log("current: ", e.item.index + 1) //same
        console.log("total: ", e.item.count) //total
        var total = (e.item.count);
        var current = (e.item.index + 1);
        $(".current").html(current);
        $(".slider-number-title").html(current);
        $(".total").html(total);
    });
    // this code for home slider pagination - end
    var victusGlobalHomeSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            loop: false,
            rewind: true,
            // margin:0,
            // nav:false,
            // items: 1,
            // dots: true,
            // autoplay: true
            items: 1,
            nav: true,
            dots: true,
            dotsData: true,
            // animateOut: 'fadeOut',
            // smartSpeed: 550

        });
        // $(document).ready(function(){
        //     $('.homeSliderOwl').owlCarousel({
        //           items:1,
        //           nav: true,
        //           dots: true,
        //           dotsData: true,
        //       });
        //   });
    }


    var faqAcc = function($scope, $) {
        $("#accordion ul li").each(function() {
            var trigger = $(this).find('a')
            var acc_text = $(this).find('.accordion')
            $(trigger).click(function(e) {
                e.preventDefault();
                $(trigger).toggleClass("main-tog");
                $(acc_text).toggleClass("main-tog-dis");
                $(acc_text).slideToggle()
            });
        });
    };





    var faqAccOne = function($scope, $) {
        // $("#accordion ul li").each(function() {
        //     var trigger = $(this).find('a')
        //     var acc_text = $(this).find('.accordion')
        //     $(trigger).click(function(e) {
        //         e.preventDefault();
        //         $(trigger).toggleClass("main-tog");
        //         $(acc_text).toggleClass("main-tog-dis");
        //         $(acc_text).slideToggle()
        //     });
        // });


        $(document).ready(function() {
            $('.acc-container .acc:nth-child(1) .acc-head').addClass('active');
            $('.acc-container .acc:nth-child(1) .acc-content').slideDown();
            $('.acc-head').on('click', function() {
                if($(this).hasClass('active')) {
                  $(this).siblings('.acc-content').slideUp();
                  $(this).removeClass('active');
                }
                else {
                  $('.acc-content').slideUp();
                  $('.acc-head').removeClass('active');
                  $(this).siblings('.acc-content').slideToggle();
                  $(this).toggleClass('active');
                }
            });
            });


    };



    /**
     * Home Reviews slider
     */
    var reviewsSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            nav: true,
            loop: false,
            dots: false,
            pagination: false,
            margin: 25,
            autoHeight: false,
            autoWidth: true,
            stagePadding: 50,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 0,
                    margin: 15,
                    center: true
                },
                767: {
                    items: 2,
                    stagePadding: 0,
                    center:true
                },
                1000: {
                    items: 4,
                }
            }
        })

    }



    /**
     * Image Change with time slider
     */
    var imgSlider = function($scope, $) {
        var $_this = $scope.find('.slick-carousel');
        var currentId = '#' + $_this.attr('id');
        var current = $_this.attr('id');
        var time = $("#myField-" + current).val();

        console.log(time);

        $(currentId).slick({
            draggable: true,
            autoplay: true,
            autoplaySpeed: time,
            arrows: false,
            dots: false,
            fade: true,
            speed: 2000,
            infinite: true,
            // cssEase: 'ease-in-out',
            cssEase: 'linear',
            touchThreshold: 100
          })

    }

    /**
     * Home Reviews slider
     */
    var clientReviewSlider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        $_this.owlCarousel({
            nav: true,
            loop: false,
            dots: false,
            pagination: false,
            margin: 0,
            autoHeight: false,
            autoWidth: false,
            stagePadding: 0,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 0,
                    margin: 0,
                    center: true
                },
                767: {
                    items: 1,
                    stagePadding: 0,
                    center:true
                },
                1000: {
                    items: 1,
                }
            }
        })
    }



    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-home-carousel.default', homeMainSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-hero-carousel.default', victusGlobalHomeSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-faq-acc.default', faqAcc);
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-reviews-slider.default', reviewsSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/image-change-slider.default', imgSlider);
        elementorFrontend.hooks.addAction('frontend/element_ready/eb-faq-acc-one.default', faqAccOne);
        elementorFrontend.hooks.addAction('frontend/element_ready/client-reviews-slider.default', clientReviewSlider);
    });
})(jQuery);