<?php
/*
Plugin Name: Image feed
Plugin URI: http://example.com/
Description: Add a feed for latest uploaded images
Version: 1.0
Author: Ozh
Author URI: http://wrox.com
*/

// Add permalink structure and flush on plugin activation
register_activation_hook( __FILE__, 'boj_addfeed_activate' );
function boj_addfeed_activate() {
    boj_addfeed_add_feed();
    flush_rewrite_rules();
}

// Flush on plugin deactivation
register_deactivation_hook( __FILE__, 'boj_addfeed_deactivate' );
function boj_addfeed_deactivate() {
    flush_rewrite_rules();
}

// Register the feed
add_filter( 'init', 'boj_addfeed_add_feed' );
function boj_addfeed_add_feed() {
    add_feed( 'img', 'boj_addfeed_do_feed' );
}

// Echo the feed
function boj_addfeed_do_feed( $in ) {

    // Make custom query to get last attachments
    query_posts(array( 'post_type' => 'attachment', 'post_status' => 'inherit' ));
    
    header('Content-Type: application/atom+xml');
    echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
    ?>

<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="text">Latest images on <?php bloginfo_rss('name'); ?></title>
    <?php
    // Start the Loop
    while (have_posts()) : the_post();
    ?>
    <entry>
        <title><![CDATA[<?php the_title_rss() ?>]]></title>
        <link href="<?php the_permalink_rss() ?>" />
        <published><?php echo get_post_time('Y-m-d\TH:i:s\Z'); ?></published>
        <content type="html"><![CDATA[<?php the_content() ?>]]></content>
    </entry>
    <?php
    // End of the Loop
    endwhile ;
    ?>
</feed>

    <?php
}

