<?php

add_action( 'init', 'boj_music_album_register_shortcodes' );

function boj_music_album_register_shortcodes() {

    /* Register the [music_albums] shortcode. */
    add_shortcode( 'music_albums', 'boj_music_albums_shortcode' );
}

function boj_music_albums_shortcode() {

    /* Query albums from the database. */
    $loop = new WP_Query(
        array(
            'post_type' => 'music_album',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
        )
    );

    /* Check if any albums were returned. */
    if ( $loop->have_posts() ) {

        /* Open an unordered list. */
        $output = '<ul class="music-collection">';

        /* Loop through the albums (The Loop). */
        while ( $loop->have_posts() ) {

            $loop->the_post();

            /* Display the album title. */
            $output .= the_title(
                '<li><a href="' . get_permalink() . '">',
                '</a></li>',
                false
            );

        }

        /* Close the unordered list. */
        $output .= '</ul>';
    }

    /* If no albums were found. */
    else {
        $output = '<p>No albums have been published.';
    }

    /* Return the music albums list. */
    return $output;
}

?>