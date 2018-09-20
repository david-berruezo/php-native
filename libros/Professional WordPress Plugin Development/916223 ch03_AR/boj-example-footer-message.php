<?php
add_action( 'wp_footer', 'boj_example_footer_message', 100 );
function boj_example_footer_message() {
    echo 'This site is built using <a href="http://wordpress.org"
    title="WordPress publishing platform">WordPress</a>.';
}
?>