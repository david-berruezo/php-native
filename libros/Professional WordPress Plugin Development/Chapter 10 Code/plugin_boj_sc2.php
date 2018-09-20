<?php
/*
Plugin Name: Shortcode Example 2
Plugin URI: http://example.com/
Description: Replace [books title="xxx"] with different Amazon links
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

// Register a new shortcode: [books title="xxx"]
add_shortcode( 'books', 'boj_sc2_multiple_books' );

// The callback function that will replace [books]
function boj_sc2_multiple_books( $attr ) {
    switch( $attr['title'] ) {
        case 'xkcd':
            $isbn = '0615314465';
            $title = 'XKCD Volume 0';
            break;

        default:
        case 'prowp':
            $isbn = '0470560541';
            $title = 'Profesional WordPress';
            break;
    }

    return "<a href='http://www.amazon.com/dp/$isbn'>$title</a>";
}