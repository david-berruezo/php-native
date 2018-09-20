<?php
// Load the WordPress Environment
// Place this file in your WordPress root directory (where wp-load.php is)
require('./wp-load.php');
?>
<pre>
<?php

// Disable all transports but curl
function boj_onlycurl_force_curl() {
    add_filter( 'use_fsockopen_transport', '__return_false' );
    add_filter( 'use_fopen_transport', '__return_false' );
    add_filter( 'use_streams_transport', '__return_false' );
    add_filter( 'use_http_extension_transport', '__return_false' );
}

// Add a custom parameter to the CURL requests:
// display only file names of FTP directories (no attributes, size etc...)
function boj_onlycurl_hack_curl_handle( $handle ) {
    curl_setopt( $handle, CURLOPT_FTPLISTONLY, true );
    return $handle;
}

// Hook CURL requests to the above function
add_action( 'http_api_curl', 'boj_onlycurl_hack_curl_handle' );

// Now do the job
boj_onlycurl_force_curl();

var_dump( wp_remote_get( 'ftp://ftp.gnu.org' ) );

