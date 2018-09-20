<?php 
/*
Plugin Name: Cron Example Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin demonstrating Cron in WordPress
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

add_action( 'admin_menu', 'boj_cron_menu' );

function boj_cron_menu() {

	//create cron example settings page
    add_options_page( 'Cron Example Settings', 'Cron Settings', 'manage_options', 'boj-cron', 'boj_cron_settings' );
	
}

add_action('boj_cron_hook', 'boj_cron_email_reminder');

function boj_cron_email_reminder() {

	//send scheduled email
	wp_mail( 'you@example.com', 'Elm St. Reminder', 'Don\'t fall asleep!' );
	
}

function boj_cron_settings() {

	//verify event has not been scheduled
	if ( !wp_next_scheduled( 'boj_cron_hook' ) ) {
	
		//schedule the event to run hourly
		wp_schedule_event( time(), 'hourly', 'boj_cron_hook' );
		
	}

}
?>