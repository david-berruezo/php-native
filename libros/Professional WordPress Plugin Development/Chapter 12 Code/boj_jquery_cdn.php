<?php

// Replace in-house jQuery with Google's one

add_action( 'init', 'boj_jquery_from_cdn' );
if( !function_exists( 'boj_jquery_from_cdn' ) ) {
    function boj_jquery_from_cdn() {
        wp_deregister_script( 'jquery' );
        wp_register_script(
            'jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'
        );
    }
}

?>
