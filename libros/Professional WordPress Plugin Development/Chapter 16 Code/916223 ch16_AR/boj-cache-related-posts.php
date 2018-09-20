<?php
/*
Plugin Name: Cache Related Posts
Plugin URI: http://example.com
Description: A related posts plugin that uses the object cache.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Add related posts to the content. */
add_filter( 'the_content', 'boj_cache_related_posts' );

/* Appends a list of related posts on single post pages. */
function boj_cache_related_posts( $content ) {

    /* If not viewing a single post, return the content. */
    if ( !is_singular( 'post' ) )
        return $content;

    /* Get the current post ID. */
    $post_id = get_the_ID();

    /* Get cached data for the specific post. */
    $cache = wp_cache_get( $post_id, 'boj_related_posts' );

    /* If no data has been cached. */
    if ( empty( $cache ) ) {

        /* Get the post categories. */
        $categories = get_the_category();

        /* Get related posts by category. */
        $posts = get_posts(
            array(
                'category' => absint( $categories[0]->term_id ),
                'post__not_in' => array( $post_id ),
                'numberposts' => 5
            )
        );

        /* If posts are found. */
        if ( !empty( $posts ) ) {

            /* Create header and open unordered list. */
            $cache = '<h3>Related Posts</h3>';
            $cache .= '<ul>';

            /* Loop through each post, getting a link to its single post page. */
            foreach ( $posts as $post ) {
                $cache .= '<li><a href="' . get_permalink( $post->ID ) . '">' . 
                    get_the_title( $post->ID ) . '</a></li>';
            }

            /* Close the unordered list. */
            $cache .= '</ul>';

            /* Cache the related post list for 12 hours. */
            wp_cache_set( $post_id, $cache, 'boj_related_posts', 60 * 60 * 12 );
        }
    }

    /* If there's cached data, append it to the content. */
    if ( !empty( $cache ) )
        $content .= $cache;

    /* Return the content. */
    return $content;
}

?>