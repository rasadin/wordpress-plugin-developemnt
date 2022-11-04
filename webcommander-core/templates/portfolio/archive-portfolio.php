<?php 
/**
 * Portfolio Template
 * 
 * @since 1.0.0
 */
get_header(); ?>
<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Have a look at a few of our client websites and get the WebCommander experience</h1>
            </div>
        </div>
    </div>
</div>
<div class="container container-lg">
    <div class="row">
        <div class="col-md-12">
            <div id="primary" class="webalive-content-area">
				<main id="main" class="webalive-site-main">
                    <?php echo do_shortcode('[wcc_portfolios]'); ?>
                     <!-- Appned Ajax Rendered Data -->
                    <div class="row js-portfolio-appender">
                        <script type="text/html" id="tmpl-load-portfolios">
                            <# _.each( data.portfolios, function( portfolio, index ) { #>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="portfolio-item">
                                        <div class="portfolio-img">
                                            <img src="{{portfolio.thumbanil_url}}" alt="{{portfolio.title}}">
                                            <div class="p-hover">
                                                <a href="#" onclick="portfolioPopUp(event, {{portfolio.id}})">Preview</a>
                                            </div>
                                        </div>
                                        <div class="portfolio-content">
                                            <h4>{{portfolio.title}}</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Popup -->
                                <div class="portfolio-popup" id="portfolio-popup-{{portfolio.id}}">
                                    <div class="button-close">
                                        <a href="#" class="btn btn-default" onclick="closePopup(event, {{portfolio.id}})">Close</a>   
                                    </div>
                                    <div class="popup-topbar">                        
                                        <div class="wrap-content">
                                            <div class="left-part">
                                                <h2>{{portfolio.title}}</h2>
                                                <p>Visit Site: <a href="{{portfolio.portfolio_site_url}}" target="_blank">{{portfolio.portfolio_site_label}}</a></p>
                                            </div>
                                            <div class="right-part">
                                                <a href="#" class="button-style-2-indp js-free-signup">Start for Free</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup-preview">
                                        <img src="{{portfolio.thumbanil_url}}" alt="{{portfolio.title}}">
                                    </div>
                                </div>
                            <# }) #>
                        </script>
                    </div>

                    <!-- Load more button -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-info btn-lg load-btn js-load-more-portfolio">Load More</button>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
<?php 
get_footer();