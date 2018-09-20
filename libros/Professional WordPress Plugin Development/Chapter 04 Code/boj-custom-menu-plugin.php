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

	//create custom top-level menu
	add_menu_page( 'My Plugin Settings Page', 'Menu Example Settings', 'manage_options', __FILE__, 'boj_menuexample_settings_page', plugins_url( '/images/wp-icon.png', __FILE__ ) );
	
	//create submenu items
	add_submenu_page( __FILE__, 'About My Plugin', 'About', 'manage_options', __FILE__.'_about', boj_menuexample_about_page );
	add_submenu_page( __FILE__, 'Help with My Plugin', 'Help', 'manage_options', __FILE__.'_help', boj_menuexample_help_page );
	add_submenu_page( __FILE__, 'Uinstall My Plugin', 'Uninstall', 'manage_options', __FILE__.'_uninstall', boj_menuexample_uninstall_page ); 

}

?>