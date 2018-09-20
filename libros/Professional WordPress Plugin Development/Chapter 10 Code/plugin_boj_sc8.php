<?php
/*
Plugin Name: Shortcode Example 8
Plugin URI: http://example.com/
Description: Various shortcodes: [24hours], [members], [email]
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

add_shortcode( '24hours', 'boj_sc8_24hours' );

function boj_sc8_24hours( $attr, $content ) {
    $now = time();
    $post_time = get_the_date( 'U' );
    if( ( $now - $post_time ) > 86400 ) {
        return 'Offer has expired!';
    } else {
        return $content;
    }
}

add_shortcode( 'members', 'boj_sc8_loggedin' );

function boj_sc8_loggedin( $attr, $content ) {
    if( is_user_logged_in() ) {
        return $content;
    } else {
        return "<p>Members Eyes Only</p>";
    }
}

add_shortcode( 'email', 'boj_sc8_email' );

function boj_sc8_email( $attr, $content ) {
    if( is_email( $content ) ) {
        return sprintf( '<a href="mailto:%s">%s</a>',
            antispambot( $content ),
            antispambot( $content )
        );
    } else {
        return '';
    }
}


