<?php

function test_with_http_extension() {
	$r= new HttpRequest( 'http://wordpress.org/', HttpRequest::METH_GET );
	$r->send () ;
	echo $r->getResponseBody();
}

function test_with_fopen_stream() {
	$stream = fopen( 'http://wordpress.org/', 'r' );
	echo stream_get_contents( $stream );
	fclose($stream);
}

function test_with_fopen() {
	$handle = fopen( "http://wordpress.org/", "rb" );
	$contents = '';
	while( !feof( $handle ) ) {
	    $contents .= fread( $handle, 8192 );
	}
	fclose( $handle );
	echo $contents;
}

function test_with_fsockopen() {
	$fp = fsockopen( "wordpress.org", 80, $errno, $errstr, 30 );
	if (!$fp) {
	    echo "$errstr ($errno)<br />\n";
	} else {
	    $out = "GET / HTTP/1.1\r\n";
	    $out .= "Host: wordpress.org\r\n";
	    $out .= "Connection: Close\r\n\r\n";
	    fwrite($fp, $out);
	    while (!feof($fp)) {
	        echo fgets($fp, 128);
	    }
	    fclose($fp);
	}
}

function test_with_curl() {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, "http://wordpress.org/" );
	curl_setopt( $ch, CURLOPT_HEADER, 0 );
	curl_exec($ch);
	curl_close($ch);
}

if( isset( $_GET['method'] ) ) {

	$method = $_GET['method'];

	if( in_array( $method, array( 'curl', 'fsockopen', 'fopen', 'fopen_stream', 'http_extension' ) ) ) {
		echo "
		<p>Testing with transport: <strong>$method</strong> (<a href='javascript:history.back()'>test another method</a>)</p>
		<hr/>\n";
		call_user_func( 'test_with_'.$_GET['method'] );
	}

} else {
	?>
	<form method="GET" action="">
	<p>Select a transport and press Test</p>
	<select name="method">
		<option value="curl">cURL extension</option>
		<option value="fsockopen">fsockopen()</option>
		<option value="fopen">fopen()</option>
		<option value="fopen_stream">fopen() streams</option>
		<option value="http_extension">HTTP extension</option>
	</select>
	<input type="submit" value="Test" />
	</form>
	<?php
}
