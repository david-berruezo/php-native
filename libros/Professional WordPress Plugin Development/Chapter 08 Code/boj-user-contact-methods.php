<?php

/* Add a filter to the hook. */
add_filter( 'user_contactmethods', 'boj_user_contactmethods' );

/* Function for adding new contact methods. */
function boj_user_contactmethods( $user_contactmethods ) {

    /* Add the Twitter contact method. */
    $user_contactmethods['twitter'] = 'Twitter Username';

    /* Add the phone number contact method. */
    $user_contactmethods['phone'] = 'Phone Number';

    /* Return the array with the new values added. */
    return $user_contactmethods;
}

?>