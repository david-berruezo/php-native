<?php
/*
Plugin Name: Music Collection Post Types
Plugin URI: http://example.com
Description: Creates the music_album post type.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Set up the post types. */
add_action( 'init', 'boj_music_collection_register_post_types' );

/* Registers post types. */
function boj_music_collection_register_post_types() {

    /* Set up the arguments for the 'music_album' post type. */
    $album_args = array(
        'public' => true,
        'query_var' => 'music_album',
        'rewrite' => array(
            'slug' => 'music/albums',
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'labels' => array(
            'name' => 'Albums',
            'singular_name' => 'Album',
            'add_new' => 'Add New Album',
            'add_new_item' => 'Add New Album',
            'edit_item' => 'Edit Album',
            'new_item' => 'New Album',
            'view_item' => 'View Album',
            'search_items' => 'Search Albums',
            'not_found' => 'No Albums Found',
            'not_found_in_trash' => 'No Albums Found In Trash'
        ),
    );

    /* Register the music album post type. */
    register_post_type( 'music_album', $album_args );
}

?>