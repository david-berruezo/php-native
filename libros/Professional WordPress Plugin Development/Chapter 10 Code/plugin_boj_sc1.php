<?php
/*
Plugin Name: Shortcode Example 1
Plugin URI: http://example.com/
Description: Replace [book] with a long Amazon link
Version: 1.0
Author: Ozh
Author URI: http://wrox.com/
*/

// Register a new shortcode: [book]
add_shortcode( 'book', 'boj_sc1_book' );

// The callback function that will replace [book]
function boj_sc1_book() {
	return 'http://www.amazon.com/dp/0470560541';
}

