<?php 
/**
 * ==========================================================
 *  This file contains all utility functions
 * ==========================================================
 */
function getProductCategoriesList() {

    // since wordpress 4.5.0
    $product_categories = get_terms( $args = array(
        'taxonomy'   => "product_cat",
        'hide_empty' => false,
        'parent'     => 0,
    ) );

    $list = array();

    foreach( $product_categories as $cat ){ 
        // $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        // $image = wp_get_attachment_url( $thumbnail_id );
        // $link = get_term_link( $cat->term_id, 'product_cat' );
        $list[] = array($cat->term_id, $cat->name);        
    }

    return $list;
}