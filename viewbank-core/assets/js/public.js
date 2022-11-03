;(function($) {
    "use strict";

     /**
     * Logo slider
     */
    var Viewbank_Middle_School_Slider = function($scope, $) {
        var $_this = $scope.find('.owl-carousel');
        var $currentId =  '#'+$_this.attr('id'),
            $slides = $_this.data('slide');

        $($currentId).owlCarousel({
            loop:true,
            margin:100,
            nav:false,
            dots: true,
            autoWidth:true,
            responsiveClass:true,
            responsive:{
                0:{
                    items: 1,
                    margin:10,
                    autoWidth:false
                },
                600:{
                    items: 1,
                    margin:30,
                    autoWidth:false
                },
                1500:{
                    items: 1,
                    margin:100,
                    autoWidth:false
                },
                1340:{
                    items: 1
                }

            }
        })
    }

      //Slider Show  Hide
      var windowWidthdown = 1025;
      var ViewBank_Middle = function(){
          // For Larger Devices
          if( $(window).width() > windowWidthdown ) {
            $( '.logo-slider-fasttrack' ).hide();
            $( '.middle-school' ).show();
          }else if($(window).width() > 767 && $(window).width() < 1025){
            $( '.logo-slider-fasttrack' ).show();
            $( '.middle-school' ).hide();

          }else{
            $( '.logo-slider-fasttrack' ).show();
            $( '.middle-school' ).hide();

          }
      }
      ViewBank_Middle();

    $(window).on('elementor/frontend/init', function () {     
        elementorFrontend.hooks.addAction('frontend/element_ready/viewbank-hero-carousel.default', Viewbank_Middle_School_Slider);
    });
})(jQuery);
