<?php
/**
 * ========================================================
 * # Quote Form
 * ========================================================
 */

class QuoteForm {
    
    /**
     * Construct Form
     * @author Rabiul
     */
    public function __construct() {
        add_shortcode( 'webalive_quote_form', [ $this, 'form_shortcode' ] );
        add_action( 'wp_ajax_submit_quote_form', [ $this, 'submit_quote_form' ] );
        add_action( 'wp_ajax_nopriv_submit_quote_form', [ $this, 'submit_quote_form' ] );
        add_action( 'wp_ajax_sent_quote_email', [ $this, 'sent_quote_email' ] );
        add_action( 'wp_ajax_nopriv_sent_quote_email', [ $this, 'sent_quote_email' ] );
    }

    /**
     * Form Shortcode
     * @author Rabiul 
     * @mockup Sultan
     */
    public function form_shortcode( $atts, $content = null ) {

        $options = extract( shortcode_atts( array(
            ''
        ), $atts ) );

        $return_html = '';
        ob_start();
        ?>
        
        <!-- Quote Form Starts -->
        <div class="steps-container">
            <div class="steps-header">
                <a href="http://www.webalive.com.au/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/source/img/login-screen.png" alt="" class="logo">
                </a>
                <a target="_blank" href="<?php echo esc_url(home_url())?>/contact-us/" class="get-help">Get Help</a>
                <div class="amount js-quote-amount">
                    <div class="total">$ <span class="js-total-price"></span></div>
                    <span>+$<span class="js-monthly-price">55</span> / m</span>
                </div>
            </div>
            <form id="webalive-quote-form">
                <div class="steps-content-container">
                    <!-- Beginning Step -->
                    <section class="beginning-step js-quote-step-1">
                        <h1>Get an Instant Quote for Your Website</h1>
                        <div class="content">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/beginning-step.png" alt="">
                            <article>
                                <p>
                                    Want to know how much your website will cost? Our online calculator will give you a decent estimate without requiring you to sit through a sales meeting. This calculator uses the same parameters and values we use for determining project costs for our potential clients.
                                </p>

                                <p>Just answer the following questions, and you’ll get an instant quote. It only takes a few minutes.</p>
                                <h3>How it works</h3>
                                <ul>
                                    <li>Answer 7 to 10 questions depending on your project requirements.</li>
                                    <li>You’ll get an estimated cost for your project, which will be very close to the real cost.</li>
                                </ul>
                                <p>Your answers are kept confidential. You don’t need to provide any contact information for viewing the final result. </p>
                            </article>
                        </div>
                        <button class="btn btn-primary js-step-button js-step-counter-1" data-next="js-quote-step-2-1" data-prev="js-quote-step-1" data-counter="1">Let's Begin</button>
                    </section>
                    <!-- Setp 2 - 1 -->

                    <section class="hidden-step step-1 js-quote-step-2-1">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>What type of design process do you prefer?</h2>
                                    <p>Regardless of the process you choose, we’ll design your website with the utmost care. </p>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="checkbox-1" type="radio" value="custom" name="quote_design_type">
                                        <label for="checkbox-1" class="custom-designed-website"><span>Custom designed website</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="checkbox-2" type="radio" value="quick" name="quote_design_type">
                                        <label for="checkbox-2" class="quick-designed-website"><span>Quick designed website</span></label>
                                    </div>
                                </div>
                                <div class="hints" id="accordion">
                                    <ul class="nav nav-tabs">
                                        <li><a data-toggle="collapse" href="#1" data-target="#1" role="button" aria-expanded="false" aria-controls="accordion" id="hone">What is custom designed website?</a></li>
                                        <li><a data-toggle="collapse" href="#2" data-target="#2" role="button" aria-expanded="false" aria-controls="accordion" id="htwo">What is quick designed website?</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="1" class="collapse colp-box" aria-labelledby="hone" data-parent="#accordion">
                                            <h4>Custom designed website with a consultative design process.</h4>
                                            <p>Our team will have a thorough discussion with you. We’ll audit your requirements and set a suitable design strategy to meet your goals. Our expert copywriters will create content for your website (if required). If you need to have any special features on your site that need extensive developer support, then this is the right option for you. </p>
                                            <ul>
                                                <li>Consultation</li> |
                                                <li>Audit & Strategy</li> |
                                                <li>Consent Creation & Revision</li> |
                                                <li>Development </li>
                                            </ul>
                                        </div>
                                        <div id="2" class="collapse colp-box" aria-labelledby="htwo" data-parent="#accordion">
                                            <h4>Quick-designed website that gets you up and running fast.</h4>
                                          <p>You’ll select a template from our extensive template library. Our templates come with many out-of-the-box features that’ll meet your general needs. We’ll further adjust the design based on your content and requirements. If you want a regular site that doesn’t need to have custom-made features, then this is the right option for you.</p>
                                            <ul>
                                                <li>Template Selection</li> |
                                                <li>Content Population</li> |
                                                <li>Adjustment</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <button id="js-quote-step-2-1" class="btn btn-primary js-step-button js-quote-design-type js-step-counter-2" data-next="js-quote-step-2-2" data-prev="js-quote-step-2-1" data-counter="2">Next question</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 - 2 -->
                    <section class="hidden-step step-2 js-quote-step-2-2">
                        <div class="step">
                            <div class="content">
                            <div class="heading">
                                <h2>Do you want to sell products or services from your site?</h2>
                            </div>
                                <div class="option" id="accordion1">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-1" type="radio" value="ecommerce" name="quote_website_type">
                                        <label for="radio-1" class="yes"><span>Yes</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-2" type="radio" value="content" name="quote_website_type">
                                        <label for="radio-2" class="no"><span>No</span></label>
                                    </div>
                                </div>
                                <div class="hints">
                                    <ul class="nav nav-tabs">
                                        <li><a data-toggle="collapse" href="#3" data-target="#3" role="button" aria-expanded="false" aria-controls="accordion1" id="hthree">Why does it matter?</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="3" class="collapse colp-box colp-three" aria-labelledby="hthree" data-parent="#accordion1">
                                        <p>If you want to sell products or services on your website you’ll need to have a payment processor, a shopping cart, and other ecommerce components. Our ecommerce team will work with you to figure out your requirements and find out the right solution for you.</p>

                                        </div>
                                    </div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-2-2" class="btn btn-primary js-step-button js-quote-website-type js-step-counter-3" data-next="js-quote-step-2-3" data-prev="js-quote-step-2-2" data-counter="3">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button js-quote-website-type" data-next="js-quote-step-2-1" data-prev="js-quote-step-2-2"  data-counter="1">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 - 3 -->
                    <section class="hidden-step step-2-2 js-quote-step-2-3">
                        <div class="step">
                            <div class="content">
                            <div class="heading">
                                <h2>What do you want to sell on your website?</h2>
                            </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-3" type="radio" value="physical" name="quote_product_type">
                                        <label for="radio-3" class="physical-products"><span>Physical Products or Services</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-4" type="radio" value="virtual" name="quote_product_type">
                                        <label for="radio-4" class="virtual-product-or-services"><span>Virtual Products or Services</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-5" type="radio" value="others" name="quote_product_type">
                                        <label for="radio-5" class="something-else"><span>Something Else</span></label>
                                    </div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-2-3" class="btn btn-primary js-step-button js-step-counter-4" data-next="js-quote-step-2-4" data-prev="js-quote-step-2-3" data-counter="4">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-2-2" data-prev="js-quote-step-2-3" data-counter="2">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 - 4 -->
                    <section class="hidden-step step-2-2 js-quote-step-2-4">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>How many items are you planning to sell online?</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-6" type="radio" value="less_than_100" data-monthly-price="0" name="quote_product_qty">
                                        <label for="radio-6" class="lessthan"><span>Less than 100</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-7" type="radio" value="100_to_1000" data-monthly-price="110" name="quote_product_qty">
                                        <label for="radio-7" class="between"><span>Between 100 to 1000</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-8" type="radio" value="1000_plus" data-monthly-price="385" name="quote_product_qty">
                                        <label for="radio-8" class="morethan"><span>More than 1000</span></label>
                                    </div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-2-4" class="btn btn-primary js-step-button js-quote-product-qty js-step-counter-5" data-next="js-quote-step-3-1" data-prev="js-quote-step-2-4" data-counter="5">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button js-quote-product-qty" data-next="js-quote-step-2-3" data-prev="js-quote-step-2-4" data-counter="3">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 3 - 1 -->
                    <section class="hidden-step step-3 js-quote-step-3-1">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>How many pages do you need for your website?</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-9" type="radio" value="max_5" data-price="" name="quote_website_pages">
                                        <label for="radio-9" class="maximum"><span>Maximum 5</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-10" type="radio" value="max_10" data-price="385" name="quote_website_pages">
                                        <label for="radio-10" class="between"><span>Maximum 10</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-11" type="radio" value="10_plus" data-price="55" name="quote_website_pages">
                                        <label for="radio-11" class="morethan"><span>More than 10</span></label>
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="form-group">
                                        <input type="text" name="number_of_pages" placeholder="Please specify an approximate number of pages">
                                    </div>
                                    <div class="js-webpage-error"></div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-3-1" class="btn btn-primary js-step-button js-quote-website-pages js-step-counter-6" data-next="js-quote-step-3-2" data-prev="js-quote-step-3-1" data-counter="6">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button js-quote-website-pages" data-next="js-quote-step-2-4" data-prev="js-quote-step-3-1" data-counter="4">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 3 - 2 -->
                    <section class="hidden-step step-3-1 js-quote-step-3-2">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>Which pages do you want your site to have?</h2>
                                </div>
                                <div class="option" id="pagestable">
                                    <div class="form-group">
                                        <div class="pages">
                                            <input class="box-style" id="home-page" value="Home" type="checkbox" data-desc="The homepage is the main page of your site. Most of your visitors will land here. It’s extremely important to make your homepage design align with your business or brand." name="quote_choose_page[]">
                                            <label for="home-page" class="home"><span>Home</span></label>
                                        </div>
                                        <p>
                                            The homepage is the main page of your site. Most of your visitors will land here. It’s extremely important to make your homepage design align with your business or brand.
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <div class="pages">
                                            <input class="box-style" id="about-page" value="About" data-desc="About us page is essential for improving the credibility and trustworthiness of your website. It gives you the opportunity to tell your customers who you are and what your business is about." type="checkbox" name="quote_choose_page[]">
                                            <label for="about-page" class="about-us"><span>About Us</span></label>
                                        </div>
                                        <p>About us page is essential for improving the credibility and trustworthiness of your website. It gives you the opportunity to tell your customers who you are and what your business is about. </p>
                                    </div>
                                    <div class="form-group">
                                        <div class="pages">
                                            <input class="box-style" id="service-page" value="Services"  data-desc="This page categorises all services your business provides. It’s a common page that helps your potential customers get an overview of your company’s ability and skills." type="checkbox" name="quote_choose_page[]">
                                            <label for="service-page" class="services"><span>Services</span></label>
                                        </div>
                                        <p>This page categorises all services your business provides. It’s a common page that helps your potential customers get an overview of your company’s ability and skills.</p>
                                    </div>
                                    <div class="form-group">
                                        <div class="pages">
                                            <input class="box-style" id="contact-page" value="Contact"  data-desc=" A must-have for any website. Contact us page lets your potential and existing customers or other interested parties communicate with you." type="checkbox" name="quote_choose_page[]">
                                            <label for="contact-page" class="contact-us"><span>Contact us</span></label>
                                        </div>
                                        <p>
                                            A must-have for any website. Contact us page lets your potential and existing customers or other interested parties communicate with you.
                                        </p>
                                    </div>
                                    <div class="form-group" id="last-default-item">
                                        <div class="pages">
                                            <input class="box-style" id="shop-page" value="Shop"  data-desc="Obviously, your shop will have many pages depending on the items you want to sell. You’ll need to have a common product page structure and features based on your product/service type." type="checkbox" name="quote_choose_page[]">
                                            <label for="shop-page" class="shop"><span>Shop</span></label>
                                        </div>
                                        <p>Obviously, your shop will have many pages depending on the items you want to sell. You’ll need to have a common product page structure and features based on your product/service type.</p>
                                    </div>
                                    <div class="form-group" id="remove-add-more-dom">
                                        <div class="pages" id="first-add-btn">
                                            <input class="box-style" id="radio-17" type="radio" name="addmore">
                                            <label for="radio-17" class="add-more"  id="addPageBtn" onclick="ShowPopUp()"><span>Add More Page</span></label>
                                        </div>
                                        <p></p>
                                    </div>
                                    
                                <!-- add another page btn-->
                                <div class="add-ano">
                                     <div class='addAnother'  id='addAnother' onclick='ShowPopUp()'>Add Another</div>
                                </div>
                                </div>

                                <!-- Forward -->
                                <button id="js-quote-step-3-2" class="btn btn-primary js-step-button js-step-counter-7" data-next="js-quote-step-4" data-prev="js-quote-step-3-2" data-counter="7">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-3-1" data-prev="js-quote-step-3-2" data-counter="5">Back</button>
                                
                            </div>
                        </div>
                   
                    </section>
                    <!-- The Modal ( @author Rasadin )-->
                    <div class="modal-add-more">
                        <div id="myModal" class="modal">
                        <!-- Modal content -->
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3> Add Page</h3>
                                        <span class="close-popup" onclick="deletePopUp()"> </span>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" placeholder="Page name*" name="page-name" id="page-name">
                                        <span class="page-name-err" id="page-name-err">This field is required.</span>
                                        <textarea name="page-desc" placeholder="Page description*" id="page-desc" cols="30" rows="5"></textarea>
                                        <span class="page-desc-err" id="page-desc-err">This field is required.</span>
                                        <div class="add-more-page" onclick="addMorePages()">Save</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ( @author Rasadin ) -->
                    <script>
                        document.getElementById('myModal').style.display = "none";
                        document.getElementById("addAnother").style.display = "none";
                        document.getElementById("page-name-err").style.display = "none";
                        document.getElementById("page-desc-err").style.display = "none";
                        var tasks = [];
                        var descs = [];
                        // Get the modal
                        var modal = document.getElementById('myModal');
                        // Get the button that opens the modal
                        var btn = document.getElementById("addPageBtn");
                        // When the user clicks the button, open the modal 
                        btn.onclick = function() {
                        modal.style.display = "block";
                        }
                        // When the user clicks on <span> (x), close the modal
                        function deletePopUp() {
                        modal.style.display = "none";
                        }
                        // When the user clicks the button, open the modal 
                        function ShowPopUp() {
                        document.getElementById('page-name').value = '';
                        document.getElementById('page-desc').value = '';
                        modal.style.display = "block";
                        }
                        // When the user clicks the save button
                        function addMorePages() {
                        if( document.getElementById('page-name').value != '' && document.getElementById('page-name').value.replace(/\s/g,"") !="" && document.getElementById('page-desc').value != '' && document.getElementById('page-desc').value.replace(/\s/g,"") !=""){
                            var newPageId = document.getElementById("page-name").value;
                            var newPageDesc = document.getElementById("page-desc").value;
                            var lowNewPageId = newPageId.toLowerCase();
                            var noSpaceId = lowNewPageId.replace(/\s/g,'-'); // replace the space with '-'
                            var h = document.getElementById("last-default-item");
                            h.insertAdjacentHTML("afterend", "<div class='form-group'><div class='pages'><input class='box-style' id='"+noSpaceId+"-page' value='"+noSpaceId+"' data-desc='"+newPageDesc+"' type='checkbox' name='quote_choose_page[]' checked><label for='"+noSpaceId+"-page' class='extra-form-page'><span>" + document.getElementById("page-name").value + "</span></label></div><p>" + document.getElementById("page-desc").value + "</p></div></div>");
                            modal.style.display = "none";
                            document.getElementById("addAnother").style.display = "inline-block";
                            var myobj = document.getElementById("remove-add-more-dom");
                            if(myobj){
                                myobj.remove();
                            }
                            document.getElementById("page-name-err").style.display = "none";
                            document.getElementById("page-desc-err").style.display = "none";
                        }else{
                            if(document.getElementById('page-name').value == '' || document.getElementById('page-name').value.replace(/\s/g,"") == ""){
                                document.getElementById("page-name-err").style.display = "block";
                            }else{
                                document.getElementById("page-name-err").style.display = "none";
                            }
                            if(document.getElementById('page-desc').value == '' || document.getElementById('page-desc').value.replace(/\s/g,"") ==""){
                                document.getElementById("page-desc-err").style.display = "block";
                            }else{
                                document.getElementById("page-desc-err").style.display = "none";
                            }
                        }
                        }
                    </script>   
                    
                    <!-- Step 4 -->
                    <section class="hidden-step step-4 js-quote-step-4">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>Website content is a very important part of any website. It has to be put together with a great deal of care to help you rank well in search engines and convert potential customers.</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-18" type="radio" value="already_have" name="quote_webpage_content">
                                        <label for="radio-18"><span>I already have the content for my website.</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-19" type="radio" value="need_content" name="quote_webpage_content">
                                        <label for="radio-19"><span>I need WebAlive to create content for me.</span></label>
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="form-group number-of-pages">
                                        <label for="">Approximately how many pages of content do you need?</label>
                                        <input type="text" name="number_of_content_pages" placeholder="e.g: 5">
                                    </div>
                                     <div class="js-webpage-error"></div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-4" class="btn btn-primary js-step-button js-step-counter-8" data-next="js-quote-step-5" data-prev="js-quote-step-4" data-counter="8">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-3-2" data-prev="js-quote-step-4" data-counter="6">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 5 -->
                    <section class="hidden-step step-4 step-5 js-quote-step-5">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>Do you want your website to have dynamic contents? Dynamic contents like blog, event, news etc can significantly enhance your website.</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-20" type="radio" value="yes" name="quote_dynamic_content">
                                        <label for="radio-20"><span>Yes, I’d like to have dynamic content</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-21" type="radio" value="no" name="quote_dynamic_content">
                                        <label for="radio-21"><span>No, I don’t need any of those pages</span></label>
                                    </div>
                                </div>
                                <!-- Forward -->
                                <button id="js-quote-step-5" class="btn btn-primary js-step-button js-step-counter-9" data-next="js-quote-step-6" data-prev="js-quote-step-5" data-counter="9">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-4" data-prev="js-quote-step-5" data-counter="7">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step - 6 -->
                    <section class="hidden-step step-4 step-6 js-quote-step-6">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                    <h2>If your website doesn’t rank well on search engines, it’s going to be very hard to get clients. These days it’s extremely important for most business to rank well.</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-23" type="radio" value="do_not_want" name="quote_seo_audit">
                                        <label for="radio-23"><span>I’m not concerned about the search engine rank of my website.</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-24" type="radio" value="not_now" name="quote_seo_audit">
                                        <label for="radio-24"><span>I’m concerned about my website’s rank, but I don’t want to take any step now.</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-25" type="radio" value="yes" name="quote_seo_audit">
                                        <label for="radio-25"><span>I’d like to have an SEO audit with competitor analysis.</span></label>
                                    </div>
                                </div>

                                <!-- Forward -->
                                <button id="js-quote-step-6" class="btn btn-primary js-step-button js-step-counter-10" data-next="js-quote-step-7" data-prev="js-quote-step-6" data-counter="10">Next question</button>
                                <!-- Back -->
                                <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-5" data-prev="js-quote-step-6" data-counter="8">Back</button>
                                
                            </div>
                        </div>
                    </section>
                    <!-- Step 7 -->
                    <section class="hidden-step step-4 step-7 js-quote-step-7">
                        <div class="step">
                            <div class="content">
                                <div class="heading">
                                <h2>Do you have a CMS of choice?</h2>
                                </div>
                                <div class="option">
                                    <div class="form-group">
                                        <input class="box-style" id="radio-26" type="radio" value="no_choice" name="quote_choose_cms">
                                        <label for="radio-26"><span>Not sure (Let us choose the best one based on your requirements)</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-27" type="radio" value="wordpress" name="quote_choose_cms">
                                        <label for="radio-27"><span>WordPress</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-28" type="radio" value="magento_shopify" name="quote_choose_cms">
                                        <label for="radio-28"><span>Magento / Shopify</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-29" type="radio" value="webcommander" name="quote_choose_cms">
                                        <label for="radio-29"><span>WebCommander</span></label>
                                    </div>
                                    <div class="form-group">
                                        <input class="box-style" id="radio-30" type="radio" value="other" name="quote_choose_cms">
                                        <label for="radio-30"><span>Other</span></label>
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="form-group">
                                        <input type="text" name="other_cms" placeholder="Please type the name of your preferred CMS">
                                    </div>
                                </div>
                                <div class="js-get-estimation">
                                    <button type="submit" name="submit" id="js-quote-step-7" class="btn btn-primary js-step-counter-11" data-counter="10">Get Estimation</button>
                                    <button class="btn btn-primary js-step-back-button" data-next="js-quote-step-6" data-prev="js-quote-step-7" data-counter="9">Back</button>
                                    
                                </div>
                            </div>
                        </div>
                    </section>
                    
                </div>
            </form>

            <!-- Get Estimation by email -->
            <div class="hidden-step get-the-estimate js-get-quote-estimation">
                <div class="content">
                    <h2>Here’s the estimated cost of your website.</h2>
                    <p>Estimated total cost: <strong>$<strong><strong class="js-total-price">2500</strong></p>
                    <span>Note that the quote above is just an approximation. If you want a full report with a breakdown of all the items you chose, please fill-up the Contact Us form below.</span>
                    <form action="" id="quote-estimation-email">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Name*" id="quote-name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="company" placeholder="Company*" id="quote-company">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email*" id="quote-email">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Phone*" id="quote-phone">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Get the Estimate</button>
                        <div class="js-email-notice"></div>
                        <div class ="loader-last">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/loader.gif" />
                        </div>
                    </form>
                </div>
            </div>

            <div class="steps-count fix-foot js-steps-count" style="display: none">
                <div class="prev"><span>Back</span></div>
                <div class="progress" id="js-progress-item" style="height: 5px;">
                </div>
                <div class="next"><span>Next</span></div>
            </div>
            <div class="steps-footer">
                <p>Copyright © 2020 WebAlive</p>
                <ul>
                    <li><a target="_blank" href="https://www.webalive.com.au/terms-and-conditions/">Terms and Conditions</a></li> |
                    <li><a target="_blank" href="https://www.webalive.com.au/privacy-policy/"> Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <!-- Quote Form Ends -->

        <?php
        $return_html = ob_get_contents();

        ob_get_clean();

       return $return_html;
    }

    /**
     * Submit Ajax Form
     * @author Rabiul
     */
    public function submit_quote_form() {

        // Custom Ecommerce Price Value Set
        $ecommerce_custom_price                             = 3500;
        $ecommerce_custom_monthly_fee                       = 55;
        $ecommerce_custom_100_to_1000_product_per_month     = 110;
        $ecommerce_custom_more_than_1000_product_per_month  = 385;

        // Custom Content Price Value Set
        $content_custom_price                             = 2500;
        $content_custom_monthly_fee                       = 55;
        $content_custom_100_to_1000_product_per_month     = 110;
        $content_custom_more_than_1000_product_per_month  = 385;

        // Quick Ecommerce Price Value Set
        $ecommerce_quick_price                              = 1100;
        $ecommerce_quick_monthly_fee                        = 55;
        $ecommerce_quick_100_to_1000_product_per_month      = 110;
        $ecommerce_quick_more_than_1000_product_per_month   = 385;

        // Quick Content Price Value Set
        $content_quick_price                              = 550;
        $content_quick_monthly_fee                        = 55;
        $content_quick_100_to_1000_product_per_month      = 110;
        $content_quick_more_than_1000_product_per_month   = 385;

        // General Price Value Set
        $page_6_to_10_each                          = 385;
        $page_more_than_10_each                     = 55;
        $quick_page_more_than_5_each                = 55;
        $seo_audit_price                            = 1100;
        $cms_price                                  = 1100;
        $content_writting_per_page                  = 220;
        $blog_price                                 = 550;

        // Total
        $grand_total                                = 0;
        $final_monthly_fee                          = 0;

        // Calculating Website Type Price
        if( isset( $_POST[ 'design_type' ] ) ) {
            $design_type = sanitize_text_field( $_POST[ 'design_type' ] );
            if( 'custom' == $design_type ) {
                if( isset( $_POST[ 'website_type' ] ) ) {
                    $website_type = sanitize_text_field( $_POST[ 'website_type' ] );
                    if( 'ecommerce' == $website_type ) {
                        $grand_total += $ecommerce_custom_price;
                        $final_monthly_fee += $ecommerce_custom_monthly_fee;

                        // Store the product type
                        if( isset( $_POST[ 'product_type' ] ) ) {
                            $product_type = sanitize_text_field( $_POST[ 'product_type' ] );
                        }

                        // Product Qty
                        if( isset( $_POST[ 'product_qty' ] ) ) {
                            $product_qty = sanitize_text_field( $_POST[ 'product_qty' ] );
                            if( 'less_than_100' == $product_qty ) {
                                // Stay calm & do nothing
                            }else if( '100_to_1000' == $product_qty ) {
                                $final_monthly_fee = $ecommerce_custom_100_to_1000_product_per_month;
                            }else if( '1000_plus' == $product_qty ) {
                                $final_monthly_fee = $ecommerce_custom_more_than_1000_product_per_month;
                            }else {

                            }
                        }

                        // Website Pages
                        if( isset( $_POST[ 'website_pages' ] ) ) {
                            $website_pages = sanitize_text_field( $_POST[ 'website_pages' ] );
                            if( 'max_5' == $website_pages ) {
                                // Stay calm & do nothing
                            }else if( 'max_10' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 10;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 5 && $number_of_pages <= 10 ) {
                                    $price_by_pages = ( $number_of_pages - 5 ) * $page_6_to_10_each;
                                }
                            }else if( '10_plus' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 11;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 10 ) {
                                    $price_by_pages = ( $number_of_pages - 10 ) * $page_more_than_10_each;
                                }
                                $price_by_pages += 5 * $page_6_to_10_each;
                            }else {
                                // Do nothing
                            }

                            // Update Grand Total 
                            $grand_total += $price_by_pages;
                        }

                        // Website Page Content
                        if( isset( $_POST[ 'web_page_content' ] ) ) {
                            $web_page_content = sanitize_text_field( $_POST[ 'web_page_content' ] );
                            $number_of_webpage_content = intval( $_POST[ 'number_of_webpage_content' ] );
                            if( 'need_content' == $web_page_content ) {
                                $price_by_content = $number_of_webpage_content * $content_writting_per_page;
                            }else if( 'already_have' == $web_page_content ) {
                                // Stay calm & do nothing
                            }

                            // Update Grand Total
                            $grand_total += $price_by_content;
                        }

                        // Dynamic Content
                        if( isset( $_POST[ 'dynamic_content' ] ) ) {
                            $dynamic_content = sanitize_text_field( $_POST[ 'dynamic_content' ] );
                            if( 'yes' == $dynamic_content ) {
                                // Update Grand Total
                                $grand_total += $blog_price;
                            }
                        }

                        // SEO Audit
                        if( isset( $_POST[ 'seo_audit' ] ) ) {
                            $seo_audit = sanitize_text_field( $_POST[ 'seo_audit' ] );
                            if( 'yes' == $seo_audit ) {
                                // Update Grand Total
                                $grand_total += $seo_audit_price;
                            }
                        }

                        // Choose CMS
                        if( isset( $_POST[ 'choose_cms' ] ) ) {
                            $choose_cms = sanitize_text_field( $_POST[ 'choose_cms' ] );
                            $custom_cms = sanitize_text_field( $_POST[ 'custom_cms' ] );
                            if( 'no_choice' == $choose_cms || 'webcommander' == $choose_cms ) {
                                // do nothing
                                $grand_total = $grand_total;
                            }else {
                                $grand_total += $cms_price;
                            }
                        }
                    }else if( 'content' == $website_type ) {
                        $grand_total += $content_custom_price;
                        $final_monthly_fee += $content_custom_monthly_fee;
                        
                        // Store the product type
                        if( isset( $_POST[ 'product_type' ] ) ) {
                            $product_type = sanitize_text_field( $_POST[ 'product_type' ] );
                        }
                        
                        // Product Qty
                        if( isset( $_POST[ 'product_qty' ] ) ) {
                            $product_qty = sanitize_text_field( $_POST[ 'product_qty' ] );
                            if( 'less_than_100' == $product_qty ) {
                                // Stay calm & do nothing
                            }else if( '100_to_1000' == $product_qty ) {
                                $final_monthly_fee = $content_custom_100_to_1000_product_per_month;
                            }else if( '1000_plus' == $product_qty ) {
                                $final_monthly_fee = $content_custom_more_than_1000_product_per_month;
                            }else {
                        
                            }
                        }
                        
                        // Website Pages
                        if( isset( $_POST[ 'website_pages' ] ) ) {
                            $website_pages = sanitize_text_field( $_POST[ 'website_pages' ] );
                            if( 'max_5' == $website_pages ) {
                                // Stay calm & do nothing
                            }else if( 'max_10' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 10;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 5 && $number_of_pages <= 10 ) {
                                    $price_by_pages = ( $number_of_pages - 5 ) * $page_6_to_10_each;
                                }
                            }else if( '10_plus' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 11;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 10 ) {
                                    $price_by_pages = ( $number_of_pages - 10 ) * $page_more_than_10_each;
                                }
                                $price_by_pages += 5 * $page_6_to_10_each;
                            }else {
                                // Do nothing
                            }
                        
                            // Update Grand Total 
                            $grand_total += $price_by_pages;
                        }
                        
                        // Website Page Content
                        if( isset( $_POST[ 'web_page_content' ] ) ) {
                            $web_page_content = sanitize_text_field( $_POST[ 'web_page_content' ] );
                            $number_of_webpage_content = intval( $_POST[ 'number_of_webpage_content' ] );
                            if( 'need_content' == $web_page_content ) {
                                $price_by_content = $number_of_webpage_content * $content_writting_per_page;
                            }else if( 'already_have' == $web_page_content ) {
                                // Stay calm & do nothing
                            }
                        
                            // Update Grand Total
                            $grand_total += $price_by_content;
                        }
                        
                        // Dynamic Content
                        if( isset( $_POST[ 'dynamic_content' ] ) ) {
                            $dynamic_content = sanitize_text_field( $_POST[ 'dynamic_content' ] );
                            if( 'yes' == $dynamic_content ) {
                                // Update Grand Total
                                $grand_total += $blog_price;
                            }
                        }
                        
                        // SEO Audit
                        if( isset( $_POST[ 'seo_audit' ] ) ) {
                            $seo_audit = sanitize_text_field( $_POST[ 'seo_audit' ] );
                            if( 'yes' == $seo_audit ) {
                                // Update Grand Total
                                $grand_total += $seo_audit_price;
                            }
                        }
                        
                        // Choose CMS
                        if( isset( $_POST[ 'choose_cms' ] ) ) {
                            $choose_cms = sanitize_text_field( $_POST[ 'choose_cms' ] );
                            $custom_cms = sanitize_text_field( $_POST[ 'custom_cms' ] );
                            if( 'no_choice' == $choose_cms || 'webcommander' == $choose_cms ) {
                                // do nothing
                                $grand_total = $grand_total;
                            }else {
                                $grand_total += $cms_price;
                            }
                        }
                    }
                }
                
            }else if( 'quick' == $design_type ) {
                if( isset( $_POST[ 'website_type' ] ) ) {
                    $website_type = sanitize_text_field( $_POST[ 'website_type' ] );
                    if( 'ecommerce' == $website_type ) {
                        $grand_total += $ecommerce_quick_price;
                        $final_monthly_fee += $ecommerce_quick_monthly_fee;

                        // Store the product type
                        if( isset( $_POST[ 'product_type' ] ) ) {
                            $product_type = sanitize_text_field( $_POST[ 'product_type' ] );
                        }

                        // Product Qty
                        if( isset( $_POST[ 'product_qty' ] ) ) {
                            $product_qty = sanitize_text_field( $_POST[ 'product_qty' ] );
                            if( 'less_than_100' == $product_qty ) {
                                // Stay calm & do nothing
                            }else if( '100_to_1000' == $product_qty ) {
                                $final_monthly_fee = $ecommerce_quick_100_to_1000_product_per_month;
                            }else if( '1000_plus' == $product_qty ) {
                                $final_monthly_fee = $ecommerce_quick_more_than_1000_product_per_month;
                            }else {

                            }
                        }

                        // Website Pages
                        if( isset( $_POST[ 'website_pages' ] ) ) {
                            $website_pages = sanitize_text_field( $_POST[ 'website_pages' ] );
                            $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                            if( 'max_5' == $website_pages ) {
                                // Stay calm & do nothing
                            }else if( 'max_10' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 10;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 5 && $number_of_pages <= 10 ) {
                                    $price_by_pages = ( $number_of_pages - 5 ) * $quick_page_more_than_5_each;
                                }
                            }else if( '10_plus' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 11;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 10 ) {
                                    $price_by_pages = ( $number_of_pages - 10 ) * $quick_page_more_than_5_each;
                                }
                                $price_by_pages += 5 * $quick_page_more_than_5_each;
                            }else {
                                // Do nothing
                            }

                            // Update Grand Total 
                            $grand_total += $price_by_pages;
                        }

                        // Website Page Content
                        if( isset( $_POST[ 'web_page_content' ] ) ) {
                            $web_page_content = sanitize_text_field( $_POST[ 'web_page_content' ] );
                            $number_of_webpage_content = intval( $_POST[ 'number_of_webpage_content' ] );
                            if( 'need_content' == $web_page_content ) {
                                $price_by_content = $number_of_webpage_content * $content_writting_per_page;
                            }else if( 'already_have' == $web_page_content ) {
                                // Stay calm & do nothing
                            }

                            // Update Grand Total
                            $grand_total += $price_by_content;
                        }

                        // Dynamic Content
                        if( isset( $_POST[ 'dynamic_content' ] ) ) {
                            $dynamic_content = sanitize_text_field( $_POST[ 'dynamic_content' ] );
                            if( 'yes' == $dynamic_content ) {
                                // Update Grand Total
                                $grand_total += $blog_price;
                            }
                        }

                        // SEO Audit
                        if( isset( $_POST[ 'seo_audit' ] ) ) {
                            $seo_audit = sanitize_text_field( $_POST[ 'seo_audit' ] );
                            if( 'yes' == $seo_audit ) {
                                // Update Grand Total
                                $grand_total += $seo_audit_price;
                            }
                        }

                        // Choose CMS
                        if( isset( $_POST[ 'choose_cms' ] ) ) {
                            $choose_cms = sanitize_text_field( $_POST[ 'choose_cms' ] );
                            $custom_cms = sanitize_text_field( $_POST[ 'custom_cms' ] );
                            if( 'no_choice' == $choose_cms || 'webcommander' == $choose_cms ) {
                                // do nothing
                                $grand_total = $grand_total;
                            }else {
                                $grand_total += $cms_price;
                            }
                        }
                    }else if( 'content' == $website_type ) {
                        $grand_total += $content_quick_price;
                        $final_monthly_fee += $content_quick_monthly_fee;
                        
                        // Store the product type
                        if( isset( $_POST[ 'product_type' ] ) ) {
                            $product_type = sanitize_text_field( $_POST[ 'product_type' ] );
                        }
                        
                        // Product Qty
                        if( isset( $_POST[ 'product_qty' ] ) ) {
                            $product_qty = sanitize_text_field( $_POST[ 'product_qty' ] );
                            if( 'less_than_100' == $product_qty ) {
                                // Stay calm & do nothing
                            }else if( '100_to_1000' == $product_qty ) {
                                $final_monthly_fee = $content_quick_100_to_1000_product_per_month;
                            }else if( '1000_plus' == $product_qty ) {
                                $final_monthly_fee = $content_quick_more_than_1000_product_per_month;
                            }else {
                        
                            }
                        }
                        
                        // Website Pages
                        if( isset( $_POST[ 'website_pages' ] ) ) {
                            $website_pages = sanitize_text_field( $_POST[ 'website_pages' ] );
                            $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                            if( 'max_5' == $website_pages ) {
                                // Stay calm & do nothing
                            }else if( 'max_10' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 10;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 5 && $number_of_pages <= 10 ) {
                                    $price_by_pages = ( $number_of_pages - 5 ) * $quick_page_more_than_5_each;
                                }
                            }else if( '10_plus' == $website_pages ) {
                                if( isset( $_POST[ 'number_of_pages' ] ) ) {
                                    $number_of_pages = intval( $_POST[ 'number_of_pages' ] );
                                }else {
                                    $number_of_pages = 11;
                                }
                                // Calculate price based on number of pages
                                if( $number_of_pages > 10 ) {
                                    $price_by_pages = ( $number_of_pages - 10 ) * $quick_page_more_than_5_each;
                                }
                                $price_by_pages += 5 * $quick_page_more_than_5_each;
                            }else {
                                // Do nothing
                            }
                        
                            // Update Grand Total 
                            $grand_total += $price_by_pages;
                        }
                        
                        // Website Page Content
                        if( isset( $_POST[ 'web_page_content' ] ) ) {
                            $web_page_content = sanitize_text_field( $_POST[ 'web_page_content' ] );
                            $number_of_webpage_content = intval( $_POST[ 'number_of_webpage_content' ] );
                            if( 'need_content' == $web_page_content ) {
                                $price_by_content = $number_of_webpage_content * $content_writting_per_page;
                            }else if( 'already_have' == $web_page_content ) {
                                // Stay calm & do nothing
                            }
                        
                            // Update Grand Total
                            $grand_total += $price_by_content;
                        }
                        
                        // Dynamic Content
                        if( isset( $_POST[ 'dynamic_content' ] ) ) {
                            $dynamic_content = sanitize_text_field( $_POST[ 'dynamic_content' ] );
                            if( 'yes' == $dynamic_content ) {
                                // Update Grand Total
                                $grand_total += $blog_price;
                            }
                        }
                        
                        // SEO Audit
                        if( isset( $_POST[ 'seo_audit' ] ) ) {
                            $seo_audit = sanitize_text_field( $_POST[ 'seo_audit' ] );
                            if( 'yes' == $seo_audit ) {
                                // Update Grand Total
                                $grand_total += $seo_audit_price;
                            }
                        }
                        
                        // Choose CMS
                        if( isset( $_POST[ 'choose_cms' ] ) ) {
                            $choose_cms = sanitize_text_field( $_POST[ 'choose_cms' ] );
                            $custom_cms = sanitize_text_field( $_POST[ 'custom_cms' ] );
                            if( 'no_choice' == $choose_cms || 'webcommander' == $choose_cms ) {
                                // do nothing
                                $grand_total = $grand_total;
                            }else {
                                $grand_total += $cms_price;
                            }
                        }
                    }
                }
            }
        }

        // Dynamic Content Price if any
        if( 'yes' == $dynamic_content ) {
            $dynamic_content_price = $blog_price;
        }else {
            $dynamic_content_price = 0;
        }
        // SEO Audit Price if any
        if( 'yes' == $seo_audit ) {
            $seo_audit_price = $seo_audit_price;
        }else {
            $seo_audit_price = 0;
        }

        if( isset( $_POST[ 'choose_page' ] ) ) {
            $page_list = $_POST[ 'choose_page' ];
        }else {
            $page_list = [];
        }

        $quote_info = [
            'grand_total'               => $grand_total,
            'monthly_fee'               => $final_monthly_fee,
            'website_type'              => $website_type,
            'product_type'              => $product_type,
            'product_qty'               => $product_qty,
            'website_pages'             => $website_pages,
            'price_by_pages'            => $price_by_pages,
            'web_page_content'          => $web_page_content,
            'price_by_content'          => $price_by_content,
            'dynamic_content'           => $dynamic_content,
            'dynamic_content_price'     => $dynamic_content_price,
            'seo_audit'                 => $seo_audit,
            'seo_audit_price'           => $seo_audit_price,
            'choose_cms'                => $choose_cms,
            'custom_cms'                => $custom_cms,
            'design_type'               => $design_type,
            'number_of_pages'           => $number_of_pages,
            'number_of_webpage_content' => $number_of_webpage_content,
            'page_list'                 => $page_list,
        ];

        echo wp_json_encode( $quote_info );

        wp_die();

    }

    /**
     * Send Email to client
     * @author Rasadin
     * @modified Rabiul
     */
    public function sent_quote_email() {

        if( isset( $_POST[ 'fields' ] ) ) {
            parse_str( $_POST[ 'fields' ], $fields );

            // Check Quote info in session
            $quote_info = isset( $_POST[ 'quoteInfo' ] ) ? $_POST[ 'quoteInfo' ] : null;

            if( null !== $quote_info ) { 

                //random code
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $ref = substr(str_shuffle($permitted_chars), 0, 16);

                $post_id = wp_insert_post( wp_slash( array(
                    'post_type'         => 'quote', // Custom Post Type Slug
                    'post_status'       => 'publish',
                    'post_title'        => $fields[ 'email' ],
                    'order' => 'DESC',
                    'meta_input'        => array( 
                        'quote_user'                => $fields['name' ],
                        'quote_company'             => $fields[ 'company' ],
                        'quote_email'               => $fields[ 'email' ],
                        'quote_phone'               => $fields[ 'phone' ],
                        'grand_total'               => $quote_info['grand_total'],
                        'monthly_fee'               => $quote_info['monthly_fee'],
                        'website_type'              => $quote_info['website_type'],
                        'product_type'              => $quote_info['product_type'],
                        'product_qty'               => $quote_info['product_qty'],
                        'website_pages'             => $quote_info['website_pages'],
                        'price_by_pages'            => $quote_info['price_by_pages'],
                        'web_page_content'          => $quote_info['web_page_content'],
                        'price_by_content'          => $quote_info['price_by_content'],
                        'dynamic_content'           => $quote_info['dynamic_content'],
                        'dynamic_content_price'     => $quote_info['dynamic_content_price'],
                        'seo_audit'                 => $quote_info['seo_audit'],
                        'seo_audit_price'           => $quote_info['seo_audit_price'],
                        'choose_cms'                => $quote_info['choose_cms'],
                        'custom_cms'                => $quote_info['custom_cms'],
                        'design_type'               => $quote_info['design_type'],
                        'number_of_pages'           => $quote_info['number_of_pages'],
                        'number_of_webpage_content' => $quote_info['number_of_webpage_content'],
                        'page_list'                 => $quote_info['page_list'],
                        'ref'                       => $ref,
                    )
                ) ) );

                
                    // //zoho data pass if need to test in localhost without sending email 
                    // $user_data = [
                    // 'last_name' => $fields[ 'name' ],
                    // 'company' => $fields[ 'company' ],
                    // 'email' => $fields[ 'email' ],
                    // 'phone' => $fields[ 'phone' ],
                    // 'url' =>  home_url( '/quote-estimation?ref='. $ref ),
                    //  ];
                    // $this->insert_leads($user_data);
                    // //end zoho data pass
                    // die();


                if( $post_id ) {
                    $sent_email = $this->quote_email_template( $fields, $post_id );
                    if( $sent_email ) {
                        $user_data = [
                            'name' => $fields[ 'name' ],
                            'company' => $fields[ 'company' ],
                            'email' => $fields[ 'email' ],
                            'phone' => $fields[ 'phone' ],
                        ];
                        $admin_email = $this->quote_email_admin_template( $user_data, $post_id );
                        if( $admin_email ) {

                            //zoho data pass after sending email 
                            $user_data = [
                            'last_name' => $fields[ 'name' ],
                            'company' => $fields[ 'company' ],
                            'email' => $fields[ 'email' ],
                            'phone' => $fields[ 'phone' ],
                            'url' =>  home_url( '/quote-estimation?ref='. $ref ),
                            ];
                            $this->insert_leads($user_data);
                            //end zoho data pass
                                       
                            $response = '200';
                        }
                    }else {
                        $response = '401';
                    }
                }
            }
            
        }else {
            $response = '400';
        }

        echo wp_json_encode($response);
        wp_die();

    }

    /**
     * Quote Email Template 
     * @author Rasadin
     * @modified Rabiul
     */
    public function quote_email_template( $data, $post_id ) {
        $quote_user   =  get_post_meta( $post_id, 'quote_user', true );
        $quote_user   =  str_replace( '_',' ', $quote_user );


        $to 		= $data[ 'email' ];
        $subject 	= $quote_user . ', here is your estimation';

        $url = home_url() . '/quote-estimation?ref=' . get_post_meta( $post_id, 'ref', true );

        ob_start();
        $body = '';
        ?>


        <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#ffffff" align="center">
            <tr>
                <td valign="top" align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                        <tr>
                            <td valign="top" align="center" height="30px" style="line-height:30px;">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border:1px solid #ffffff; padding:2px;">
                        <tr>
                            <td valign="top" align="center" height="30px" style="line-height:30px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                    <tr>
                                        <td width="100%" height="15px">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                                    <tbody>
                                    <tr>
                                        <td width="5%" align="left"></td>
                                        <td width="90%" align="center"><a href="#">
                                                <img width="223" height="36"  border="0" src="<?php echo get_template_directory_uri(); ?>/assets/source/img/login-screen.png" alt="Logo"> </a></td>
                                        <td width="5%" align="left"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" align="center">
                                    <tr>
                                        <td width="100%" height="50px" style="line-height:50px;">&nbsp;</td>
                                    </tr>
                                </table>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                    <tr>
                                        <td width="4%" valign="top"></td>
                                        <td width="96%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                <tr>
                                                    <td width="100%" valign="top"><p><strong><span style="color:#595959;font-size:18px;font-weight:bold;">Hi <?php echo ucfirst( $quote_user );?>,</span></strong></p>
                                                        <p style="line-height:28px; margin-bottom: 25px;"><span style="color:#595959;font-size:18px;">Thank you for using our price calculator to estimate your web design project cost. </span></p>
                                                        <p style="line-height:24px; margin-bottom: 0px;"><span style="color:#595959;font-size:18px; font-weight: bold; letter-spacing: -0.5px;">The detailed cost breakdown for your project can be found here:</span></p>
                                                        <p  style="line-height:24px; margin-top: 5px; margin-bottom: 25px;font-size:18px;"><?php echo $url; ?></p>

                                                        <p  style="line-height:28px;"><span style="color:#595959;font-size:18px;">If you have any questions, feel free to </span>
                                                            <a href="https://www.webalive.com.au/contact-us/" target="_blank"  style="color:#005693;font-size:18px;">contact us </a></p>


                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" valign="top" height="20px" style="line-height:20px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top"><span style="color:#595959;font-size:17px;"> Thank you and have a nice day!</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"  valign="top" height="10px" style="line-height:10px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top"><span style="color:#595959;font-size:17px;font-weight:bold;"> WebAlive Team</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"  valign="top" height="35px" style="line-height:20px;">&nbsp;</td>
                                                            </tr>
                                                        </table>


                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
                                                            <tr>
                                                                <td  valign="top" height="2px" style="line-height:2px;border-bottom:1px solid #eee">&nbsp;</td>
                                                            </tr>
                                                        </table>



                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" valign="top" height="30px" style="line-height:30px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:18px;"> Learn more about us at</span>
                                                                    <a href="https://www.webalive.com.au/" target="_blank" style="color:#005693;font-size:18px;">webalive.com.au</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top" height="30px" style="line-height:30px;">&nbsp;</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" align="center">
                                                                    <table  border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                                        <tr>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://www.facebook.com/webalive.com.au/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/fb.png" alt="facebook" /></a></td>
                                                                            <td valign="top" align="center">&nbsp;&nbsp;&nbsp;</td>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://www.linkedin.com/company/webalive/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/li.png" alt="linkedin" /></a></td>
                                                                            <td valign="top" align="center">&nbsp;&nbsp;&nbsp;</td>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://twitter.com/WebAlive"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/tw.png" alt="fb" /></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td width="100%" valign="top" height="35px" style="line-height:35px;">&nbsp;</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:12px;">Please note, this estimation is a knowledgeable guess and will be further refined with more information. At this time, it is based on your selected requirements and average costs of each selected feature and IS NOT a final cost estimate. </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" height="25px" style="line-height:25px;">&nbsp;</td>
                                                            </tr>


                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:14px;font-weight:bold">Copyright 2020 WebAlive, All rights reserved.  </span>
                                                                </td>
                                                            </tr>


                                                        </table>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" colspan="2" valign="top" height="100px" style="line-height:100px;">&nbsp;</td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                        <tr>
                            <td valign="top" align="center" height="70px" style="line-height:70px;">&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <?php
        $body .= ob_get_contents();

        ob_end_clean();

        $headers 	= "From: WebAlive <webalive.com.au>" . "\r\n";
        $headers 	.= "MIME-Version: 1.0\r\n";
        $headers 	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $sent_email = mail( $to, $subject , $body, $headers );

        return $sent_email;
    }

    /**
     * Sent Email to admin
     * @author Rabiul
     */
    public function quote_email_admin_template( $user_data, $post_id ) {
        $quote_user   =  get_post_meta( $post_id, 'quote_user', true );
        $quote_user   =  str_replace( '_',' ', $quote_user );

        $to 		= 'liakat@webalive.com.au'; // info@webalive.com.au
        $subject 	= 'Quote Estimation for - '.$quote_user;

        $url = home_url() . '/quote-estimation?ref=' . get_post_meta( $post_id, 'ref', true );

        ob_start();
        $body = '';
        ?>

        <!-- User Information  Starts -->

        <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#ffffff" align="center">
            <tr>
                <td valign="top" align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                        <tr>
                            <td valign="top" align="center" height="30px" style="line-height:30px;">&nbsp;</td>
                        </tr>
                    </table>
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border:1px solid #ffffff; padding:2px;">
                        <tr>
                            <td valign="top" align="center" height="30px" style="line-height:30px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                    <tr>
                                        <td width="100%" height="15px">&nbsp;</td>
                                    </tr>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                                    <tbody>
                                    <tr>
                                        <td width="5%" align="left"></td>
                                        <td width="90%" align="center"><a href="#">
                                                <img width="223" height="36"  border="0" src="<?php echo get_template_directory_uri(); ?>/assets/source/img/login-screen.png" alt="Logo"> </a></td>
                                        <td width="5%" align="left"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" align="center">
                                    <tr>
                                        <td width="100%" height="50px" style="line-height:50px;">&nbsp;</td>
                                    </tr>
                                </table>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                    <tr>
                                        <td width="4%" valign="top"></td>
                                        <td width="96%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                <tr width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                    <td>
                                                        <h4>User Information</h4>
                                                        <table>
                                                            <tr>
                                                                <td>Name:</td>
                                                                <td><?php echo isset( $user_data[ 'name' ] ) ? $user_data[ 'name' ] : ''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Company:</td>
                                                                <td><?php echo isset( $user_data[ 'company' ] ) ? $user_data[ 'company' ] : ''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email:</td>
                                                                <td><?php echo isset( $user_data[ 'email' ] ) ? $user_data[ 'email' ] : ''; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phone:</td>
                                                                <td><?php echo isset( $user_data[ 'phone' ] ) ? $user_data[ 'phone' ] : ''; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100%" valign="top">
                                                        <p><strong><span style="color:#595959;font-size:18px;font-weight:bold;">Hi <?php echo ucfirst( $quote_user );?>,</span></strong></p>
                                                        <p style="line-height:28px; margin-bottom: 25px;"><span style="color:#595959;font-size:18px;">Thank you for using our price calculator to estimate your web design project cost. </span></p>
                                                        <p style="line-height:24px; margin-bottom: 0px;"><span style="color:#595959;font-size:18px; font-weight: bold; letter-spacing: -0.5px;">The detailed cost breakdown for your project can be found here:</span></p>
                                                        <p  style="line-height:24px; margin-top: 5px; margin-bottom: 25px;font-size:18px;"><?php echo $url; ?></p>

                                                        <p  style="line-height:28px;"><span style="color:#595959;font-size:18px;">If you have any questions, feel free to </span>
                                                            <a href="https://www.webalive.com.au/contact-us/" target="_blank"  style="color:#005693;font-size:18px;">contact us </a></p>


                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" valign="top" height="20px" style="line-height:20px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top"><span style="color:#595959;font-size:17px;"> Thank you and have a nice day!</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"  valign="top" height="10px" style="line-height:10px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top"><span style="color:#595959;font-size:17px;font-weight:bold;"> WebAlive Team</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"  valign="top" height="35px" style="line-height:20px;">&nbsp;</td>
                                                            </tr>
                                                        </table>


                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
                                                            <tr>
                                                                <td  valign="top" height="2px" style="line-height:2px;border-bottom:1px solid #eee">&nbsp;</td>
                                                            </tr>
                                                        </table>



                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" valign="top" height="30px" style="line-height:30px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:18px;"> Learn more about us at</span>
                                                                    <a href="https://www.webalive.com.au/" target="_blank" style="color:#005693;font-size:18px;">webalive.com.au</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" valign="top" height="30px" style="line-height:30px;">&nbsp;</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" align="center">
                                                                    <table  border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                                        <tr>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://www.facebook.com/webalive.com.au/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/fb.png" alt="facebook" /></a></td>
                                                                            <td valign="top" align="center">&nbsp;&nbsp;&nbsp;</td>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://www.linkedin.com/company/webalive/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/li.png" alt="linkedin" /></a></td>
                                                                            <td valign="top" align="center">&nbsp;&nbsp;&nbsp;</td>
                                                                            <td valign="top" align="center"><a target="_blank" href="https://twitter.com/WebAlive"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/tw.png" alt="fb" /></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td width="100%" valign="top" height="35px" style="line-height:35px;">&nbsp;</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:12px;">Please note, this estimation is a knowledgeable guess and will be further refined with more information. At this time, it is based on your selected requirements and average costs of each selected feature and IS NOT a final cost estimate. </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="100%" valign="top" height="25px" style="line-height:25px;">&nbsp;</td>
                                                            </tr>


                                                            <tr>
                                                                <td width="100%" valign="top" align="center"><span style="color:#595959;font-size:14px;font-weight:bold">Copyright 2020 WebAlive, All rights reserved.  </span>
                                                                </td>
                                                            </tr>


                                                        </table>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                                                            <tr>
                                                                <td width="100%" colspan="2" valign="top" height="100px" style="line-height:100px;">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                        <tr>
                            <td valign="top" align="center" height="70px" style="line-height:70px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php
        $body .= ob_get_contents();

        ob_end_clean();

        $headers 	= "From: WebAlive <webalive.com.au>" . "\r\n";
        $headers 	.= "MIME-Version: 1.0\r\n";
        $headers 	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $sent_email = mail( $to, $subject , $body, $headers );

        return $sent_email;
    }

 
/**
 * Generate Access Token Zoho
 */
public function generate_access_token() {
    // Get Refresh token
    // $refresh_token = get_option( 'zoho_refresh_token' );
    $refresh_token = '1000.2dbe8349e73e3e0a031e69ddafbb4eb8.9806b18fa7954dd13807ab7a46263804'; //need to generate and changed
    $post = [
        'refresh_token' => $refresh_token,
        'client_id'     => '1000.NO5T0ICWGNCI78E6VUJVTZVF0AYK2H', //need to changed
        'client_secret' => 'af3e326c93a525a3817fc452a4e33f2558ea6b6dc7', //need to changed
        'grant_type'    => 'refresh_token'
    ];
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token" );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $post ) );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 ) ;
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );
 
    $response = curl_exec( $ch );
    $response = json_decode( $response );
 
    return $response->access_token;
}


/**
 * Inseter Leads
 */
public function insert_leads($user_data) {
 
    $access_token = $this->generate_access_token();
 
    $post_data = [
        'data' => [
            [
                "Company"     => $user_data[ 'company' ],
                "Last_Name"   => $user_data[ 'last_name' ],
                "Email"       => $user_data[ 'email' ],
                "Phone"       => $user_data[ 'phone' ],
                "Description" => $user_data[ 'url' ]
            ]
        ],
        'trigger' => [
            "approval",
            "workflow",
            "blueprint"
        ]
    ];
 
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://www.zohoapis.com/crm/v2/Leads" );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post_data ) );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 ) ;
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/x-www-form-urlencoded'
    ) );
 
    $response = curl_exec( $ch );
    $response = json_decode( $response );
 
    return $response;
}




}
new QuoteForm();