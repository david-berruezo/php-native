<?php
/*
Plugin Name: Transients API example
Plugin URI: http://example.com/
Description: Sample plugin to illustrate how the Transients API works.
Author: WROX
Author URI: http://wrox.com
*/

// Fictional function that fetchs from an online radio a song title currently on air
function boj_myplugin_fetch_song_title_from_radio() {
	/*
	Here you would find code fetching data from a remote web site.
	See Chapter 10 to learn how to do this.
	
	In this example we will just return a random song title from a few fictional ones
	*/
	
	$titles = array(
		'I Heart WordPress - by WROX Hackers',
		'Highway to Heaven - by AB/CD',
		'WorpDress Roks - by Miss Spellings',
		'Careful With That Hack, Eugene - by Fink Ployd'
	);
	
	// Get a random song title and return it
	$random = $titles[ mt_rand(0, count($titles) - 1) ];
	return $random;
}

// Get song title from database and return it
function boj_myplugin_get_song_title() {
	
	// Get transient value
	$title = get_transient( 'boj_myplugin_song' );
	
	// If the transient does not exists or has expired, refresh it
	if( false === $title ) {
		$title = boj_myplugin_fetch_song_title_from_radio();
		set_transient( 'boj_myplugin_song', $title, 180 );
	}
	
	return $title;
}