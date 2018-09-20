<?php
/*
Plugin Name: Private Content
Plugin URI: http://example.com
Description: Shortcode for hiding private content.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Register shortcodes in 'init'. */
add_action( 'init', 'boj_private_content_register_shortcodes' );

/* Function for registering the shortcode. */
function boj_private_content_register_shortcodes() {

    /* Adds the [boj-private] shortcode. */
    add_shortcode( 'boj-private', 'boj_private_content_shortcode' );
}

/* Function for handling shortcode output. */
function boj_private_content_shortcode( $attr, $content = null ) {

    /* If there is no content, return. */
    if ( is_null( $content ) )
        return $content;

    /* Check if the current user has the 'read_private_content' capability. */
    if ( current_user_can( 'read_private_content' ) ) {

        /* Return the private content. */
        return $content;
    }

    /* If the user doesn't have the 'read_private_content' capability. */
    else {

        /* Return an alternate message. */
        return '<p>You do not have permission to read this content.</p>';
    }

    /* Return an empty string as a fallback. */
    return '';
}

?>