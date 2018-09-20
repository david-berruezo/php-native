<?php 
/*
Plugin Name: Custom Options Page
Plugin URI: http://webdevstudios.com/support/wordpress-plugins/
Description: Example showing how to create an options page
Version: 1.0
Author: Brad Williams
Author URI: http://strangework.com
*/

/*  Copyright 2010  Brad Williams  (email : brad@webdevstudios.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//execute our settings section function

// create custom plugin settings menu
add_action('admin_menu', 'gmp_create_menu');

function gmp_create_menu() {

    //create new top-level menu
    add_menu_page('GMP Plugin Settings', 'GMP Settings', 'administrator', __FILE__, 'gmp_settings_page', plugins_url('/images/wordpress.png', __FILE__)); 

    //call register settings function
    add_action( 'admin_init', 'gmp_register_settings' );
}


function gmp_register_settings() {
    //register our settings
    register_setting( 'gmp-settings-group', 'gmp_option_name' );
    register_setting( 'gmp-settings-group', 'gmp_option_email' );
    register_setting( 'gmp-settings-group', 'gmp_option_url' );
}

function gmp_settings_page() {
?>
<div class="wrap">
<h2><?php _e('GMP Plugin Options', 'gmp-plugin') ?></h2>

<form method="post" action="options.php">
    <?php settings_fields( 'gmp-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Name', 'gmp-plugin') ?></th>
        <td><input type="text" name="gmp_option_name" value="<?php echo get_option('gmp_option_name'); ?>" /></td> 
        </tr>
         
        <tr valign="top">
        <th scope="row"><?php _e('Email', 'gmp-plugin') ?></th>
        <td><input type="text" name="gmp_option_email" value="<?php echo get_option('gmp_option_email'); ?>" /></td> 
        </tr>
        
        <tr valign="top">
        <th scope="row"><?php _e('URL', 'gmp-plugin') ?></th>
        <td><input type="text" name="gmp_option_url" value="<?php echo get_option('gmp_option_url'); ?>" /></td> 
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'gmp-plugin') ?>" /> 
    </p>

</form>
</div>
<?php } ?>  