<?php
/*
Plugin Name: Add JavaScript
Plugin URI: http://example.com/
Description: Demonstrates how to properly insert JS into different pages
Author: Ozh
Author URI: http://wrox.com
*/

// URL to the /js directory of the plugin
define( 'BOJ_INSERTJS', plugin_dir_url( __FILE__).'js' );

// Add new admin pages
add_action('admin_menu', 'boj_insertjs_add_page');
function boj_insertjs_add_page() {
    // Add JS to all the admin pages
    wp_enqueue_script( 'boj_insertjs_1', BOJ_INSERTJS.'/script.js.php?where=admin' );

    // Add a page under Settings
    $settings = add_options_page( 'Insert JS', 'Insert JS', 'manage_options',
        'boj_insertjs_settings', 'boj_insertjs_options_page'
    );
    
    // Add JS to the setting page
    add_action( 'load-'.$settings, 'boj_insertjs_add_settings_script' );
    
    // Add a page under Users
    $users = add_users_page( 'Insert JS', 'Insert JS', 'manage_options',
        'boj_insertjs_users', 'boj_insertjs_users_page'
    );
    
    // Add JS to the users page, with a different hook
    add_action( 'admin_print_scripts-'.$users, 'boj_insertjs_add_users_script' );
}

// Add JS to the plugin's settings page
function boj_insertjs_add_settings_script() {
    wp_enqueue_script( 'boj_insertjs_2', BOJ_INSERTJS.'/script.js.php?where=settings' );
}

// Add JS to the plugin's users page, in the page footer
function boj_insertjs_add_users_script() {
    wp_enqueue_script( 'boj_insertjs_3', BOJ_INSERTJS.'/script.js.php?where=users',
        '', '', true
    );
}

// Add JS to the Comments page
add_action( 'load-edit-comments.php', 'boj_insertjs_on_comments' );
function boj_insertjs_on_comments() {
    wp_enqueue_script( 'boj_insertjs_4', BOJ_INSERTJS.'/script.js.php?where=comments' );
}


// Add JS to pages of the blog
add_action( 'template_redirect', 'boj_insertjs_add_scripts_blog' );
function boj_insertjs_add_scripts_blog() {
    // To all pages of the blog
    wp_enqueue_script( 'boj_insertjs_5', BOJ_INSERTJS.'/script.js.php?where=blog' );
    
    // To single post pages
    if( is_single() ) {
        wp_enqueue_script( 'boj_insertjs_6', BOJ_INSERTJS.'/script.js.php?where=single' );
    }
    
    // To the "About" page
    if( is_page('About') ) {
        wp_enqueue_script( 'boj_insertjs_7', BOJ_INSERTJS.'/script.js.php?where=about' );
    }
}


// Draw options page
function boj_insertjs_options_page() {
    ?>
    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Insert JavaScript</h2>
    
    <?php
    var_dump( plugin_basename( dirname(__FILE__) ) );
    var_dump( plugin_dir_url( __FILE__) );
    ?>
    
    <p>This sample plugin selectively adds different JS to the following pages:</p>
    <ol>
        <li>Admin part:
        <ol>
            <li>This very page</li>
            <li>This plugin page under the Users menu</li>
            <li>The Comments page</li>
        </ol></li>
        <li>Blog part:
        <ol>
            <li>All blog pages</li>
            <li>Single post pages</li>
        </ol></li>
    </ol>
    </div>
    <?php
}

// Draw users page
function boj_insertjs_users_page() {
    ?>
    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Insert JavaScript</h2>
    <p>This is another sample page. Here, the JS is added in the footer (view page source).</p>
    </div>
    <?php
}

