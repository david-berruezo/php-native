<?php 
/*
Plugin Name: Bio Widget
Plugin URI: http://webdevstudios.com/support/wordpress-plugins/
Description: Example widget that displays a user's bio
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

// use widgets_init Action hook to execute custom function
add_action( 'widgets_init', 'gmp_register_widgets' );

 //register our widget
function gmp_register_widgets() {
    register_widget( 'gmp_widget' );
}

//gmp_widget class
class gmp_widget extends WP_Widget {
    //process our new widget
    function gmp_widget() {
        $widget_ops = array('classname' => 'gmp_widget', 'description' => __('Example widget that displays a user\'s bio.','gmp-plugin') ); 
        $this->WP_Widget('gmp_widget_bio', __('Bio Widget','gmp-plugin'), $widget_ops);
    }
    //build our widget settings form
    function form($instance) {
        $defaults = array( 'title' => __('My Bio','gmp-plugin'), 'name' => '', 'bio' => '' ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = strip_tags($instance['title']);
        $name = strip_tags($instance['name']);
        $bio = strip_tags($instance['bio']);
        ?>
            <p><?php _e('Title','gmp-plugin') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"  type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p><?php _e('Name','gmp-plugin') ?>: <input class="widefat" name="<?php echo $this->get_field_name('name'); ?>"  type="text" value="<?php echo esc_attr($name); ?>" /></p>
            <p><?php _e('Bio','gmp-plugin') ?>: <textarea class="widefat" name="<?php echo $this->get_field_name('bio'); ?>" / > <?php echo esc_attr($bio); ?></textarea></p>
        <?php
    }
    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['name'] = strip_tags($new_instance['name']);
        $instance['bio'] = strip_tags($new_instance['bio']);
 
        return $instance;
    }
 
    //display our widget
    function widget($args, $instance) {
        extract($args);
 
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title'] );
        $name = empty($instance['name']) ? '&nbsp;' : apply_filters('widget_name', $instance['name']);
        $bio = empty($instance['bio']) ? '&nbsp;' : apply_filters('widget_bio', $instance['bio']); 
 
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
        echo '<p>' .__('Name','gmp-plugin') .': ' . $name . '</p>';
        echo '<p>' .__('Bio','gmp-plugin') .': ' . $bio . '</p>';
        echo $after_widget;
    }
}
?>