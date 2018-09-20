<?php 
/*
Plugin Name: Multisite Switch Example Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin to demonstrate Multisite site switching
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

add_action( 'admin_menu', 'boj_multisite_switch_menu' );

function boj_multisite_switch_menu() {

	//create custom top-level menu
	add_menu_page( 'Multisite Switch', 'Multisite Switch', 'manage_options', 'boj-network-switch', 'boj_multisite_switch_page' );

}
	
function boj_multisite_switch_page() {
	
	if ( is_multisite() ) {
		
		//switch to site ID 3
		switch_to_blog( 3 );

		//create a custom Loop
		$recentPosts = new WP_Query();
		$recentPosts->query( 'posts_per_page=5' );
		
		//start the custom Loop
		while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
		
			//store the recent posts in a variable
			echo '<p><a href="' .get_permalink(). '">' .get_the_title() .'</a></p>';
			
		endwhile;
		
		//restore the current site
		restore_current_blog();
		
	}
	
}
?>