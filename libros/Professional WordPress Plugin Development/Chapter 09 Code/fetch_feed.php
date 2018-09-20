<?php
// Load the WordPress Environment
// Place this file in your WordPress root directory (where wp-load.php is)
require('./wp-load.php');
?>
<?php

// Get a SimplePie object from a feed source.
$rss = fetch_feed('http://planetozh.com/blog/feed/');

// Make sure the Simplepie object is created correctly
if( is_wp_error( $rss ) )
    wp_die( 'Could not fetch feed' );
    
echo 'Feed found, contains '. $rss->get_item_quantity() . ' articles.';

// Build an array of the 5 first elements, starting from item #0
$rss_items = $rss->get_items( 0, 5 );

// Start ordered list
echo '<ol>';

// Loop through each item and display its link, title and date
foreach( $rss_items as $item ) {
    $title = $item->get_title();
    $date  = $item->get_date('Y/m/d @ g:i a');
    $link  = $item->get_permalink();

    echo "<li><a href='$link'>$title</a> ($date)</li>\n";
}

// Close ordered list
echo '</ol>';
