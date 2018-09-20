<?php
/*
Plugin Name: Custom Settings Section
Plugin URI: http://webdevstudios.com/support/wordpress-plugins/
Description: Example showing how to add a custom settings section to Settings > Reading
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
add_action('admin_init', 'gmp_settings_init');

function gmp_settings_init() {
    //create the new setting section on the Settings > Reading page
    add_settings_section('gmp_setting_section', 'GMP Plugin Settings', 'gmp_setting_section', 'reading'); 

    // register the individual setting options 
    add_settings_field('gmp_setting_enable_id', 'Enable GMP Plugin?', 'gmp_setting_enabled', 'reading', 'gmp_setting_section');
    add_settings_field('gmp_saved_setting_name_id', 'Your Name', 'gmp_setting_name', 'reading', 'gmp_setting_section');

    // register our setting to store our array of values    
	register_setting('reading','gmp_setting_values');
}
 
// settings section
function gmp_setting_section() {
    echo '<p>Configure the GMP plugin options below</p>'; 
}


// create the enabled checkbox option to save the checkbox value
function gmp_setting_enabled() {
    // if the option exists the checkbox needs to be checked
    $gmp_options = get_option('gmp_setting_values');
    If ($gmp_options['enabled']) { 
        $checked = ' checked="checked" ';
    }

    //display the checkbox form field
    echo '<input '.$checked.' name="gmp_setting_values[enabled]" type="checkbox" />  Enabled';

}
 
// create the text field setting to save the name
function gmp_setting_name() {
    //load the option value
    $gmp_options = get_option('gmp_setting_values');
    $name = $gmp_options['name'];

    //display the text form field
    echo '<input type="text" name="gmp_setting_values[name]" value="'.esc_attr($name).'" />' ;
}
?>