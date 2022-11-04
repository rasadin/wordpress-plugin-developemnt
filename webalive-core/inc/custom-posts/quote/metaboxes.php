<?php 
/**
 * ========================================================
 * # quote metaboxes
 * ========================================================
 */

 class Webalive_Quote_Metaboxes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_action( 'add_meta_boxes',   array( $this, 'add_metabox_qoute' ) );
    }

    /**
     * Add Metabox
     */
    public function add_metabox_qoute() {
        $screens = array( 'quote' );
        foreach( $screens as $screen ) {
            add_meta_box(
                'webalive_quote_metabox_id',
                'Quote Information',
                array( $this, 'quote_metabox_template' ),
                $screen
            );
        }
    }

    /**
     * Metabox Template
     */
    public function quote_metabox_template($post) { 

        $quote_user_1=       get_post_meta( $post->ID, 'quote_user', true );
        $quote_user_2=       str_replace('_',' ', $quote_user_1);
        $quote_user=         ucfirst($quote_user_2);

        $quote_company_1=    get_post_meta( $post->ID, 'quote_company', true );
        $quote_company_2=    str_replace('_',' ', $quote_company_1);
        $quote_company=      ucfirst($quote_company_2);

        $quote_email=      get_post_meta( $post->ID, 'quote_email', true );
        $quote_phone=      get_post_meta( $post->ID, 'quote_phone', true );
        $grand_total=      get_post_meta( $post->ID, 'grand_total', true );
        $monthly_fee=      get_post_meta( $post->ID, 'monthly_fee', true ); 

        $website_type_1=     get_post_meta( $post->ID, 'website_type', true ); 
        $website_type_2=     str_replace('_',' ', $website_type_1); 
        $website_type=       ucfirst($website_type_2); 


        $product_type_1=     get_post_meta( $post->ID, 'product_type', true ); 
        $product_type_2=     str_replace('_',' ', $product_type_1); 
        $product_type=       ucfirst($product_type_2);


        $product_qty_1=      get_post_meta( $post->ID, 'product_qty', true ); 
        $product_qty_2=      str_replace('_',' ', $product_qty_1); 
        $product_qty=        ucfirst($product_qty_2);



        $website_pages_1=    get_post_meta( $post->ID, 'website_pages', true ); 
        $website_pages_2=    str_replace('_',' ', $website_pages_1);  
        $website_pages=      ucfirst($website_pages_2);


        $price_by_pages=   get_post_meta( $post->ID, 'price_by_pages', true ); 

        $web_page_content_1= get_post_meta( $post->ID, 'web_page_content', true );
        $web_page_content_2= str_replace('_',' ', $web_page_content_1); 
        $web_page_content=   ucfirst($web_page_content_2);


        $price_by_content= get_post_meta( $post->ID, 'price_by_content', true );
        $dynamic_content=  get_post_meta( $post->ID, 'dynamic_content', true );
        $dynamic_content_price= get_post_meta( $post->ID, 'dynamic_content_price', true );

        $seo_audit_1=        get_post_meta( $post->ID, 'seo_audit', true );
        $seo_audit_2=        str_replace('_',' ', $seo_audit_1); 
        $seo_audit=          ucfirst($seo_audit_2);



        $seo_audit_price=  get_post_meta( $post->ID, 'seo_audit_price', true ); 

        $choose_cms_1=       get_post_meta( $post->ID, 'choose_cms', true ); 
        $choose_cms_2=       str_replace('_',' ', $choose_cms_1); 
        $choose_cms=         ucfirst($choose_cms_2); 

        $custom_cms =       get_post_meta( $post->ID, 'custom_cms', true ); 
        $custom_cms =       str_replace('_',' ', $custom_cms); 

        $design_type_1=      get_post_meta( $post->ID, 'design_type', true ); 
        $design_type_2=      str_replace('_',' ', $design_type_1);
        $design_type=        ucfirst($design_type_2);  

        $number_of_pages=  get_post_meta( $post->ID, 'number_of_pages', true ); 
        $number_of_webpage_content=   get_post_meta( $post->ID, 'number_of_webpage_content', true ); 
        $ref=              get_post_meta( $post->ID, 'ref', true );?>


            <div class="metabox-side-context">
                <p><strong>User: </strong><?php echo  $quote_user; ?></p>
            </div> 
            <div class="metabox-side-context">
                <p><strong>Company: </strong><?php echo  $quote_company; ?></p>
            </div> 
            <div class="metabox-side-context">
                <p><strong>Email: </strong><?php echo  $quote_email; ?></p>
            </div> 
            <div class="metabox-side-context">
                <p><strong>Phone: </strong><?php echo  $quote_phone; ?></p>
            </div> 
            <div class="metabox-side-context">
                <p><strong>Grand Total: </strong><?php echo $grand_total; ?></p>
            </div>       
            <div class="metabox-side-context">
                <p><strong>Monthly Fee: </strong><?php echo  $monthly_fee; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Website Type: </strong><?php echo  $website_type; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Product Type: </strong><?php echo  $product_type; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Product Qty: </strong><?php echo  $product_qty; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Website Pages: </strong><?php echo $website_pages; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Price by Pages: </strong><?php echo  $price_by_pages; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Webpage Content: </strong><?php echo  $web_page_content; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Price by Content: </strong><?php echo  $price_by_content; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Dynamic Content: </strong><?php echo  $dynamic_content; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Dynamic Content Price: </strong><?php echo  $dynamic_content_price; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>SEO Audit: </strong><?php echo  $seo_audit; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>SEO Audit Price: </strong><?php echo  $seo_audit_price; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Choose Cms: </strong><?php echo $choose_cms; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Custom Cms: </strong><?php echo ucfirst( $custom_cms ); ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Design Type: </strong><?php echo $design_type; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Number of Pages: </strong><?php echo  $number_of_pages; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Number of Webpage Content: </strong><?php echo  $number_of_webpage_content; ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>Page List: </strong><?php $item = get_post_meta( $post->ID, 'page_list', true ); ?><?php foreach ($item as $value) {
                    print_r  ($value['Title']) ; 
                    ?></br> <?php
                    print_r  ($value['Desc']) ;
                    ?></br></br> <?php
                } ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>URL Ref: </strong><?php echo $ref = get_post_meta( $post->ID, 'ref', true ); ?></p>
            </div>
            <div class="metabox-side-context">
                <p><strong>URL: </strong><a href="<?php echo esc_url( home_url( '/quote-estimation?ref='. $ref ) ); ?>">Visit URL</a></p>
            </div>

    <?php }


 }
 new Webalive_Quote_Metaboxes();