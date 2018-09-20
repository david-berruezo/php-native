<?php 
/*
Plugin Name: Multisite Switch Shortcode Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin to aggregating content using a shortcode
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

add_shortcode( 'network_posts', 'boj_multisite_network_posts' );

function boj_multisite_network_posts( $attr ) {
	extract( shortcode_atts( array(
			"blogid"	=>	'1',
			"num"		=>  '5'
			), $attr ) );

	if ( is_multisite() ) {
	
		$return_posts = '';
		
		//switch to site set in the shortcode
		switch_to_blog( absint( $blogid ) );

		//create a custom Loop
		$recentPosts = new WP_Query();
		$recentPosts->query( 'posts_per_page=' .absint( $num ) );
		
		//start the custom Loop
		while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
		
			//store the recent posts in a variable
			$return_posts .= '<p><a href="' .get_permalink(). '">' .get_the_title() .'</a></p>';
			
		endwhile;
		
		//restore the current site
		restore_current_blog();
		
		//return the results to display
		return $return_posts;
		
	}
}
?>