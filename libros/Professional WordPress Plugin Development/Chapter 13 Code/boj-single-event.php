<?php 
/*
Plugin Name: Schedule Single Event Cron
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: schedules a single event to run in cron
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

//create the plugin menu
add_action( 'admin_menu', 'boj_cron_single_menu' );

function boj_cron_single_menu() {

	//create cron example settings page
    add_options_page( 'Cron Example Settings', 'Cron Settings', 'manage_options', 'boj-single-cron', 'boj_cron_single_settings' );
	
}

//create the custom hook for cron scheduling
add_action( 'boj_single_cron_hook', 'boj_cron_single_email_reminder' );

function boj_cron_single_email_reminder() {

	//send scheduled email
	wp_mail( 'you@example.com', 'Reminder', 'You have a meeting' );

}

function boj_cron_single_settings() {

	//verify event has not been scheduled
	if ( !wp_next_scheduled( 'boj_single_cron_hook' ) ) {
	
		//schedule the event to run in one hour
		wp_schedule_single_event( time()+3600, 'boj_single_cron_hook' );
		
	}

}
?>