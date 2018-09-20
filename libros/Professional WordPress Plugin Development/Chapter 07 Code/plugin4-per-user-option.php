<?php
/*
Plugin Name: Per User Setting example
Plugin URI: http://example.com/
Description: Add a user option in Profile to allow choosing either English or Spanish in the admin area
Author: WROX
Author URI: http://wrox.com
*/

// Return user's locale
function boj_adminlang_set_user_locale() {
	$user = wp_get_current_user();
	$userid = $user->ID;
	$locale = get_user_meta( $userid, 'boj_adminlang_lang', true );
	return $locale;
}
// Trigger this function every time WP checks the locale value
add_filter( 'locale', 'boj_adminlang_set_user_locale' );

// Add and fill an extra input field to user's profile
function boj_adminlang_display_field( $user ) {

	$userid = $user->ID;
	$lang = get_user_meta( $userid, 'boj_adminlang_lang', true );
	
	?>
	<tr>
		<th scope="row">Language</th>
		<td>
			<select name="boj_adminlang_lang">
				<option value="" <?php selected( '', $lang); ?>>English</option>
				<option value="es_ES" <?php selected( 'es_ES', $lang); ?>>Espa&ntilde;ol</option>
			</select>
		</td>
	</tr>
	<?php
}
add_action( 'personal_options', 'boj_adminlang_display_field' );

// Monitor form submits and update user's setting if applicable
function boj_adminlang_update_field( $userid ) {
	if( isset( $_POST['boj_adminlang_lang'] ) ) {
		$lang = $_POST['boj_adminlang_lang'] == 'es_ES' ? 'es_ES' : '';
		update_user_meta( $userid, 'boj_adminlang_lang', $lang );
	}
}
add_action( 'personal_options_update', 'boj_adminlang_update_field' );


