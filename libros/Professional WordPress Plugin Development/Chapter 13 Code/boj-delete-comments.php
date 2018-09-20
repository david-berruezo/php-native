<?php 
/*
Plugin Name: Delete Comments on a Schedule
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: Deletes spam and moderated comments older than days set
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

//create the custom hook for cron scheduling
add_action( 'boj_comment_cron_hook', 'boj_cron_delete_comments' );

function boj_cron_delete_comments() {
	global $wpdb;

	$options = get_option( 'boj_cron_comment_options' );
	$boj_comments = $options['boj_comments'];
	$boj_days_old = ( $options['boj_days_old'] ) ? absint( $options['boj_days_old'] ) : 30;

	//verify option is enabled
	if ( $boj_comments ) {
		
		if ( $boj_comments == "spam" ) {
			$boj_comment_status = 'spam';
		} elseif ( $boj_comments == "moderated" ) {
			$boj_comment_status = '0';
		}
		
		$sql = " DELETE FROM $wpdb->comments 
			WHERE ( comment_approved = '$boj_comment_status' )
			AND DATEDIFF( now(), comment_date ) > %d ";
		
		if ( $boj_comments == "both" ) {
			$sql = " DELETE FROM $wpdb->comments 
				WHERE ( comment_approved = 'spam' OR comment_approved = '0'  )
				AND DATEDIFF( now(), comment_date ) > %d ";
		}
	
		$wpdb->query( $wpdb->prepare( $sql, $boj_days_old ) );

	}

}

add_action( 'admin_init', 'boj_cron_comment_init' );

function boj_cron_comment_init(){

	//register the options in the Settings API
	register_setting(
		'discussion', 
		'boj_cron_comment_options' 
	);
	
	//register the select field in the Settings API
	add_settings_field(
		'boj_cron_comment_type_field',
		'Select Comments to Delete',
		'boj_cron_comment_type',
		'discussion',
		'default'
	);
	
	//register the text field in the Settings API
	add_settings_field(
		'boj_cron_days_old_field',
		'Delete Comments Older Than',
		'boj_cron_days_old',
		'discussion',
		'default'
	);

	//load the option value
	$options = get_option( 'boj_cron_comment_options' );
	$boj_comments = $options['boj_comments'];
	
	// if the option is enabled and not already scheduled lets schedule it
	if ( $boj_comments && !wp_next_scheduled( 'boj_comment_cron_hook' ) ) {
	
		//schedule the event to run daily
		wp_schedule_event( time(), 'daily', 'boj_comment_cron_hook' );
		
	// if the option is NOT enabled and scheduled lets unschedule it
	} elseif ( !$boj_comments && wp_next_scheduled( 'boj_comment_cron_hook' ) ) {
	
		//get time of next scheduled run
		$timestamp = wp_next_scheduled( 'boj_comment_cron_hook' );
		
		//unschedule custom action hook
		wp_unschedule_event( $timestamp, 'boj_comment_cron_hook' );

	}

}

function boj_cron_comment_type() {

	// load the 'boj_comments' option from the database
	$options = get_option( 'boj_cron_comment_options' );
	$boj_comments = $options['boj_comments'];

	//display the option select field
	echo '<select name="boj_cron_comment_options[boj_comments]">';
		echo '<option value="" '. selected( $boj_comments, '', false ) .'>None</option>';
		echo '<option value="spam" '. selected( $boj_comments, 'spam', false ) .'>Spam Comments</option>';
		echo '<option value="moderated" '. selected( $boj_comments, 'moderated', false ) .'>Moderated Comments</option>';
		echo '<option value="both" '. selected( $boj_comments, 'both', false ) .'>Both</option>';
	echo '</select>';
	
}

function boj_cron_days_old() {

	// load the 'boj_days_old' option from the database
	$options = get_option( 'boj_cron_comment_options' );
	$boj_days_old = ( $options['boj_days_old'] ) ? absint( $options['boj_days_old'] ) : 30;
	
	//display the option text field
	echo '<input type="text" name="boj_cron_comment_options[boj_days_old]" value="' .esc_attr( $boj_days_old ). '" size="3" /> Days';
	
}
?>