<?php 
/*
Plugin Name: Multsite Auto-Add User to Site
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: Plugin automatically adds the user to any site they visit
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

add_action( 'init', 'boj_multisite_add_user_to_site' );

function boj_multisite_add_user_to_site() {

	//verify user is logged in before proceeding
	if( !is_user_logged_in() )
		return false;
	
	//load current blog ID and user data
	global $current_user,$blog_id;

	//verify user is not a member of this site	 
	if( !is_blog_user() ) {
		
		//add user to this site as a subscriber
		add_user_to_blog( $blog_id, $current_user->ID, 'subscriber' );
		
	}
	 
}

?>