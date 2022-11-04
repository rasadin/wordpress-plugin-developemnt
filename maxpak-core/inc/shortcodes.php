<?php 
/**
 * =========================================================
 * All Shortcodes
 * ---------------------------------------------------------
 * =========================================================
 */

 class MaxpakCore_Shortcodes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_shortcode( 'display-category-by-id', array($this, 'display_category_by_id' ) );
        add_shortcode( 'shortcode_name', array($this, 'shortcode_function') );
        add_shortcode( 'product_categories_dropdown', array($this, 'woo_product_categories_dropdown' ) );
        add_shortcode( 'get_all_product_categories_list', array($this, 'woo_product_categories_list' ) );
        add_shortcode( 'get_all_product_categories_details', array($this, 'woo_product_categories_details' ) );
    }

    /**
     * Selected Portfolios
     * Shortcode: [selected-portfolio ids=""]
     */
    public function shortcode_function( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'ids'   => ''
        ), $atts));
    }

   /**
     * woo_product_categories_list
     * Shortcode: [get_all_product_categories_list]
     */
    function woo_product_categories_list( $atts ) {

        $orderby = 'name';
        $order = 'asc';
        $hide_empty = false ;
        $cat_args = array(
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => $hide_empty,
        );
         
        $product_categories = get_terms( 'product_cat', $cat_args );
         
        if( !empty($product_categories) ){
            echo '
         
        <ul>';
            foreach ($product_categories as $key => $category) {
                $img_id= $result1->meta_value;
                echo '
         
        <li>';
                echo '<a href="'.get_term_link($category).'" >';
                echo $category->name;
                echo $category->description;
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>
         
         
        ';
        }


      }




    /**
     * get_all_product_categories_details
     * Shortcode: [get_all_product_categories_details]
     */
    function woo_product_categories_details() {
        $get_featured_cats = array(
            'taxonomy'     => 'product_cat',
            'orderby'      => 'name',
            'hide_empty'   => '1',
            'include'      => $cat_array
        );
        $all_categories = get_categories( $get_featured_cats );
        ?>
          <div class="row">


         <?php
        foreach ($all_categories as $cat) {
            $cat_id   = $cat->term_id;
            $cat_link = get_category_link( $cat_id );
            
            $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); // Get Category Thumbnail
            $image = wp_get_attachment_url( $thumbnail_id ); 
                 ?>
                

   
    <div class="col-sm-4">
    <div class="card-body">
                 <?php
            if ( $image ) {
                echo '<img src="' . $image . '" alt="" />';
            }
            echo $cat->name; // Get Category Name
            echo $cat->description; // Get Category Description

                 ?> 
</div>
</div>

                 <?php
            
        }
        ?>
        </div>  
        <?php
        // Reset Post Data
        wp_reset_query();
       
      }


        /**
     * WooCommerce Extra Feature
     * --------------------------
     *
     * Register a shortcode that creates a product categories dropdown list
     *
     * Use: [product_categories_dropdown orderby="title" count="0" hierarchical="0"]
     *
     */
    function woo_product_categories_dropdown( $atts ) {
        extract(shortcode_atts(array(
          'count'         => '0',
          'hierarchical'  => '0',
          'orderby' 	    => ''
          ), $atts));
          
          ob_start();
          
          $c = $count;
          $h = $hierarchical;
          $o = ( isset( $orderby ) && $orderby != '' ) ? $orderby : 'order';
              
          // Stuck with this until a fix for http://core.trac.wordpress.org/ticket/13258
          woocommerce_product_dropdown_categories( $c, $h, 0, $o );
          ?>
          <script type='text/javascript'>
          /* <![CDATA[ */
              var product_cat_dropdown = document.getElementById("dropdown_product_cat");
              function onProductCatChange() {
                  if ( product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value !=='' ) {
                      location.href = "<?php echo home_url(); ?>/?product_cat="+product_cat_dropdown.options[product_cat_dropdown.selectedIndex].value;
                  }
              }
              product_cat_dropdown.onchange = onProductCatChange;
          /* ]]> */
          </script>
          <?php
          
          return ob_get_clean();
          
      }




    /**
     * Display Category by ID
     * Shortcode: [display-Category-by-ID]
     */
    public function display_category_by_id( ) { 
        global $catid;
        $idcat = $catid;
        $thumbnail_id = get_woocommerce_term_meta( $idcat, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        echo '<img src="'.$image.'" alt="" width="762" height="365" />';

        if( $term = get_term_by( 'id', $idcat, 'product_cat' ) ){
            echo $term->name;
        }
    } 







 } 

 new MaxpakCore_Shortcodes();
