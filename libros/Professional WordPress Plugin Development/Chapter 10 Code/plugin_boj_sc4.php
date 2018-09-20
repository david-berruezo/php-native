<?php
/*
Plugin Name: Shortcode Example 4
Plugin URI: http://example.com/
Description: Replace [amazonimg] with images from Amazon
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

// Register shortcodes [amazonimage] and [amazonimg]
add_shortcode( 'amazonimage', 'boj_sc4_amazonimage' );
add_shortcode( 'amazonimg', 'boj_sc4_amazonimage' );

// Callback function for the [amazonimage] shortcode
function boj_sc4_amazonimage( $attr, $content ) {

    // Get ASIN or set default
    $possible = array( 'asin', 'isbn' );
    $asin = boj_sc4_find( $possible, $attr, '0470560541' );
    
    // Get affiliate ID or set default
    $possible = array( 'aff', 'affiliate' );
    $aff = boj_sc4_find( $possible, $attr, 'aff_id' );
    
    // Get image size if specified
    $possible = array( 'size', 'image', 'imagesize' );
    $size = boj_sc4_find( $possible, $attr, '' );
    
    // Get type if specified
    if( isset( $attr['type'] ) ) {
        $type = strtolower( $attr['type'] );
        $type = ( $type == 'cd' or $type == 'disc' ) ? 'cd' : '';
    }
    
    // Now build the Amazon image URL
    $img = 'http://images.amazon.com/images/P/';
    $img .= $asin;
    // Image option: size
    if( $size ) {
        switch( $size ) {
            case 'small':
                $size = '_AA100';
                break;
            default:
            case 'medium':
                $size = '_AA175';
                break;
            case 'big':
            case 'large':
                $size = '_SCLZZZZZZZ';
        }
    }
    // Image option: type
    if( $type == 'cd' ) {
        $type = '_PF';
    }
    // Append options to image URL, if any
    if( $type or $size ) {
        $img .= '.01.'.$type.$size;
    }
    // Finish building the image URL
    $img .= '.jpg';
    
    // Now return the image
    return "<a href='http://www.amazon.com/dp/$asin'><img src='$img' /></a>";
}

// Helper function:
// Search $find_keys in array $in_array, return $default if not found
function boj_sc4_find( $find_keys, $in_array, $default ) {
    foreach( $find_keys as $key ) {
        if( isset( $in_array[$key] ) )
            return $in_array[$key];
    }
    return $default;
}


