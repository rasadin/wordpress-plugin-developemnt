;(function($) {
    "use strict";

    // Params
    var sliderSelector = '.swiper-container',
        options = {
            init: false,
            loop: true,
            speed: 2000,
            slidesPerView: 1, // or 'auto'
            // spaceBetween: 10,
            centeredSlides : true,
            effect: 'fade', // 'cube', 'fade', 'coverflow',
            autoplay: {
                delay:5000,
            },
            flipEffect: {
                slideShadows : true, // Enables slides shadows
            },
            grabCursor: true,
            parallax: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                type: 'fraction'
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1023: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
            // Events
            on: {
                imagesReady: function(){
                    this.el.classList.remove('loading');
                }
            }
        };
    var mySwiper = new Swiper(sliderSelector, options);

// Initialize slider
    var mySwiperInit = mySwiper.init();


    $(window).on('elementor/frontend/init', function () {
        //elementorFrontend.hooks.addAction('frontend/element_ready/webalive-carousel.default', mySwiperInit);
    });
})(jQuery);