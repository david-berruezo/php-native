<?php
// Load the WordPress Environment
// Place this file in your WordPress root directory (where wp-load.php is)
require('./wp-load.php');
?>
<pre>
<?php

$bad_urls = array(
   'malformed',
   'http://0.0.0.0/',
   'irc://example.com/',
   'http://inexistant',
);

foreach( $bad_urls as $bad_url ) {
	$response = wp_remote_head( $bad_url, array('timeout'=>1) );
	if( is_wp_error( $response ) ) {
		$error = $response->errors['http_request_failed'][0];
		echo "<p>$bad_url returned: <br/> $error </p>";
	}
}

