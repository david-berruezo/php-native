<?php
/*
Plugin Name: Products Permalink Structure
Plugin URI: http://example.com/
Description: Create a whole permalink structure
Version: 1.0
Author: Ozh
Author URI: http://wrox.com
*/

// Add permalink structure and flush on plugin activation
register_activation_hook( __FILE__, 'boj_products_activate' );
function boj_products_activate() {
    boj_products_rewrite();
    flush_rewrite_rules();
}

// Flush on plugin deactivation
register_deactivation_hook( __FILE__, 'boj_products_deactivate' );
function boj_products_deactivate() {
    flush_rewrite_rules();
}

// Create new tag %product% and handle /shop/%product% URLs
add_action('init', 'boj_products_rewrite');
function boj_products_rewrite() {
    add_rewrite_tag( '%product%', '([^/]+)' );
    add_permastruct( 'product', 'shop' . '/%product%' );
}

// If query var product as a value, include product listing
add_action( 'template_redirect', 'boj_products_display' );
function boj_products_display() {
    if ( $product = get_query_var( 'product' ) ) {
        // include( 'display_product.php' );
        echo "searching for product $product ?";
        exit;
    }
}