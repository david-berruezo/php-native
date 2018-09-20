<?php
/*
Plugin Name: User Avatars
Plugin URI: http://example.com
Description: Displays user avatars based on role.
Author: WROX
Author URI: http://wrox.com
*/

function boj_user_avatars( $role = 'subscriber' ) {

    /* Get the users based on role. */
    $users = get_users(
        array(
            'role' => $role
        )
    );

    /* Check if any users were returned. */
    if ( is_array( $users ) ) {

        /* Loop through each user. */
        foreach ( $users as $user ) {

            /* Display ther user's avatar. */
            echo get_avatar( $user );
        }
    }
}

?>