<?php
/*
Plugin Name: Restrict Admin Post Editing
Plugin URI: http://example.com
Description: Only admins can edit posts made by admins.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Filter the 'map_meta_cap' hook. */
add_filter( 'map_meta_cap', 'boj_restrict_admin_post_editing', 10, 4 );

/* Function for restricting users from editing admin posts. */
function boj_restrict_admin_post_editing( $caps, $cap, $user_id, $args ) {

    /* If user is trying to edit or delete a post. */
    if ( 'edit_post' == $cap || 'delete_post' == $cap ) {

        /* Get the post object. */
        $post = get_post( $args[0] );

        /* If an admin is the post author. */
        if ( author_can( $post, 'delete_users' ) ) {

            /* Add a capability that only admins might have to the caps array. */
            $caps[] = 'delete_users';
        }
    }

    /* Return the array of capabilities. */
    return $caps;
}

?>