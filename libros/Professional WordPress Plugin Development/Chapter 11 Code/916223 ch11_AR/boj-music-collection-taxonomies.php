<?php

/* Set up the taxonomies. */
add_action( 'init', 'boj_music_collection_register_taxonomies' );

/* Registers taxonomies. */
function boj_music_collection_register_taxonomies() {

    /* Set up the artist taxonomy arguments. */
    $artist_args = array(
        'hierarchical' => false,
        'query_var' => 'album_artist', 
        'show_tagcloud' => true,
        'rewrite' => array(
            'slug' => 'music/artists',
            'with_front' => false
        ),
        'labels' => array(
            'name' => 'Artists',
            'singular_name' => 'Artist',
            'edit_item' => 'Edit Artist',
            'update_item' => 'Update Artist',
            'add_new_item' => 'Add New Artist',
            'new_item_name' => 'New Artist Name',
            'all_items' => 'All Artists',
            'search_items' => 'Search Artists',
            'popular_items' => 'Popular Artists',
            'separate_items_with_commas' => 'Separate artists with commas',
            'add_or_remove_items' => 'Add or remove artists',
            'choose_from_most_used' => 'Choose from the most popular artists',
        ),
    );

    /* Set up the genre taxonomy arguments. */
    $genre_args = array(
        'hierarchical' => true,
        'query_var' => 'album_genre', 
        'show_tagcloud' => true,
        'rewrite' => array(
            'slug' => 'music/genres',
            'with_front' => false
        ),
        'labels' => array(
            'name' => 'Genres',
            'singular_name' => 'Genre',
            'edit_item' => 'Edit Genre',
            'update_item' => 'Update Genre',
            'add_new_item' => 'Add New Genre',
            'new_item_name' => 'New Genre Name',
            'all_items' => 'All Genres',
            'search_items' => 'Search Genres',
            'parent_item' => 'Parent Genre',
            'parent_item_colon' => 'Parent Genre:',
        ),
    );

    /* Register the album artist taxonomy. */
    register_taxonomy( 'album_artist', array( 'music_album' ), $artist_args );

    /* Register the album genre taxonomy. */
    register_taxonomy( 'album_genre', array( 'music_album' ), $genre_args );
}

?>