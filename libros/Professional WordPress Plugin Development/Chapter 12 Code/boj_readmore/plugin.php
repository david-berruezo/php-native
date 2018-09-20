<?php
/*
Plugin Name: Ajax Read More
Plugin URI: http://example.com/
Description: Ajaxify the "Read more" links
Version: 1.0
Author: Ozh
Author URI: http://wrox.com
*/

// Flag to state if the script is needed
global $boj_arm_needjs;
$boj_arm_needjs = false;

// Plugin version, bump it up if you update the plugin
define( 'BOJ_ARM_VERSION', '1.0' );

// Enqueue the script, in the footer
add_action( 'template_redirect', 'boj_arm_add_js' );
function boj_arm_add_js() {

    // Enqueue the script
    wp_enqueue_script( 'boj_arm',
        plugin_dir_url( __FILE__ ).'js/script.js',
        array('jquery'), BOJ_ARM_VERSION, true
    );

    // Get current page protocol
    $protocol = isset( $_SERVER["HTTPS"]) ? 'https://' : 'http://';

    // Output admin-ajax.php URL with same protocol as current page
    $params = array(
      'ajaxurl' => admin_url( 'admin-ajax.php', $protocol )
    );
    wp_localize_script( 'boj_arm', 'boj_arm', $params );
}

// Don't add the script if actually not needed
add_action( 'wp_print_footer_scripts', 'boj_arm_footer_maybe_remove', 1 );
function boj_arm_footer_maybe_remove() {
    global $boj_arm_needjs;
    if( !$boj_arm_needjs ) {
        wp_deregister_script( 'boj_arm' );
    }
}

// Inspect each post to check if there's a "read more" tag
add_action( 'the_post', 'boj_arm_check_readmore' );
function boj_arm_check_readmore( $post ) {
    if ( preg_match('/<!--more(.*?)?-->/', $post->post_content )
    && !is_single() ) {
        global $boj_arm_needjs; 
        $boj_arm_needjs = true;
    }
}

// Ajax handler
add_action('wp_ajax_nopriv_boj_arm_ajax', 'boj_arm_ajax');
add_action('wp_ajax_boj_arm_ajax', 'boj_arm_ajax');
function boj_arm_ajax() {
    // Modify the way WP gets post content
    add_filter( 'the_content', 'boj_arm_get_2nd_half' );

    // setup Query
    query_posts( 'p='.absint( $_REQUEST['post_id'] ) );

    // "The Loop"
    if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
    endwhile; else:
        echo "post not found :/";
    endif;

    // reset Query
    wp_reset_query();
    die();
}

// Get second part of a post after the "more" jump
function boj_arm_get_2nd_half( $content ) {
    $id = absint( $_REQUEST['post_id'] );
    $content = preg_replace( "!^.*<span id=\"more-$id\"></span>!s", '', $content );
    return $content;
}
