<?php
// Load the WordPress Environment
// Place this file in your WordPress root directory (where wp-load.php is)
require('./wp-load.php');
?>
<pre>
<?php

$url = 'http://www.example.com/bleh';

// Send GET request
$response = wp_remote_get( $url );

// Check for server response
if( is_wp_error( $response ) ) {

	$code = $response->get_error_message();
	wp_die( 'Requests could not execute. Error was: ' . $code );

}

// Check that the server sent a "404 Not Found" HTTP status code
if( wp_remote_retrieve_response_code( $response ) == 404 ) {
	
	wp_die( 'Link not found' );

}

// So far, so good
echo 'Link found';