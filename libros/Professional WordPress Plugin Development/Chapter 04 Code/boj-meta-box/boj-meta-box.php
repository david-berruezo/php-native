<?php 
/*
Plugin Name: Meta Box Media Library Image Example
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: Adds the ability to select an image from the media library
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

//hook to create the meta box
add_action( 'add_meta_boxes', 'boj_mbe_image_create' );

function boj_mbe_image_create() {

	//create a custom meta box
	add_meta_box( 'boj-image-meta', 'Set Image', 'boj_mbe_image_function', 'post', 'normal', 'high' );
	
}

function boj_mbe_image_function( $post ) {

	//retrieve the meta data value if it exists
	$boj_mbe_image = get_post_meta( $post->ID, '_boj_mbe_image', true );
	?>
    Image <input id="boj_mbe_image" type="text" size="75" name="boj_mbe_image" value="<?php echo esc_url( $boj_mbe_image ); ?>" />
    	  <input id="upload_image_button" type="button" value="Media Library Image" class="button-secondary"  />
    <p>Enter an image URL or use an image from the Media Library</p>
	<?php
}

//script actions with page detection
add_action('admin_print_scripts-post.php', 'boj_mbe_image_admin_scripts');
add_action('admin_print_scripts-post-new.php', 'boj_mbe_image_admin_scripts');

function boj_mbe_image_admin_scripts() {
	wp_enqueue_script( 'boj-image-upload', plugins_url( '/boj-meta-box/boj-meta-image.js' ), array( 'jquery','media-upload','thickbox' ) );
}

//style actions with page detection
add_action('admin_print_styles-post.php', 'boj_mbe_image_admin_styles');
add_action('admin_print_styles-post-new.php', 'boj_mbe_image_admin_styles');

function boj_mbe_image_admin_styles() {
	wp_enqueue_style( 'thickbox' );
}

//hook to save the meta box data
add_action( 'save_post', 'boj_mbe_image_save_meta' );

function boj_mbe_image_save_meta( $post_id ) {

	//verify the meta data is set
	if ( isset( $_POST['boj_mbe_image'] ) ) {
	
		//save the meta data
		update_post_meta( $post_id, '_boj_mbe_image', esc_url_raw( $_POST['boj_mbe_image'] ) );

	}

}
?>