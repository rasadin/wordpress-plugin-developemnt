;(function($) {
    "use strict";

    $( ".loader-last" ).hide();

    // Setting default state for Project Data
    window.projectDataReset = '';

    // Setting default state for skip ecommerce
    window.steps = 0;

    /**
     * Popup Off Grid Video Player 
     * @author Rabiul
     */
    var popupOffGridVideo = function ($scope, $) {
        var $_this = $scope.find('.webalive-offgrid-canvas');

        // Add Background Image
        $_this.css('background', 'url("'+$_this.data("bg")+'")');
        
        // Play Video On Click
        $_this.find('.play-btn').on('click', function(e) {
            e.preventDefault();
            $_this.find('.offgrid-video-player').css({
                'zIndex': 100,
                'opacity': 1
            })

            // Find Frame & pause video on close
            var URL = $_this.find('iframe').prop('src');
            URL = URL.replace('&autoplay=0', '&autoplay=1');
            $_this.find('iframe').prop('src', URL); 
        })
        // Close Video On Click
        $_this.find('.frame-close').on('click', function(e) {
            e.preventDefault();
            $_this.find('.offgrid-video-player').css({
                'zIndex': -1,
                'opacity': 0
            });

            // Find Frame & pause video on close
            var URL = $_this.find('iframe').prop('src');
            URL = URL.replace('&autoplay=1', '&autoplay=0');
            $_this.find('iframe').prop('src', URL); 
        })
        // Changing Styles According to Settings Panel
        $_this.find('.offgrid-video-player').css('height', $_this.data('frame-height'));
        $_this.find('iframe').css('height', $_this.data('frame-height'));
    }

    /**
     * Protfolio Sorting List
     * @author Rabiul
     */
    var portfolioSortList = function($scope, $) {

        var $_this          = $scope.find('.our-work-list-section');
        var perPage         = $_this.data('per-page');
        var projectCount    = public_localizer.total_projects;

        // Setting up wp.template essentials
        var appnedTo = $('#js-append-work-item');
        var template = wp.template('projects');

        // Terms onClick Event
        $('ul.work-filter li').on('click', function(e) {
            e.preventDefault();

            // Change Current List Class
            $('ul.work-filter li').removeClass('current');
            $(this).addClass('current');

            // Grabbing the term slug onClick
            var termName = $(this).data('term');

            // Showing Loadmore Button
            $('#js-loadmore-projects').show();

            // Changing Project Data State
            window.projectDataReset = true;

            // Making Ajax Request
            $.ajax({
                url: public_localizer.ajax_url,
                type: 'post',
                data: {
                    term_name: termName,
                    per_page: perPage,
                    action: 'portfolio', // [N.B: ulitilies.php]
                },
                success: function(res) {
                    var data = JSON.parse(res);

                    // Clearing the playing field
                    $('.js-work-item').remove();
                    $('.js-row-list').remove();
                    
                    // Append Results
                    appnedTo.append(template(data));

                    // Initially Show/Hide Loadmore Button
                    if( data.total_projects > perPage ) {
                        $('.loadmore-wrap').removeClass('hide');
                    }else {
                        $('.loadmore-wrap').addClass('hide');
                    }
                }
            })
        })
    }

    /**
     * Load More Portfolio
     * @author Rabiul
     */
    var loadmoreProjects = function($scope, $) {

        var $_this          = $scope.find('.our-work-list-section');
        var perPage         = $_this.data('per-page');
        var projectCount    = public_localizer.total_projects;

        // Setting up wp.template essentials
        var appnedTo = $('#js-append-work-item');
        var template = wp.template('loadmore-projects');

        // Init offset & perPage
        var offset = perPage;

        // Loarmore onClick Event
        $(document.body).on('click', '#js-loadmore-projects', function(e) { 
            e.preventDefault();
            var _self = $(this);

            // Showing loader by removing fade-me class
            $('.lds-ellipsis').removeClass('fade-me');

            // Grabbing the term slug onClick
            var termName = $('ul.work-filter li.current').data('term');
            
            // Reset offset & perPage when switch terms
            if( window.projectDataReset == true ) {
                offset = perPage;
            }

            // Changing the value if only click on loadmore
            window.projectDataReset = false;

            // Making Ajax Request
            $.ajax({
                url: public_localizer.ajax_url,
                type: 'post',
                data: {
                    termName: termName,
                    action: 'loadmore_portfolio', // [N.B: ulitilies.php]
                    offset: offset,
                    perPage: perPage
                },
                success: function(res) {
                    var data = JSON.parse(res);

                    // Hiding loader by adding fade-me class
                    $('.lds-ellipsis').addClass('fade-me');

                    // Incrementing offset value
                    offset = parseInt(offset, 10) + parseInt(perPage, 10);

                    // Append Results
                    appnedTo.append(template(data));

                    // Removing loadmore if no more data available
                    if (data.total_projects <= offset || data.total_projects == perPage) {
                        _self.hide();
                    }
                }
            })
        })
    }

    /**
     * History Carousel
     * @author Rabiul
     */
    var historyCarousel = function($scope, $) {
        var $_this = $scope.find('.slick-carousel');

        $_this.slick({
            infinite: true,
            vertical: true,
            verticalSwiping: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            prevArrow: $('.top-arrow'),
            nextArrow: $('.bottom-arrow'), 
            dots: false
        });

        var changeOpacity = function() {
            $_this.find('.item.slick-current').each(function(index, item) {
                var opacity = 1 / (index + 1);
                $(this).css({
                    'opacity': opacity,
                    'transition': 'all 0.3s ease-in-out',
                });
            })
        }
        changeOpacity();

        $_this.on('afterChange', function(event, slick, currentSlide, nexgtSlide) {
            $('.item.slick-slide').css('opacity', 0.5);
            changeOpacity();
            
            var year = $_this.find('.item.slick-active').data('year');
            $('.history-year ul.year li').each(function(index, item) {
                var findYear = $(this).data('year');
                if( findYear == year ) {
                    $('.history-year ul.year li').removeClass('current');
                    $(this).addClass('current');
                }
            })
        })

        $_this.on('afterChange', function (event, slick, currentSlide, nextSlide) {
            var i = (currentSlide ? currentSlide : 0) + 1;
            $('.history-pagination').html('<span class="current">0'+i+'</span>' + '<span>/</span>' + '<span>0'+slick.slideCount+'</span>');
        });

        $_this.on('wheel', (function(e) {
            e.preventDefault();
            
            if (e.originalEvent.deltaY < 0) {
                $(this).slick('slickPrev');
            }else {    
                $(this).slick('slickNext');
            }
        }));
    }

    /**
     * History Tabs
     * @author Rabiul
     */
    var historyTabs = function() {
        $(document.body).on('click', '.history-pills .pills', function(e) {
            // Activating Pills
            $('.history-pills .pills').removeClass('active');
            $(this).addClass('active');

            // Get Current Pill
            var currentPill = $(this).attr('id');

            // Hide all images on pill click by default
            $('.history-content .image').addClass('hide-image').removeClass('active');

            // Looping through each image to find the pill's match
            $('.history-content .image').each(function(item, index) {

                // Get the itteration's current image id
                var imageId = $(this).data('id');

                // Changing the view mood if match found
                if( currentPill == imageId ) {
                    $('#image-'+imageId).addClass('active').removeClass('hide-image');
                }
            })

            // Updating Tab Index
            var tabIndex = $(this).data('tab');
            $('.history-pagination span.current').text('0'+tabIndex);
        })
    }

    /**
     * Optimize YouTube iFrame Videos For Better Performances
     * @author Rabiul
     */
    var optimizeYouTubeiFrame = function() {
        var youTubeFrame = $('.youtube-frame');
        var changeSrc = youTubeFrame.attr('data-src');
        youTubeFrame.attr('src', changeSrc);
    }
    optimizeYouTubeiFrame();
    

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-popup-offgrid-video.default', popupOffGridVideo);
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-popup-offgrid-video.default', optimizeYouTubeiFrame);
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-portfolio-sort-list.default', portfolioSortList);
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-portfolio-sort-list.default', loadmoreProjects);
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-history-carousel.default', historyCarousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/webalive-history-tabs.default', historyTabs);
    });


    /**
     * Clear Local store on page load
     * @author Rabiul
     */
    $( window ).on( 'load', function() {
        localStorage.clear();

        $( '.js-step-button' ).prop( 'disabled', true );
        $( '.js-step-counter-1' ).prop( 'disabled', false );
    })


    /**
     * Quote Form Header Calculation
     * @author Rabiul
     */
    var quoteFormHeaderCalculation = function() {
        // Custom Ecommerce Price Value Set
        var ecommerce_custom_price                             = 3500;
        var ecommerce_custom_monthly_fee                       = 55;
        var ecommerce_custom_100_to_1000_product_per_month     = 110;
        var ecommerce_custom_more_than_1000_product_per_month  = 385;

        // Custom Content Price Value Set
        var content_custom_price                             = 2500;
        var content_custom_monthly_fee                       = 55;
        var content_custom_100_to_1000_product_per_month     = 110;
        var content_custom_more_than_1000_product_per_month  = 385;

        // Quick Ecommerce Price Value Set
        var ecommerce_quick_price                              = 1100;
        var ecommerce_quick_monthly_fee                        = 55;
        var ecommerce_quick_100_to_1000_product_per_month      = 110;
        var ecommerce_quick_more_than_1000_product_per_month   = 385;

        // Quick Content Price Value Set
        var content_quick_price                              = 550;
        var content_quick_monthly_fee                        = 55;
        var content_quick_100_to_1000_product_per_month      = 110;
        var content_quick_more_than_1000_product_per_month   = 385;

        // General Price Value Set
        var page_6_to_10_each                          = 385;
        var page_more_than_10_each                     = 55;
        var quick_page_more_than_5_each                = 55;
        var seo_audit_price                            = 1100;
        var cms_price                                  = 1100;
        var content_writting_per_page                  = 220;
        var blog_price                                 = 550;

        // Total
        var grand_total                                = 0;
        var monthly_fee                                = 0;


        // Design Type
        $( document.body ).on( 'click', 'input[name="quote_design_type"]', function(e) {

            var designType = $( this ).val();
            
            if( 'custom' == designType ) {
                // Website Type
                $( document.body ).on( 'click', 'input[name="quote_website_type"]', function(e) {

                    var websiteType = $( this ).val();

                    if( 'ecommerce' == websiteType ) {
                        $('.js-quote-amount').show();
                        grand_total = ecommerce_custom_price;
                        // Update Grand Total Dom
                        $( '.js-total-price' ).html( grand_total );
                        
                        // Calculate Price By Product Qty
                        $( document.body ).on( 'click', 'input[name="quote_product_qty"]', function(e) {
                            var productQty = $( this ).val();
                            if( 'less_than_100' == productQty ) {
                                monthly_fee = ecommerce_custom_monthly_fee;
                            }else if( '100_to_1000' == productQty ) {
                                monthly_fee = ecommerce_custom_100_to_1000_product_per_month;
                            }else if( '1000_plus' == productQty ) {
                                monthly_fee = ecommerce_custom_more_than_1000_product_per_month;
                            }

                            // Update Monthly Fee Dom
                            $( '.js-monthly-price' ).html( monthly_fee );
                        });


                        // Calculate Price By Website Pages Qty
                        var priceByNumberOfpages = 0;
                        var grandTotalBeforeWebsitePages = grand_total;
                        var alreadyAddedPages = 0;
                        $( document.body ).on( 'click', 'input[name="quote_website_pages"]', function(e) {

                            // Reset
                            grand_total = grandTotalBeforeWebsitePages;
                            $( '.js-total-price' ).html( grand_total );
                            $( 'input[name="number_of_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalPrev', grand_total );

                            // Reset Error
                            $( '.js-webpage-error' ).html( '' );

                            if( $( this ).val() == 'max_5' ) {
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }

                        });

                        $( document.body ).on( 'keyup', 'input[name="number_of_pages"]', function(e) {
                            var numberOfPages = $( 'input[name="number_of_pages"]' ).val();
                            numberOfPages = parseInt( numberOfPages, 10 );

                            var websitePages = $( 'input[name="quote_website_pages"]:checked' ).val();

                            if( 'max_10' == websitePages ) {
                                if( numberOfPages > 5 && numberOfPages <= 10 ) {
                                    var pageToCalculate = numberOfPages - 5;
                                    priceByNumberOfpages = pageToCalculate * page_6_to_10_each;
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );

                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    alreadyAddedPages = numberOfPages;

                                    $( '.js-webpage-error' ).html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );

                                }else if(  numberOfPages <= 5 ||  isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    alreadyAddedPages = 0;
                                }
                                
                            }else if( '10_plus' == websitePages ) {
                                if( numberOfPages > 10 ) {
                                    var pageToCalculate = numberOfPages - 10;
                                    priceByNumberOfpages = pageToCalculate * page_more_than_10_each;
                                    priceByNumberOfpages = priceByNumberOfpages + ( page_6_to_10_each * 5 );
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );

                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    alreadyAddedPages = numberOfPages;

                                    $('.js-webpage-error').html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );

                                }else if( numberOfPages <= 10 || isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 10</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );

                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    alreadyAddedPages = 0;
                                }
                            }else {
                                console.log( 'less than 5 or equal to' );
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }
                        })

                        // Calculate Price By Webpage content
                        var priceByWebPageContent = 0;
                        
                        $( document.body ).on( 'click', 'input[name="quote_webpage_content"]', function(e) {

                            // Reset
                            grand_total = parseInt( localStorage.getItem( 'grandTotalPrev' ), 10 );
                            $( '.js-total-price' ).html( localStorage.getItem( 'grandTotalPrev' ) );
                            $( 'input[name="number_of_content_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalAfterWebConent', grand_total );

                        })

                        $( document.body ).on( 'keyup', 'input[name="number_of_content_pages"]', function(e) {

                            var numberOfContentPages = parseInt( $( this ).val(), 10 );
                            var webpageContent = $( 'input[name="quote_webpage_content"]:checked' ).val();
                            grand_total = localStorage.getItem( 'grandTotalPrev' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'already_have' == webpageContent ) {
                                //  Do Nothing
                                console.log( 'already_have' )

                            }else if( 'need_content' == webpageContent ) {
                                priceByWebPageContent = numberOfContentPages * content_writting_per_page;

                                if( !isNaN( numberOfContentPages ) ) {
                                    // Update Grand Total Dom
                                    grand_total += priceByWebPageContent;
                                    $( '.js-total-price' ).html( grand_total );
                                    localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
                                }else {
                                    $( '.js-total-price' ).html( grand_total );
                                }

                            }
                        })

                        // Calculate price by dynamic content
                        var alreadyBlogAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_dynamic_content"]', function(e) {
                            var dynamicContent = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterWebConent' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'yes' == dynamicContent ) {
                                if( alreadyBlogAdded == false ) {
                                    grand_total += blog_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyBlogAdded = true;
                                    localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadyBlogAdded = false;
                                localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                            }
                        })

                        // Calculate Price By SEO
                        var alreadySeoAdded = false;
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_seo_audit"]', function(e) {
                            var seoAudit = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterDynamicContent' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'yes' == seoAudit ) {
                                if( alreadySeoAdded == false ) {
                                    grand_total += seo_audit_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadySeoAdded = true;
                                    localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadySeoAdded = false;
                                localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                            }

                            // Reset Next Step
                            $( 'input[name="quote_choose_cms"]' ).prop( 'checked', false );
                            $( '#js-quote-step-7' ).prop( 'disabled', true );
                            alreadyCmsAdded = false;
                        })

                        // Calculate Price By CMS
                        
                        $( document.body ).on( 'click', 'input[name="quote_choose_cms"]', function(e) {
                            var chooseCms = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterSeoAudit' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'no_choice' == chooseCms || 'webcommander' == chooseCms ) {
                                $( '.js-total-price' ).html( grand_total );
                                alreadyCmsAdded = false;
                            }else {
                                if( alreadyCmsAdded == false ) {
                                    grand_total += cms_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyCmsAdded = true;
                                    localStorage.setItem( 'grandTotalAfterCms', grand_total );
                                }
                            }

                        })

                    }else if( 'content' == websiteType ) {
                        $('.js-quote-amount').show();
                        grand_total = content_custom_price;
                        // Update Grand Total Dom
                        $( '.js-total-price' ).html( grand_total );

                        // Calculate Price By Product Qty
                        $( document.body ).on( 'click', 'input[name="quote_product_qty"]', function(e) {
                            var productQty = $( this ).val();
                            if( 'less_than_100' == productQty ) {
                                monthly_fee = content_custom_monthly_fee;
                            }else if( '100_to_1000' == productQty ) {
                                monthly_fee = content_custom_100_to_1000_product_per_month;
                            }else if( '1000_plus' == productQty ) {
                                monthly_fee = content_custom_more_than_1000_product_per_month;
                            }

                            // Update Monthly Fee Dom
                            $( '.js-monthly-price' ).html( monthly_fee );
                        });


                        // Calculate Price By Website Pages Qty
                        var priceByNumberOfpages = 0;
                        var grandTotalBeforeWebsitePages = grand_total;
                        var alreadyAddedPages = 0;
                        $( document.body ).on( 'click', 'input[name="quote_website_pages"]', function(e) {

                            // Reset
                            grand_total = grandTotalBeforeWebsitePages;
                            $( '.js-total-price' ).html( grand_total );
                            $( 'input[name="number_of_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalPrev', grand_total );

                            // Reset
                            $( '.js-webpage-error' ).html('');

                            if( $( this ).val() == 'max_5' ) {
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }

                        });

                        $( document.body ).on( 'keyup', 'input[name="number_of_pages"]', function(e) {
                            var numberOfPages = $( 'input[name="number_of_pages"]' ).val();
                            numberOfPages = parseInt( numberOfPages, 10 );

                            var websitePages = $( 'input[name="quote_website_pages"]:checked' ).val();

                            if( 'max_10' == websitePages ) {
                                if( numberOfPages > 5 && numberOfPages <= 10 ) {
                                    var pageToCalculate = numberOfPages - 5;
                                    priceByNumberOfpages = pageToCalculate * page_6_to_10_each;
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );

                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    alreadyAddedPages = numberOfPages;

                                    $( '.js-webpage-error' ).html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );

                                }else if(  numberOfPages <= 5 ||  isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );

                                    localStorage.setItem( 'grandTotalPrev', grand_total );

                                    alreadyAddedPages = 0
                                }else {
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    alreadyAddedPages = 0;
                                }
                                
                            }else if( '10_plus' == websitePages ) {
                                if( numberOfPages > 10 ) {
                                    var pageToCalculate = numberOfPages - 10;
                                    priceByNumberOfpages = pageToCalculate * page_more_than_10_each;
                                    priceByNumberOfpages = priceByNumberOfpages + ( page_6_to_10_each * 5 );
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );

                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    alreadyAddedPages = numberOfPages;

                                    $( '.js-webpage-error' ).html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );

                                }else if( numberOfPages <= 10 || isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 10</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    alreadyAddedPages = 0;
                                }
                            }else {
                                console.log( 'less than 5 or equal to' );
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }
                        })

                        // Calculate Price By Webpage content
                        var priceByWebPageContent = 0;

                        $( document.body ).on( 'click', 'input[name="quote_webpage_content"]', function(e) {

                            // Reset
                            grand_total = parseInt( localStorage.getItem( 'grandTotalPrev' ), 10 );
                            $( '.js-total-price' ).html( localStorage.getItem( 'grandTotalPrev' ) );
                            $( 'input[name="number_of_content_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalAfterWebConent', grand_total );

                        })

                        $( document.body ).on( 'keyup', 'input[name="number_of_content_pages"]', function(e) {

                            var numberOfContentPages = parseInt( $( this ).val(), 10 );
                            var webpageContent = $( 'input[name="quote_webpage_content"]:checked' ).val();
                            grand_total = localStorage.getItem( 'grandTotalPrev' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'already_have' == webpageContent ) {
                                //  Do Nothing
                                console.log( 'already_have' )

                            }else if( 'need_content' == webpageContent ) {
                                priceByWebPageContent = numberOfContentPages * content_writting_per_page;

                                if( !isNaN( numberOfContentPages ) ) {
                                    // Update Grand Total Dom
                                    grand_total += priceByWebPageContent;
                                    $( '.js-total-price' ).html( grand_total );
                                    localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
                                }else {
                                    $( '.js-total-price' ).html( grand_total );
                                }

                            }
                        })

                        // Calculate price by dynamic content
                        var alreadyBlogAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_dynamic_content"]', function(e) {
                            var dynamicContent = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterWebConent' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'yes' == dynamicContent ) {
                                if( alreadyBlogAdded == false ) {
                                    grand_total += blog_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyBlogAdded = true;
                                    localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadyBlogAdded = false;
                                localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                            }
                        })

                        // Calculate Price By SEO
                        var alreadySeoAdded = false;
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_seo_audit"]', function(e) {
                            var seoAudit = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterDynamicContent' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'yes' == seoAudit ) {
                                if( alreadySeoAdded == false ) {
                                    grand_total += seo_audit_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadySeoAdded = true;
                                    localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadySeoAdded = false;
                                localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                            }

                            // Reset Next Step
                            $( 'input[name="quote_choose_cms"]' ).prop( 'checked', false );
                            $( '#js-quote-step-7' ).prop( 'disabled', true );
                            alreadyCmsAdded = false;
                        })

                        // Calculate Price By CMS
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_choose_cms"]', function(e) {
                            var chooseCms = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterSeoAudit' );
                            grand_total = parseInt( grand_total, 10 );

                            if( 'no_choice' == chooseCms || 'webcommander' == chooseCms ) {
                                $( '.js-total-price' ).html( grand_total );
                                alreadyCmsAdded = false;
                            }else {
                                if( alreadyCmsAdded == false ) {
                                    grand_total += cms_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyCmsAdded = true;
                                    localStorage.setItem( 'grandTotalAfterCms', grand_total );
                                }
                            }
                        })
                    }
                })

            }else if( 'quick' == designType ) {
                // Website Type
                $( document.body ).on( 'click', 'input[name="quote_website_type"]', function(e) {

                    var websiteType = $( this ).val();
                    if( 'ecommerce' == websiteType ) {
                        $('.js-quote-amount').show();
                        grand_total = ecommerce_quick_price;

                        // Update Grand Total Dom
                        $( '.js-total-price' ).html( grand_total );
                        
                        // Calculate Price By Product Qty
                        $( document.body ).on( 'click', 'input[name="quote_product_qty"]', function(e) {
                            var productQty = $( this ).val();
                            if( 'less_than_100' == productQty ) {
                                monthly_fee = ecommerce_quick_monthly_fee;
                            }else if( '100_to_1000' == productQty ) {
                                monthly_fee = ecommerce_quick_100_to_1000_product_per_month;
                            }else if( '1000_plus' == productQty ) {
                                monthly_fee = ecommerce_quick_more_than_1000_product_per_month;
                            }
    
                            // Update Monthly Fee Dom
                            $( '.js-monthly-price' ).html( monthly_fee );
                        });
    
    
                        // Calculate Price By Website Pages Qty
                        var priceByNumberOfpages = 0;
                        var grandTotalBeforeWebsitePages = grand_total;
                        var alreadyAddedPages = 0;
                        $( document.body ).on( 'click', 'input[name="quote_website_pages"]', function(e) {
    
                            // Reset
                            grand_total = grandTotalBeforeWebsitePages;
                            $( '.js-total-price' ).html( grand_total );
                            $( 'input[name="number_of_pages"]' ).val('');

                            // Reset
                            $( '.js-webpage-error' ).html('');

                            if( $( this ).val() == 'max_5' ) {
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }
    
                        });
    
                        $( document.body ).on( 'keyup', 'input[name="number_of_pages"]', function(e) {
                            var numberOfPages = $( 'input[name="number_of_pages"]' ).val();
                            numberOfPages = parseInt( numberOfPages, 10 );
    
                            var websitePages = $( 'input[name="quote_website_pages"]:checked' ).val();
    
                            if( 'max_10' == websitePages ) {
                                if( numberOfPages > 5 && numberOfPages <= 10 ) {
                                    var pageToCalculate = numberOfPages - 5;
                                    priceByNumberOfpages = pageToCalculate * quick_page_more_than_5_each;
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );
    
                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    $( '.js-webpage-error' ).html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );
    
                                    alreadyAddedPages = numberOfPages;
    
                                }else if(  numberOfPages <= 5 ||  isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html( '<span class="error">The value must be greater than 5 & less than or equal to 10</span>' )
                                    $( '.js-step-button' ).prop( 'disabled', true );
    
                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    alreadyAddedPages = 0;
                                }
                                
                            }else if( '10_plus' == websitePages ) {
                                if( numberOfPages > 10 ) {
                                    var pageToCalculate = numberOfPages - 10;
                                    priceByNumberOfpages = pageToCalculate * quick_page_more_than_5_each;
                                    priceByNumberOfpages = priceByNumberOfpages + ( quick_page_more_than_5_each * 5 );
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );

                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }

                                    $( '.js-webpage-error' ).html( '' );
                                    $( '.js-step-button' ).prop( 'disabled', false );
    
                                    alreadyAddedPages = numberOfPages;
    
                                }else if( numberOfPages <= 10 || isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html( '<span class="error">The value must be greater than 10</span>' )
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    alreadyAddedPages = 0;
                                }
                            }else {
                                console.log( 'less than 5 or equal to' );
                            }
                        })
    
                        // Calculate Price By Webpage content
                        var priceByWebPageContent = 0;
    
                        $( document.body ).on( 'click', 'input[name="quote_webpage_content"]', function(e) {
    
                            // Reset
                            grand_total = parseInt( localStorage.getItem( 'grandTotalPrev' ), 10 );
                            $( '.js-total-price' ).html( localStorage.getItem( 'grandTotalPrev' ) );
                            $( 'input[name="number_of_content_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
    
                        })
    
                        $( document.body ).on( 'keyup', 'input[name="number_of_content_pages"]', function(e) {
    
                            var numberOfContentPages = parseInt( $( this ).val(), 10 );
                            var webpageContent = $( 'input[name="quote_webpage_content"]:checked' ).val();
                            grand_total = localStorage.getItem( 'grandTotalPrev' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'already_have' == webpageContent ) {
                                //  Do Nothing
    
                            }else if( 'need_content' == webpageContent ) {
                                priceByWebPageContent = numberOfContentPages * content_writting_per_page;
    
                                if( !isNaN( numberOfContentPages ) ) {
                                    // Update Grand Total Dom
                                    grand_total += priceByWebPageContent;
                                    $( '.js-total-price' ).html( grand_total );
                                    localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
                                }else {
                                    $( '.js-total-price' ).html( grand_total );
                                }
    
                            }
                        })
    
                        // Calculate price by dynamic content
                        var alreadyBlogAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_dynamic_content"]', function(e) {
                            var dynamicContent = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterWebConent' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'yes' == dynamicContent ) {
                                if( alreadyBlogAdded == false ) {
                                    grand_total += blog_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyBlogAdded = true;
                                    localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadyBlogAdded = false;
                                localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                            }
                        })
    
                        // Calculate Price By SEO
                        var alreadySeoAdded = false;
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_seo_audit"]', function(e) {
                            var seoAudit = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterDynamicContent' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'yes' == seoAudit ) {
                                if( alreadySeoAdded == false ) {
                                    grand_total += seo_audit_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadySeoAdded = true;
                                    localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadySeoAdded = false;
                                localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                            }

                            // Reset Next Step
                            $( 'input[name="quote_choose_cms"]' ).prop( 'checked', false );
                            $( '#js-quote-step-7' ).prop( 'disabled', true );
                            alreadyCmsAdded = false;
                        })
    
                        // Calculate Price By CMS
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_choose_cms"]', function(e) {
                            var chooseCms = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterSeoAudit' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'no_choice' == chooseCms || 'webcommander' == chooseCms ) {
                                $( '.js-total-price' ).html( grand_total );
                                alreadyCmsAdded = false;
                            }else {
                                if( alreadyCmsAdded == false ) {
                                    grand_total += cms_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyCmsAdded = true;
                                    localStorage.setItem( 'grandTotalAfterCms', grand_total );
                                }
                            }
                        })
    
                    }else if( 'content' == websiteType ) {
                        $('.js-quote-amount').show();
                        grand_total = content_quick_price;
                        // Update Grand Total Dom
                        $( '.js-total-price' ).html( grand_total );
                        
                        // Calculate Price By Product Qty
                        $( document.body ).on( 'click', 'input[name="quote_product_qty"]', function(e) {
                            var productQty = $( this ).val();
                            if( 'less_than_100' == productQty ) {
                                monthly_fee = content_quick_monthly_fee;
                            }else if( '100_to_1000' == productQty ) {
                                monthly_fee = content_quick_100_to_1000_product_per_month;
                            }else if( '1000_plus' == productQty ) {
                                monthly_fee = content_quick_more_than_1000_product_per_month;
                            }
    
                            // Update Monthly Fee Dom
                            $( '.js-monthly-price' ).html( monthly_fee );
                        });
    
    
                        // Calculate Price By Website Pages Qty
                        var priceByNumberOfpages = 0;
                        var grandTotalBeforeWebsitePages = grand_total;
                        var alreadyAddedPages = 0;
                        $( document.body ).on( 'click', 'input[name="quote_website_pages"]', function(e) {
    
                            // Reset
                            grand_total = grandTotalBeforeWebsitePages;
                            $( '.js-total-price' ).html( grand_total );
                            $( 'input[name="number_of_pages"]' ).val('');

                            // Reset
                            $( '.js-webpage-error' ).html('');

                            if( $( this ).val() == 'max_5' ) {
                                localStorage.setItem( 'grandTotalPrev', grand_total );
                            }
                            
    
                        });
    
                        $( document.body ).on( 'keyup', 'input[name="number_of_pages"]', function(e) {
                            var numberOfPages = $( 'input[name="number_of_pages"]' ).val();
                            numberOfPages = parseInt( numberOfPages, 10 );
    
                            var websitePages = $( 'input[name="quote_website_pages"]:checked' ).val();
    
                            if( 'max_10' == websitePages ) {
                                if( numberOfPages > 5 && numberOfPages <= 10 ) {
                                    var pageToCalculate = numberOfPages - 5;
                                    priceByNumberOfpages = pageToCalculate * quick_page_more_than_5_each;
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );
    
                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }
    
                                    alreadyAddedPages = numberOfPages;
                                    $( '.js-webpage-error' ).html('');
                                    $( '.js-step-button' ).prop( 'disabled', false );
    
                                }else if(  numberOfPages <= 5 ||  isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html( '<span class="error">The value must be greater than 5 & less than or equal to 10</span>' )
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );
                                    $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 5 & less than or equal to 10 !</p>');
                                    $( '.js-step-button' ).prop( 'disabled', true );
                                    alreadyAddedPages = 0;
                                }
                                
                            }else if( '10_plus' == websitePages ) { 

                                if( numberOfPages > 10 ) {
                                    var pageToCalculate = numberOfPages - 10;
                                    priceByNumberOfpages = pageToCalculate * quick_page_more_than_5_each;
                                    priceByNumberOfpages = priceByNumberOfpages + ( quick_page_more_than_5_each * 5 );
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    if( numberOfPages != alreadyAddedPages ) {
                                        // Update Grand Total Dom
                                        grand_total += priceByNumberOfpages;
                                        $( '.js-total-price' ).html( grand_total );
                                        localStorage.setItem( 'grandTotalPrev', grand_total );
                                    }
    
                                    alreadyAddedPages = numberOfPages;
                                    $( '.js-webpage-error' ).html('');
                                    $( '.js-step-button' ).prop( 'disabled', false );
    
                                }else if( numberOfPages <= 10 || isNaN( numberOfPages ) ){
                                    // Reset
                                    grand_total = grandTotalBeforeWebsitePages;
                                    $( '.js-total-price' ).html( grand_total );

                                    $( '.js-webpage-error' ).html( '<span class="error">The value must be greater than 10</span>' )
                                    $( '.js-step-button' ).prop( 'disabled', true );

                                    localStorage.setItem( 'grandTotalPrev', grand_total );
                                    alreadyAddedPages = 0;
                                }else {
                                    alreadyAddedPages = 0;
                                }
                            }else {
                                console.log( 'less than 5 or equal to' );
                            }
                        })
    
                        // Calculate Price By Webpage content
                        var priceByWebPageContent = 0;
    
                        $( document.body ).on( 'click', 'input[name="quote_webpage_content"]', function(e) {

                            // Reset
                            grand_total = parseInt( localStorage.getItem( 'grandTotalPrev' ), 10 );
                            $( '.js-total-price' ).html( localStorage.getItem( 'grandTotalPrev' ) );
                            $( 'input[name="number_of_content_pages"]' ).val('');
                            localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
    
                        })
    
                        $( document.body ).on( 'keyup', 'input[name="number_of_content_pages"]', function(e) {
    
                            var numberOfContentPages = parseInt( $( this ).val(), 10 );
                            var webpageContent = $( 'input[name="quote_webpage_content"]:checked' ).val();
                            grand_total = localStorage.getItem( 'grandTotalPrev' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'already_have' == webpageContent ) {
                                //  Do Nothing
    
                            }else if( 'need_content' == webpageContent ) {
                                priceByWebPageContent = numberOfContentPages * content_writting_per_page;
    
                                if( !isNaN( numberOfContentPages ) ) {
                                    // Update Grand Total Dom
                                    grand_total += priceByWebPageContent;
                                    $( '.js-total-price' ).html( grand_total );
                                    localStorage.setItem( 'grandTotalAfterWebConent', grand_total );
                                }else {
                                    $( '.js-total-price' ).html( grand_total );
                                }
    
                            }
                        })
    
                        // Calculate price by dynamic content
                        var alreadyBlogAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_dynamic_content"]', function(e) {
                            var dynamicContent = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterWebConent' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'yes' == dynamicContent ) {
                                if( alreadyBlogAdded == false ) {
                                    grand_total += blog_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyBlogAdded = true;
                                    localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                                }
                            }else {

                                $( '.js-total-price' ).html( grand_total );
                                alreadyBlogAdded = false;
                                localStorage.setItem( 'grandTotalAfterDynamicContent', grand_total );
                            }
                        })
    
                        // Calculate Price By SEO
                        var alreadySeoAdded = false;
                        var alreadyCmsAdded = false;
                        $( document.body ).on( 'click', 'input[name="quote_seo_audit"]', function(e) {
                            var seoAudit = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterDynamicContent' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'yes' == seoAudit ) {
                                if( alreadySeoAdded == false ) {
                                    grand_total += seo_audit_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadySeoAdded = true;
                                    localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                                }
                            }else {
                                
                                $( '.js-total-price' ).html( grand_total );
                                alreadySeoAdded = false;
                                localStorage.setItem( 'grandTotalAfterSeoAudit', grand_total );
                            }

                            // Reset Next Step
                            $( 'input[name="quote_choose_cms"]' ).prop( 'checked', false );
                            $( '#js-quote-step-7' ).prop( 'disabled', true );
                            alreadyCmsAdded = false;
                        })
    
                        // Calculate Price By CMS
                        
                        $( document.body ).on( 'click', 'input[name="quote_choose_cms"]', function(e) {
                            var chooseCms = $( this ).val();

                            grand_total = localStorage.getItem( 'grandTotalAfterSeoAudit' );
                            grand_total = parseInt( grand_total, 10 );
    
                            if( 'no_choice' == chooseCms || 'webcommander' == chooseCms ) {
                                $( '.js-total-price' ).html( grand_total );
                                alreadyCmsAdded = false;
                            }else {
                                if( alreadyCmsAdded == false ) {
                                    grand_total += cms_price;
                                    $( '.js-total-price' ).html( grand_total );
                                    alreadyCmsAdded = true;
                                    localStorage.setItem( 'grandTotalAfterCms', grand_total );
                                }
                            }
                        })
                    }
                })

            }
        });

    }
    quoteFormHeaderCalculation();

    /**
     * Qoute Form Validation
     * @author Rabiul
     */
    var quoteFormValidation = function() {
        // Design Type Step Validation
        var designTypeBtn = '#js-quote-step-2-1';
        $( designTypeBtn ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_design_type"]', function(e) {
            $( designTypeBtn ).prop( 'disabled', false );
        })

        // Website Type Validation
        var websiteTypeBtn = '#js-quote-step-2-2';
        $( websiteTypeBtn ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_website_type"]', function(e) {
            $( websiteTypeBtn ).prop( 'disabled', false );
        })

        // Product Type Validation
        var productType = '#js-quote-step-2-3';
        $( productType ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_product_type"]', function(e) {
            $( productType ).prop( 'disabled', false );
        })

        // Product Qty Validation
        var productQty = '#js-quote-step-2-4';
        $( productQty ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_product_qty"]', function(e) {
            $( productQty ).prop( 'disabled', false );
        })

        // Website Page Validation
        $( 'input[name="number_of_pages"]' ).hide();
        $( '#js-quote-step-3-1' ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_website_pages"]', function(e) {
            var value = $( this ).val();
            if('max_10' ==  value ) {
                $( 'input[name="number_of_pages"]' ).show();
                $( '#js-quote-step-3-1' ).prop( 'disabled', true );
            }else if( '10_plus' == value ) {
                $( 'input[name="number_of_pages"]' ).show();
                $( 'input[name="number_of_pages"]' ).val(11);
                $( '#js-quote-step-3-1' ).prop( 'disabled', true );
            }else if( 'max_5' == value ) {
                $( 'input[name="number_of_pages"]' ).hide();
                $( '#js-quote-step-3-1' ).prop( 'disabled', false );
            }else {
                $( 'input[name="number_of_pages"]' ).hide();
            }
        })

        // Website Content Validation
        var websiteContent = '#js-quote-step-4';
        $( '.number-of-pages' ).hide();
        $( websiteContent ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_webpage_content"]', function(e) {
            $( '.js-webpage-error' ).html('');
            var websiteContentValue = $( this ).val();
            if( 'need_content' == websiteContentValue ) {
                $( '.number-of-pages' ).show();
                $( 'input[name="number_of_content_pages"]' ).show();
                $( websiteContent ).prop( 'disabled', true );
                $( document.body ).on( 'keyup', 'input[name="number_of_content_pages"]', function(e) {
                    var numberOfPages = $( 'input[name="number_of_content_pages"]' ).val();
                    if( numberOfPages <= 0 || numberOfPages == '' || numberOfPages == null ) {
                        $( '.js-webpage-error' ).html('<p class="js-quote-error">The value must be greater than 0 !</p>');
                        $( websiteContent ).prop( 'disabled', true );
                    }else{
                        $( '.js-webpage-error' ).html('');
                        $( websiteContent ).prop( 'disabled', false );
                    }
                })
            }else {
                $( '.number-of-pages' ).hide();
                $( 'input[name="number_of_content_pages"]' ).hide();
                $( websiteContent ).prop( 'disabled', false );
            }
        })

        // Dynamic Content Validation
        var dynamicContent = '#js-quote-step-5'; 
        $( dynamicContent ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_dynamic_content"]', function(e) {
            $( dynamicContent ).prop( 'disabled', false );
            
        })

        // Seo Audit Validation
        var seoAudit = '#js-quote-step-6';
        $( seoAudit ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_seo_audit"]', function(e) {
            $( seoAudit ).prop( 'disabled', false );
        })

        // Choose CMS Validation
        var chooseCMS = '#js-quote-step-7';
        $( 'input[name="other_cms"]' ).hide();
        $( chooseCMS ).prop( 'disabled', true );
        $( document.body ).on( 'click', 'input[name="quote_choose_cms"]', function(e) {
            $( 'input[name="other_cms"]' ).val(''); 
            var cms = $(this).val();
            if( 'other' == cms ) {
                $( chooseCMS ).prop( 'disabled', true );
                $( 'input[name="other_cms"]' ).show(); 
                $(document.body).on( 'keyup', 'input[name="other_cms"]', function(e) {
                    $( chooseCMS ).prop( 'disabled', false );
                })
            }else {
                $( chooseCMS ).prop( 'disabled', false );
                $( 'input[name="other_cms"]' ).hide(); 
            }
        })

        // Select Page validation
        var selectPages = '#js-quote-step-3-2';
        $( document.body ).on( 'click', 'input[name="quote_choose_page[]"]', function(e) {
            $( selectPages ).prop( 'disabled', false );
        })

        
    }
    quoteFormValidation();

    /**
     * Quote Form Calculation
     * @author Rabiul
     */
    var quoteForm = function() {
        var stepButton = '.js-step-button';
        var stepbackButton = '.js-step-back-button';

        // Step Forward
        $( document.body ).on( 'click', stepButton, function(e) {
            e.preventDefault();
            var nextStep = $( this ).data( 'next' );
            var prevStep = $( this ).data( 'prev' );
        
            $( '.'+nextStep ).removeClass( 'hidden-step' ).addClass( 'active-step' );
            $( '.'+prevStep ).addClass( 'hidden-step' ).removeClass( 'active-step' );

            // Counter
            var counter = $( this ).data( 'counter' );
            var line_size = counter*10;

            window.steps = counter;
            var websiteType = $( 'input[name="quote_website_type"]:checked' ).val();
            if( 'content' == websiteType ) { // for skip ecommerce
                    if( window.steps > 4 ) {
                        var skipCounter = window.steps - 2;
                        var skipLine = skipCounter * 12.5;
                        $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+skipLine+"% - 35px);'>"+skipCounter+"/ 8</div><div class='progress-bar' role='progressbar' style='width: "+skipLine+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
                    }else{
                        $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+line_size+"% - 35px);'>"+counter+"/ 8</div><div class='progress-bar' role='progressbar' style='width: "+line_size+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
                    }
            }else{
                $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+line_size+"% - 35px);'>"+counter+"/ 10</div><div class='progress-bar' role='progressbar' style='width: "+line_size+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
            }
            
        })

        // Step Back
        $( document.body ).on( 'click', stepbackButton, function(e) {
            e.preventDefault();
            var nextStep = $( this ).data( 'next' );
            var prevStep = $( this ).data( 'prev' );
        
            $( '.'+nextStep ).removeClass( 'hidden-step' ).addClass( 'active-step' );
            $( '.'+prevStep ).addClass( 'hidden-step' ).removeClass( 'active-step' );

            // Counter
            var counter = $( this ).data( 'counter' );
            var line_size = counter*10;

            window.steps = counter;
            var websiteType = $( 'input[name="quote_website_type"]:checked' ).val();
            if( 'content' == websiteType ) { // for skip ecommerce
                    if( window.steps > 1 ) {
                        var skipCounter = window.steps - 2;
                        var skipLine = skipCounter * 12.5;
                        $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+skipLine+"% - 35px);'>"+skipCounter+"/ 8</div><div class='progress-bar' role='progressbar' style='width: "+skipLine+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
                    }else{
                        $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+line_size+"% - 35px);'>"+counter+"/ 10</div><div class='progress-bar' role='progressbar' style='width: "+line_size+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
                    }
            }

            if( 'content' != websiteType ) {
                if(counter>0){
                    $( '#js-progress-item' ).html ("<div class='counter-step' style='left: calc("+line_size+"% - 35px);'>"+counter+"/ 10</div><div class='progress-bar' role='progressbar' style='width: "+line_size+"%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");
                }else{
                    $( '#js-progress-item' ).html ("<div class=''></div><div class='progress-bar' role='progressbar' style='width: 0%;' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>");  
                }
            }

        })


        var quoteForm = '#webalive-quote-form';

        $( document.body ).on( 'submit', quoteForm, function(e) {
            e.preventDefault();
            var designType          = $( 'input[name="quote_design_type"]:checked' ).val(),
                websiteType         = $( 'input[name="quote_website_type"]:checked' ).val(),
                productType         = $( 'input[name="quote_product_type"]:checked' ).val(),
                productQty          = $( 'input[name="quote_product_qty"]:checked' ).val(),
                websitePages        = $( 'input[name="quote_website_pages"]:checked' ).val(),
                numberOfPages       = $( 'input[name="number_of_pages"]' ).val(),
                webPageContent      = $( 'input[name="quote_webpage_content"]:checked' ).val(),
                numberOfWebPageContent = $( 'input[name="number_of_content_pages"]' ).val(),
                dynamicContent      = $( 'input[name="quote_dynamic_content"]:checked' ).val(),
                seoAudit            = $( 'input[name="quote_seo_audit"]:checked' ).val(),
                chooseCMS           = $( 'input[name="quote_choose_cms"]:checked' ).val(),
                customCMS           = $( 'input[name="other_cms"]' ).val();

                // Choose Page
                var choosePage = [];
                $.each( $( 'input[name="quote_choose_page[]"]:checked' ), function(e) {
                    var dataDesc = $(this).attr("data-desc");
                    var dataTit = $( this ).val();
                    // choosePage.push( $( this ).val() );
                    choosePage.push({'Title': dataTit, 'Desc': dataDesc});

                });

            $.ajax({
                url: public_localizer.ajax_url,
                type: 'post',
                data: {
                    action: 'submit_quote_form', // [ N.B: inc/quote-form/quote-form.php  ]
                    design_type: designType, 
                    website_type: websiteType, 
                    product_type: productType, 
                    product_qty: productQty, 
                    website_pages: websitePages, 
                    number_of_pages: numberOfPages, 
                    web_page_content: webPageContent,
                    number_of_webpage_content: numberOfWebPageContent,
                    dynamic_content: dynamicContent,
                    seo_audit: seoAudit,
                    choose_cms: chooseCMS,
                    custom_cms: customCMS,
                    choose_page: choosePage,
                },
                beforeSend: function() {

                },
                success: function( res ) {
                  
                    var data = JSON.parse( res ); 
                    console.log( data );
                    if( '' != data ) {
                        $( '.js-quote-step-7' ).hide();
                        $( '.js-quote-step-8' ).show();
                        // appnedTo.append( template( data ) );
                        window.quoteInfo = data;
                        localStorage.clear();
                        $( '.js-get-quote-estimation' ).removeClass( 'hidden-step' );
                    }
                }
            })
        })
    }
    quoteForm();

    /**
     * Check valid Email
     * @author Rabiul
     */
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    /**
     * Estimation Email Validation
     * @author Rabiul
     */
    var estimationEmailValidation = function() {
        // For Text Fields
        $( '#quote-estimation-email input[type="text"]' ).on('blur', function(e) {
            var value = $( this ).val();

            if( value.length > 2 ) {
                $( this ).removeClass( 'error' );
            }else {
                $( this ).addClass( 'error' );
            }
        })

        // For Email Fields
        $( '#quote-estimation-email input[type="email"]' ).on('blur', function(e) {
            var emailValue = $( this ).val();

            if( isEmail( emailValue ) ) {
                $( this ).removeClass( 'error' );
            }else {
                $( this ).addClass( 'error' );
            }
        })
    }
    estimationEmailValidation();
    

    /**
     * Sent Quote Estimation Email
     * @author Rabiul
     */
    var estimationEmail = function() {

        var estimationEmailForm = 'form#quote-estimation-email';

        $( estimationEmailForm ).on( 'submit', function(e) {
            e.preventDefault();

            // Form Validation
            var quoteName = $( 'input[name="name"]' ).val();
            var quoteCompany = $( 'input[name="company"]' ).val();
            var quoteEmail = $( 'input[name="email"]' ).val();
            var quotePhone = $( 'input[name="phone"]' ).val();

            if( '' != quoteName && '' != quoteCompany && '' != quoteEmail && '' != quotePhone ) {
                $.ajax({
                    url: public_localizer.ajax_url,
                    type: 'post',
                    data: {
                        action: 'sent_quote_email', // [ N.B: inc/quote-form/quote-form.php ]
                        fields: $( 'form#quote-estimation-email' ).serialize(),
                        quoteInfo: window.quoteInfo,
                    },
                    beforeSend: function() {
    
                    },
                    success: function(res) {
                        var data = JSON.parse( res );
                        $( ".loader-last" ).show();
                        if( '200' == data ) {
                            window.location.replace( public_localizer.home_url + '/thank-you' );
                        }else {
                            $( '.js-email-notice' ).html( '<span class="error">Something went wrong!</span>' );
                        }
                    }
                })
            }else {
                if( '' == quoteName ) {
                    $( '#quote-name' ).addClass( 'error' );
                }else {
                    $( '#quote-name' ).removeClass( 'error' );
                }
    
                if( '' == quoteCompany ) {
                    $( '#quote-company' ).addClass( 'error' );
                }else {
                    $( '#quote-company' ).removeClass( 'error' );
                }
    
                if( isEmail( quoteEmail ) ) {
                    $( '#quote-email' ).removeClass( 'error' );
                }else {
                    $( '#quote-email' ).addClass( 'error' );
                }
    
                if( '' == quotePhone ) {
                    $( '#quote-phone' ).addClass( 'error' );
                }else {
                    $( '#quote-phone' ).removeClass( 'error' );
                }
            }
        })

    }
    estimationEmail();

    /**
     * Skipping form non ecommerce
     * @author Rabiul
     */
    var skippingNonEcommerce = function() {
        $( document.body ).on( 'change', 'input[name="quote_website_type"]', function(e) { 
            var websiteType = $( 'input[name="quote_website_type"]:checked' ).val();
            if( 'content' == websiteType ) {
                $( '.js-quote-step-2-3' ).hide();
                $( '.js-quote-step-2-4' ).hide();
                // setp forward
                $( '#js-quote-step-2-2' ).data( 'next', 'js-quote-step-3-1' );

                // setp back
                $( '.js-quote-step-3-1 .js-step-back-button' ).data( 'next', 'js-quote-step-2-2' );

            }else {
                $( '.js-quote-step-2-3' ).show();
                $( '.js-quote-step-2-4' ).show();

                // setp forward
                $( '#js-quote-step-2-2' ).data( 'next', 'js-quote-step-2-3' );
                // setp back
                $( '.js-quote-step-3-1 .js-step-back-button' ).data( 'next', 'js-quote-step-2-4' );

                $( '#js-quote-step-2-3' ).prop( 'disabled', true );
            }
        })
    }
    skippingNonEcommerce();

    /**
     * Hide Help Link
     * @author Rabiul
     */
    var hideHelp = function() {
        $( '.js-step-button' ).on( 'click', function(e) {
            $( '.get-help' ).hide();
            $( '.js-steps-count' ).show();
        })
    }
    hideHelp();


    $('#hone').on('click', function(e) {
        $('#hone').toggleClass("active");
        $('#htwo').removeClass("active");
    });
    $('#htwo').on('click', function(e) {
        $('#htwo').toggleClass("active");
        $('#hone').removeClass("active");
    });
    $('#hthree').on('click', function(e) {
        $('#hthree').toggleClass("active");
    });



    /**
     * Back Functionalities
     * @author Rabiul
     */
    var onBackLinkClick = function() {
        $( document.body ).on( 'click', '.js-step-back-button', function(e) {
            e.preventDefault();
            $( this ).parents( 'section' ).find( 'input[type="radio"]' ).prop( 'checked', false );
            $( this ).parents( 'section' ).find( 'input[type="checkbox"]' ).prop( 'checked', false );
            $( this ).parents( 'section' ).find( 'input:text' ).val( '' ).hide(); //
            $( this ).parents( 'section' ).find( 'button.js-step-button' ).prop( 'disabled', true );
            $( '.js-webpage-error' ).html( '' );

            // Special case ( Hide the entire div )
            $( this ).parents( 'section' ).find( '.number-of-pages' ).hide();
        })
    }
    onBackLinkClick();

 
})(jQuery);