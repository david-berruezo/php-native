<?php
/*
Plugin Name: My Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A brief description of my plugin
Version: 1.0
Author: Brad Williams
Author URI: http://strangework.com
License: GPLv2
*/

/*  Copyright 2011  Brad Williams  (email : brad@pluginize.com)

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

register_activation_hook( __FILE__, 'boj_myplugin_install' );

function boj_myplugin_install() {
    if ( version_compare( get_bloginfo( 'version' ), '3.1', '<' ) ) {
        deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
    }
}

?>