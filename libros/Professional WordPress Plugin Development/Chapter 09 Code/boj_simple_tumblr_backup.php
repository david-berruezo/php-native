<?php
/*
Plugin Name: Simple Tumblr Backup
Plugin URI: http://example.com/
Description: Backup posts as you publish them to a Tumblr account
Author: WROX
Version: 1.00
Author URI: http://wrox.com/
*/

// Edit this:
define( 'BOJ_STB_TUMBLR_EMAIL', 'email@example.com' );
define( 'BOJ_STB_TUMBLR_PASSW', '132456' );

// Actions when new post is published
add_action( 'new_to_publish',     'boj_stb_newpost' );
add_action( 'draft_to_publish',   'boj_stb_newpost' );
add_action( 'pending_to_publish', 'boj_stb_newpost' );
add_action( 'future_to_publish',  'boj_stb_newpost' );

// Function called when new post. Expecting post object.
function boj_stb_newpost( $post ) {

	// Get post information
	$post_title   = $post->post_title;
	$post_content = $post->post_content;
	
	// URL of the Tumblr API
	$api = 'http://www.tumblr.com/api/write';

	// Data for the POST request
	$data = array(
	       'email' => BOJ_STB_TUMBLR_EMAIL,
	    'password' => BOJ_STB_TUMBLR_PASSW,
	        'type' => 'regular',
	       'title' => $post_title,
	        'body' => $post_content
	);

	// Do the POST request
	$response = wp_remote_post( $api,
	    array(
	        'body' => $data,
	        'timeout' => 20
	    )
	);
	
	// All done!	
}



?>