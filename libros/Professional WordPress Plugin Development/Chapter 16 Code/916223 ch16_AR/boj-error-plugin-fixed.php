<?php
/*
Plugin Name: Error Plugin Fixed
Plugin URI: http://example.com
Description: Errors fixed in the "Error Plugin."
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Filter 'the_content'. */
add_filter( 'the_content', 'boj_error_plugin_author_box' );

/* Appends an author box to the end of posts. */
function boj_error_plugin_author_box( $content ) {
    global $post;

    /* If viewing a post with the 'post' post type. */
    if ( 'post' == $post->post_type ) {

        /* Open the author box <div>. */
        $author_box = '<div class="author-box">';

        /* Display the author name. */
        $author_box .= '<h3>' . get_the_author_meta( 'display_name' ) . '</h3>';

        /* Display the author description. */
        $author_box .= '<p>' . get_the_author_meta( 'description' ) . '</p>';

        /* Close the author box. */
        $author_box .= '</div>';
    }

    /* Append the author box to the content. */
    if ( isset( $author_box ) )
        $content = $content . $author_box;

    /* Return the content. */
    return $content;
}

?>