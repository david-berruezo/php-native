<?php 
/*
Plugin Name: Blog Pester Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: Sends an email after 3 days with no new posts
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

//create the custom hook for cron scheduling
add_action( 'boj_pester_cron_hook', 'boj_cron_pester_check' );

function boj_cron_pester_check() {
	global $wpdb;

	//retrieve latest published post date
	$sql = " SELECT post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC LIMIT 1 ";
	$latest_post_date = $wpdb->get_var( $wpdb->prepare( $sql ) );
	
	if ( strtotime( $latest_post_date ) <= strtotime('-3 day') ) {
		//post is older than 3 days

		//populate email values
		$email_to = 'you@example.com';
		$email_subject = 'Blog Reminder';
		$email_msg = 'Water your blog!  Its been three days or more since your last post';
		
		//send scheduled email
		wp_mail( $email_to, $email_subject, $email_msg );

	}

}

add_action( 'admin_init', 'boj_cron_pester_init' );

function boj_cron_pester_init(){

	//register the options in the Settings API
	register_setting(
		'writing', 
		'boj_cron_pester_options' 
	);
	
	//register the field in the Settings API
	add_settings_field(
		'boj_cron_pester_field',
		'Enable Blog Pester?',
		'boj_cron_pester_setting',
		'writing',
		'default'
	);

	//load the option value
	$options = get_option( 'boj_cron_pester_options' );
	$boj_pester = $options['boj_pester'];
	
	// if the option is enabled and not already scheduled lets schedule it
	if ( $boj_pester == 'on' && !wp_next_scheduled( 'boj_pester_cron_hook' ) ) {
	
		//schedule the event to run hourly
		wp_schedule_event( time(), 'daily', 'boj_pester_cron_hook' );
		
	// if the option is NOT enabled and scheduled lets unschedule it
	} elseif ( $boj_pester != 'on' && wp_next_scheduled( 'boj_pester_cron_hook' ) ) {
	
		//get time of next scheduled run
		$timestamp = wp_next_scheduled( 'boj_pester_cron_hook' );
		
		//unschedule custom action hook
		wp_unschedule_event( $timestamp, 'boj_pester_cron_hook' );

	}

}

function boj_cron_pester_setting() {

	// load the 'boj_pester' option from the database
	$options = get_option( 'boj_cron_pester_options' );
	$boj_pester = $options['boj_pester'];

	//display the option checkbox
	echo "<input id='boj_pester' name='boj_cron_pester_options[boj_pester]' type='checkbox' ". checked( $boj_pester, 'on', false ). " />";
	
}

?>