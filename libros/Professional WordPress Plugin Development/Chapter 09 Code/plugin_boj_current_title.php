<?php
/*
Plugin Name: On Air
Plugin URI: http://example.com/
Description: Cet current song on air from an online radio
Author: WROX
Author URI: http://wrox.com
*/

// Get current title on radio KNAC
function boj_onair_fetch_song_title_from_radio() {
    $url = 'http://knac.com/text1.txt';

    $text = wp_remote_retrieve_body( wp_remote_get( $url ) );
    
    preg_match( '/\<current_song\>(.*)/', $text, $matches );
    $song = trim( $matches[1] );

    preg_match( '/\<current_artist\>(.*)/', $text, $matches );
    $artist = trim( $matches[1] );

    return "$song by $artist";
} 


// Get song title from database and return it
function boj_onair_get_song_title() {
	
	// Get transient value
	$title = get_transient( 'boj_onair_song' );
	
	// If the transient does not exists or has expired, refresh it
	if( false === $title ) {
		$title = boj_onair_fetch_song_title_from_radio();
		set_transient( 'boj_onair_song', $title, 180 );
	}
	
	return $title;
}