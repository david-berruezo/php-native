<?php
/*
Plugin Name: Shortcode Example 5
Plugin URI: http://example.com/
Description: Recursive [b] and [i] shortcodes
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

// add shortcodes [b] and [i]
add_shortcode( 'i', 'boj_sc5_italic' );
add_shortcode( 'b', 'boj_sc5_bold' );

// callback function: return bold text
function boj_sc5_bold( $attr, $content ) {
    return "<strong>".do_shortcode( $content )."</strong>";
}

// callback function: return italic text
function boj_sc5_italic( $attr, $content ) {
    return "<em>".do_shortcode( $content )."</em>";
}
