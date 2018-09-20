<?php
/*
Plugin Name: Instant Delete Comment
Plugin URI: http://example.com/
Description: Add a quick link to instantly delete comments
Author: Ozh
Version: 1.0
Author URI: http://wrox.com/
*/

// Add script on single post & pages with comments only, if user has edit rights
add_action( 'template_redirect', 'boj_idc_addjs_ifcomments' );
function boj_idc_addjs_ifcomments() {
    if( is_single() && current_user_can( 'moderate_comments' ) ) {
        global $post;
        if( $post->comment_count ) {
            $path = plugin_dir_url( __FILE__ );

            wp_enqueue_script( 'boj_idc', $path.'js/script.js' );
            $protocol = isset( $_SERVER["HTTPS"]) ? 'https://' : 'http://';
            $params = array(
              'ajaxurl' => admin_url( 'admin-ajax.php', $protocol )
            );
            wp_localize_script( 'boj_idc', 'boj_idc', $params );
        }
    }
}

// Add an admin link to each comment
add_filter( 'comment_text', 'boj_idc_add_link' );
function boj_idc_add_link( $text ) {
    // Get current comment ID
    global $comment;
    $comment_id = $comment->comment_ID;

    // Get link to admin page to trash comment, and add nonces to it
    $link = admin_url( 'comment.php?action=trash&c='.$comment_id );
    $link = wp_nonce_url( $link, 'boj_idc-delete-'.$comment_id );
    $link = "<a href='$link' class='boj_idc_link'>delete comment</a>";
    
    // Append link to comment text
    return $text."<p>[admin: $link]</p>";
}

// Ajax handler
add_action( 'wp_ajax_boj_idc_ajax_delete', 'boj_idc_ajax_delete' );
function boj_idc_ajax_delete() {
    $cid = absint( $_POST['cid'] );
    
    $response = new WP_Ajax_Response;

    if(
        current_user_can( 'moderate_comments' ) &&
        check_ajax_referer( 'boj_idc-delete-'.$cid, 'nonce', false ) &&
        wp_delete_comment( $cid  )
    ) {
        // Request successful
        $response->add( array(
            'data' => 'success',
            'supplemental' => array(
                'cid'     => $cid,
                'message' => 'this comment has been deleted'
            ),
        ) );
    } else {
        // Request failed
        $response->add( array(
            'data' => 'error',
            'supplemental' => array(
                'cid'     => $cid,
                'message' => 'an error occured'
            ),
        ) );
    }

    $response->send();
    
    exit();
}