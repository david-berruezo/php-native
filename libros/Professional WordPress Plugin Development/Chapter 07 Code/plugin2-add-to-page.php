<?php
/*
Plugin Name: Settings API example 2
Plugin URI: http://example.com/
Description: A complete and practical example of use of the Settings API. This one adds a field to the Privacy Settings page
Author: WROX
Author URI: http://wrox.com
*/

// Register and define the settings
add_action('admin_init', 'boj_myplugin_admin_init');
function boj_myplugin_admin_init(){
	register_setting(
		'privacy', 
		'boj_myplugin_options',
		'boj_myplugin_validate_options' 
	);
	
	add_settings_field(
		'boj_myplugin_text_string',
		'Enter text here',
		'boj_myplugin_setting_input',
		'privacy',
		'default'
	);

}

// Display and fill the form field
function boj_myplugin_setting_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'boj_myplugin_options' );
	$text_string = $options['text_string'];
	// echo the field
	echo "<input id='text_string' name='boj_myplugin_options[text_string]' type='text' value='$text_string' />";
}

// Validate user input (we want text only)
function boj_myplugin_validate_options( $input ) {
	$valid['text_string'] = preg_replace( '/[^a-zA-Z]/', '', $input['text_string'] );
	
	if( $valid['text_string'] != $input['text_string'] ) {
		add_settings_error(
			'boj_myplugin_text_string',
			'boj_myplugin_texterror',
			'Incorrect value entered!',
			'error'
		);		
	}
	
	return $valid;
}

