<?php
/*
Plugin Name: WordPress Menu Examples Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin to create menus and submenus in WordPress
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

add_action( 'admin_menu', 'boj_menuexample_create_menu' );

function boj_menuexample_create_menu() {
	
	//create a submenu under Settings
	add_options_page( 'My Plugin Settings Page', 'Menu Example Settings', 'manage_options', __FILE__, 'boj_menuexample_settings_page' );
	
}
?>