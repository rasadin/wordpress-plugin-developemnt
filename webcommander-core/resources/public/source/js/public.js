(function($) {
    "use strict";

    /**
     * Elementor Widget: Portfolio Slider
     * @author Rabiul
     * @since 1.0.0
     */
    var portfolioSlider = function($scope, $) {
        var $_this = $scope.find('.wcc-portfolio-slider');
        var $currentID = "#"+$_this.attr('id');
        $($currentID).owlCarousel({
            autoplay: false,
            lazyLoad: true,
            loop: true,
            margin: 20,
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
            
                600: {
                    items: 3
                },
            
                1024: {
                    items: 3
                },
            
                1366: {
                    items: 3
                }
            }
        });
    }

    /**
     * Elementor Front-end Hook Init
     */
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wcc-portfolio-slider.default', portfolioSlider);
    });

    /**
    * Load More Portfolios
    * @author Rabiul
    * @since 1.0.0
    */
    var loadmorePortfolios = function() {

        var loadMoreBtn = '.js-load-more-portfolio';
        var perPage = parseInt(publicLocalizer.posts_per_page, 10);
        var offset = perPage;

        $(document.body).on('click', loadMoreBtn, function(e) {
            var _self = $(this);
            e.preventDefault();

            var appnedTo = $('.js-portfolio-appender');
            var template = wp.template('load-portfolios');

            var spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

            $.ajax({
                url: publicLocalizer.ajaxUrl,
                type: 'post',
                data: {
                    action: 'loadmore_portfolios', // [N.B] public\Modules\Portfolio\Portfolio.php
                    per_page: perPage,
                    offset: offset,
                    nonce: publicLocalizer.nonce
                },
                beforeSend: function() {
                    _self.html('').append(spinner);
                },
                success: function(res) {
                    // Parsing JSON Data
                    var data  = JSON.parse(res);
                    // Increment Offset
                    offset += parseInt( perPage, 10 );
                    
                    // Append Data
                    appnedTo.append(template(data));

                    // Remove Loader
                    _self.html('Load More');

                    // Hiding Load More Button If No More Posts.
                    if( data.totalPortfolios <= offset || data.totalPortfolios == perPage  ) {
                        _self.hide();
                    }

                }
            });

        })
    
    }
    loadmorePortfolios();

    /**
     * Support Search
     * @author Rabiul
     * @since 1.0.0
     */
    var supportSearchSuggstion = function() {
        var supportSearchField = '.js-support-search';

        // On KeyUp
        $( document.body ).on( 'keyup', supportSearchField, function(e) {
            e.preventDefault();

            var keyword = $( this ).val();
            if( keyword.length < 2 ) {
                $('.js-search-list').hide();
            }else if( keyword.length > 2  ) {
                window.getHelp = false;
                $('.js-search-list').show().html('Loading...');
                $.ajax({
                    url: publicLocalizer.ajaxUrl, 
                    type: 'post',
                    data: {
                        action: 'generate_suggestions', // [N.B] admin\Modules\Search\Search.php
                        keyword: keyword,
                        // nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        $('.js-search-list').html('Loading...');
                    },
                    success: function(res) {
                        var data = JSON.parse( res );
                        if( true == data.isSuccess ) {
                            if( data.responseData.list != '' ) {
                                if( window.getHelp == true ) {
                                    $('.js-search-list').hide();
                                }else {
                                    $('.js-search-list').empty();
                                    $('.js-search-list').show();
                                    var suggestions = data.responseData.list;
        
                                    suggestions.forEach(function(item, index) { 
                                        $('.js-search-list').append( '<li class="js-select-link""><a href="'+item.url+'" target="_blank">'+item.title+'</a></li>' );
                                    });
                                }
                            }else {
                                $( '.js-search-list' ).hide();
                            }
                        }
                    }
                });
            }
            
        })

    }
    supportSearchSuggstion();

    /**
     * Onclick Get help button
     * @author Rabiul
     * @since 1.0.0
     */
    var supportSearch = function() {
        $( document.body ).on( 'click',  '.js-support-search-btn', function(e) {
            e.preventDefault();
            window.getHelp = true;
            // Hide the search List
            $( '.js-search-list' ).hide();

            var keyword = $('.js-support-search').val();

            var appnedTo = $('.js-search-appender');
            var template = wp.template('wcc-search-result');

            $('.search-acc').hide();
            $( '.search-no-result' ).hide();

            if( keyword.length > 3 ) {
                $( '.js-form-container' ).hide();
                $.ajax({
                    url: publicLocalizer.ajaxUrl, 
                    type: 'post',
                    data: {
                        action: 'generate_suggestions', // [N.B] admin\Modules\Search\Search.php
                        keyword: keyword,
                        // nonce: publicLocalizer.nonce
                    },
                    beforeSend: function() {
                        $('.js-search-list').empty();
                        $('.js-search-card').empty();
                        // Show Bottom Loader
                        $('.lds-ring-search').addClass('show-loader');
                    },
                    success: function(res) {
                        var data = JSON.parse( res );
                        // Show Bottom Loader
                        $('.lds-ring-search').removeClass('show-loader');
                        if( true == data.isSuccess ) {
                            if( data.responseData.list != '' ) {
                                $('.search-acc').show();
                                $('.js-search-heading').find('.js-keyword').html(keyword);
                                var results = data.responseData.list;
                                appnedTo.html(template(results));
                            }else {
                                $( '.search-no-result' ).show();
                            }
                        }
                    }
                });
            }else {
                $( '.js-form-container' ).show();
            }
        });
    }
    supportSearch();

    // Hide the search Box if click outside
    $( document.body ).on( 'click', '.webalive-site', function() {
        $( '.js-search-list' ).hide();
    } )
    

})(jQuery)