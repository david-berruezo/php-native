<?php
/*
Plugin Name: Custom Meta Box
Plugin URI: http://webdevstudios.com/support/wordpress-plugins/
Description: Example showing how to create a custom meta box
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

add_action('admin_init','gmp_meta_box_init');

// meta box functions for adding the meta box and saving the data
function gmp_meta_box_init() {
    // create our custom meta box
    add_meta_box('gmp-meta',__('Product Information','gmp-plugin'), 'gmp_meta_box','post','side','default'); 
    
    // hook to save our meta box data when the post is saved
    add_action('save_post','gmp_save_meta_box'); 
}

function gmp_meta_box($post,$box) {
    // retrieve our custom meta box values
    $featured = get_post_meta($post->ID,'_gmp_type',true);
    $gmp_price = get_post_meta($post->ID,'_gmp_price',true);

    // custom meta box form elements
    echo '<p>' .__('Price','gmp-plugin'). ': <input type="text" name="gmp_price" value="'.esc_attr($gmp_price).'" size="5"></p> 
        <p>' .__('Type','gmp-plugin'). ': <select name="gmp_product_type" id="gmp_product_type"> 
            <option value="0" '.(is_null($featured) || $featured == '0' ? 'selected="selected" ' : '').'>Normal</option> 
            <option value="1" '.($featured == '1' ? 'selected="selected" ' : '').'>Special</option> 
            <option value="2" '.($featured == '2' ? 'selected="selected" ' : '').'>Featured</option> 
            <option value="3" '.($featured == '3' ? 'selected="selected" ' : '').'>Clearance</option> 
        </select></p>';
}

function gmp_save_meta_box($post_id,$post) {
    // if post is a revision skip saving our meta box data
    if($post->post_type == 'revision') { return; }
    
    // process form data if $_POST is set
    if(isset($_POST['gmp_product_type'])) {
        // save the meta box data as post meta using the post ID as a unique prefix
        update_post_meta($post_id,'_gmp_type',esc_attr($_POST['gmp_product_type'])); 
        update_post_meta($post_id,'_gmp_price', esc_attr($_POST['gmp_price']));
    }
}
?>
