<?php 
/*
Plugin Name: Delete Post Revisions 
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin demonstrating Cron in WordPress
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

//create our custom hook for cron scheduling
add_action('boj_del_rev_cron_hook', 'boj_cron_rev_delete');

function boj_cron_rev_delete() {
	global $wpdb;
	
	//generate query to delete revisions older than 30 days
	$sql = "DELETE a,b,c  
		FROM $wpdb->posts a  
		LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id)  
		LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id)  
		WHERE a.post_type = 'revision' 
		AND DATEDIFF( now(), a.post_modified ) > 30 ";

	//execute query to delete all post revisions and meta data
	$wpdb->query( $wpdb->prepare( $sql ) );

}

add_action('admin_init', 'boj_cron_rev_admin_init');

function boj_cron_rev_admin_init(){

	//register the options in the Settings API
	register_setting(
		'general', 
		'boj_cron_rev_options' 
	);
	
	//register the field in the Settings API
	add_settings_field(
		'boj_cron_rev_field',
		'Delete post revisions weekly?',
		'boj_cron_rev_setting_input',
		'general',
		'default'
	);

	//load the option value
	$options = get_option( 'boj_cron_rev_options' );
	$boj_del_rev = $options['boj_del_rev'];
	
	// if the option is enabled and not already scheduled lets schedule it
	if ( $boj_del_rev == 'on' && !wp_next_scheduled( 'boj_del_rev_cron_hook' ) ) {
	
		//schedule the event to run hourly
		wp_schedule_event( time(), 'weekly', 'boj_del_rev_cron_hook' );
		
	// if the option is NOT enabled and scheduled lets unschedule it
	} elseif ( $boj_del_rev != 'on' && wp_next_scheduled( 'boj_del_rev_cron_hook' ) ) {
	
		//get time of next scheduled run
		$timestamp = wp_next_scheduled( 'boj_del_rev_cron_hook' );
		
		//unschedule custom action hook
		wp_unschedule_event( $timestamp, 'boj_del_rev_cron_hook' );

	}

}

function boj_cron_rev_setting_input() {

	// load the 'boj_del_rev' option from the database
	$options = get_option( 'boj_cron_rev_options' );
	$boj_del_rev = $options['boj_del_rev'];

	echo "<input id='boj_del_rev' name='boj_cron_rev_options[boj_del_rev]' type='checkbox' ". checked( $boj_del_rev, 'on', false ). " />";
	
}

//register a weekly recurrence
add_filter( 'cron_schedules', 'boj_cron_add_weekly' ); 

function boj_cron_add_weekly( $schedules ) {

	//create a 'weekly' recurrence schedule
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display' => 'Once Weekly'
	);
	
	return $schedules;
}

?>