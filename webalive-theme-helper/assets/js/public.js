;(function($) {
    "use strict";
    console.log('Public loaded');


    var bxSlider = function ($scope, $) {
        var $_this = $scope.find('.wth-bx-slider');
        var $currentId = '#'+$_this.attr('id'),
            $mode = $_this.data('mode'),
            $captions = $_this.data('caption'),
            $speed = $_this.data('speed'),
            $slideMargin = $_this.data('slide-margin'),
            $startSlide = $_this.data('slide-start'),
            $randomStart = $_this.data('random-start'),
            $infiniteLoop = $_this.data('infinite-loop'),
            $hideControlInEnd = $_this.data('hide-ctrl-on-end'),
            $easing = $_this.data('easing'),
            $ticker = $_this.data('ticker'),
            $tickerHover = $_this.data('ticker-hover'),
            $adaptiveHeight = $_this.data('adaptive-height'),
            $adaptiveHeightSpeed = $_this.data('adaptive-height-speed'),
            $auto = $_this.data('auto'),
            $pause = $_this.data('pause'),
            $autoStart = $_this.data('auto-start'),
            $autoDirection = $_this.data('auto-direction'),
            $autoHover = $_this.data('auto-hover'),
            $minSlide = $_this.data('min-slide'),
            $maxSlide = $_this.data('max-slide'),
            $controls = $_this.data('controls'),
            $keyboardEnable = $_this.data('keyboard-enable'),
            $pager = $_this.data('pager');

        $('.bxslider').bxSlider({
            mode: $mode,
            captions: $captions,
            speed: $speed,
            slideMargin: $slideMargin,
            startSlide: $startSlide,
            randomStart: $randomStart,
            infiniteLoop: $infiniteLoop,
            hideControlOnEnd: $hideControlInEnd,
            easing: $easing,
            ticker: $ticker,
            tickerHover: $tickerHover,
            adaptiveHeight: $adaptiveHeight,
            adaptiveHeightSpeed: $adaptiveHeightSpeed,

            responsive: true,
            touchEnabled: true,
            swipeThreshold: 50,
            oneToOneTouch: false,

            auto: $auto,
            pause: $pause,
            autoStart: $autoStart,
            autoDirection: $autoDirection,
            autoHover: $autoHover,

            minSlides: $minSlide,
            maxSlides: $maxSlide,

            controls: $controls,
            keyboardEnabled: $keyboardEnable,
            pager: $pager

        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wth-bx-slider.default', bxSlider);
    });

    var product = function ($scope, $) {
        var $_this = $scope.find('.wth-products-section');
        var product_per_row = $_this.attr('wth_product_per_row');
        console.log('product_per_row ', product_per_row);
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wth-product.default', product);
    });

})(jQuery);