<?php
/*
Plugin Name: Shortcode Example 3
Plugin URI: http://example.com/
Description: Replace [amazon isbn="xxx"]book title[/amazon]
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

// Register a new shortcode: [amazon isbn="123"]link title[/amazon]
add_shortcode( 'amazon', 'boj_sc3_amazon' );

// Callback function for the [amazon] shortcode
function boj_sc3_amazon( $attr, $content ) {
    
    // Get ISBN or set default
    if( isset( $attr['isbn'] ) ) {
        $isbn = preg_replace( '/[^\d]/', '', $attr['isbn'] );
    } else {
        $isbn = '0470560541';
    }
    
    // Sanitize content, or set default
    if( !empty( $content ) ) {
        $content = esc_html( $content );
    } else {
        if( $isbn == '0470560541' ) {
            $content = 'Professional WordPress';
        } else {
            $content = 'this book';
        }
    }
    
    return "<a href='http://www.amazon.com/dp/$isbn'>$content</a>";
}

