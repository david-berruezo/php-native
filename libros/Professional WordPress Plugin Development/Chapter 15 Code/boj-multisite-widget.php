<?php
/*
Plugin Name: Multisite Recent Posts Widget
Plugin URI:  http://example.com
Description: Retrieves a list of the most recent posts in a Multisite network
Author: Brad Williams
Version: 1.0
Author URI: http://wrox.com
*/

//widgets_init action hook to execute custom function
add_action( 'widgets_init', 'boj_multisite_register_widget' );

//register our widget
function boj_multisite_register_widget() {
	register_widget( 'boj_multisite_widget' );
}

//boj_multisite_widget class
class boj_multisite_widget extends WP_Widget {

	//process our new widget
	function boj_multisite_widget() {
	
		$widget_ops = array( 'classname' => 'boj_multisite_widget', 'description' => 'Display recent posts from a network site.' );
		$this->WP_Widget( 'boj_multisite_widget_posts', 'Multisite Recent Posts', $widget_ops );
		
	}
 
 	//build our widget settings form
	function form( $instance ) {
		global $wpdb;
		
		$defaults = array( 'title' => 'Recent Posts', 'disp_number' => '5' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$siteid = $instance['siteid'];
		$disp_number = $instance['disp_number'];

		//title textfield widget option
        echo '<p>Title: <input class="widefat" name="' .$this->get_field_name( 'title' ). '" type="text" value="' .esc_attr( $title ). '" /></p>';
		
		//get a list of all public site IDs
		$sql = "SELECT blog_id FROM $wpdb->blogs 
			WHERE public = '1' AND archived = '0' AND mature = '0' 
			AND spam = '0' AND deleted = '0' ";
		$blogs = $wpdb->get_col( $wpdb->prepare( $sql ) );
		
		if ( is_array( $blogs ) ) {
		
			echo '<p>';
			echo 'Site to display recent posts';
			echo '<select name="' .$this->get_field_name('siteid') .'" class="widefat" >';
			
			//loop through the site IDs
			foreach ($blogs as $blog) {
	
				//display each site as an option
				echo '<option value="' .$blog. '" ' .selected( $blog, $siteid ). '>' .get_blog_details( $blog )->blogname. '</option>';
				
			}
			
			echo '</select>';
			echo '</p>';
		}

		//number to display textfield widget option
		echo '<p>Number to display: <input class="widefat" name="' .$this->get_field_name( 'disp_number' ). '" type="text" value="' .esc_attr( $disp_number ). '" /></p>';
	}
 
  	//save the widget settings
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['siteid'] = absint( $new_instance['siteid'] );
		$instance['disp_number'] = absint( $new_instance['disp_number'] );
 
		return $instance;
	}
 
 	//display the widget
	function widget( $args, $instance ) {
		extract( $args );
 
		echo $before_widget;
		
		//load the widget options
		$title = apply_filters( 'widget_title', $instance['title'] );
		$siteid = empty( $instance['siteid'] ) ? 1 : $instance['siteid'];
 		$disp_number = empty( $instance['disp_number'] ) ? 5 : $instance['disp_number'];
 
 		//display the widget title
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			
		echo '<ul>';
		
		//switch to site saved
		switch_to_blog( absint( $siteid ) );

		//create a custom loop
		$recentPosts = new WP_Query();
		$recentPosts->query( 'posts_per_page=' .absint( $disp_number ) );
		
		//start the custom Loop
		while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
		
			//display the recent post title with link
			echo '<li><a href="' .get_permalink(). '">' .get_the_title() .'</a></li>';
			
		endwhile;
		
		//restore the current site
		restore_current_blog();

		echo '</ul>';
		echo $after_widget;

	}

}
?>