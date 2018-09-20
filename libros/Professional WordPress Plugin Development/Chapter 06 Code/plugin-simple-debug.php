<?php
/*
Plugin Name: Simple Debug
Plugin URI: http://example.com/
Description: Append ?debug=1 to any URL to display debug information if you are an admin
Author: WROX
Author URI: http://wrox.com
*/

add_action( 'init', 'boj_debug_check' );

function boj_debug_check() {
    if( isset( $_GET['debug'] ) && current_user_can( 'manage_options' ) ) {
        if( !defined( 'SAVEQUERIES' ) )
            define( 'SAVEQUERIES', true );
        add_action( 'wp_footer', 'boj_debug_output' );
    }
}

// Print debug information
function boj_debug_output() {
    global $wpdb;
    echo "<pre>";
    print_r($wpdb->queries);
    echo "</pre>";
}
