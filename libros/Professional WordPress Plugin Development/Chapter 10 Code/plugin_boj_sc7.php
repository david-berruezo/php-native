<?php
/*
Plugin Name: Google Map API Integration
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: Convert a plain text address into a Google Map using the [google_map] shortcode
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/

// Geocode an address: return array of latitude & longitude
function boj_gmap_geocode( $address ) {
    // Make Google Geocoding API URL
    $map_url = 'http://maps.google.com/maps/api/geocode/json?address=';
    $map_url .= urlencode( $address ).'&sensor=false';
    
    // Send GET request
    $request = wp_remote_get( $map_url );

    // Get the JSON object
    $json = wp_remote_retrieve_body( $request );

    // Make sure the request was succesful or return false
    if( empty( $json ) )
        return false;
    
    // Decode the JSON object
    $json = json_decode( $json );

    // Get coordinates
    $lat = $json->results[0]->geometry->location->lat;    //latitude
    $long = $json->results[0]->geometry->location->lng;   //longitude
    
    // Return array of latitude & longitude
    return compact( 'lat', 'long' );
}

// Convert a plain text address into latitude & longitude coordinates
function boj_gmap_get_coords( $address = '111 River Street Hoboken, NJ 07030' ) {
    
    // Current post id
    global $id;
    
    // Check if we already have this coordinates in the database
    $saved = get_post_meta( $id, 'boj_gmap_addresses' );
    foreach( (array)$saved as $_saved ) {
        if( isset( $_saved['address'] ) && $_saved['address'] == $address ) {
            extract( $_saved );
            return compact( 'lat', 'long' );
        }
    }
    
    // Coordinates not cached: let's fetch them from Google
    $coords = boj_gmap_geocode( $address );
    if( !$coords )
        return false;
    
    // Cache result in a post meta data
    add_post_meta( $id, 'boj_gmap_addresses', array(
        'address' => $address,
        'lat' => $coords['lat'],
        'long' => $coords['long']
        )
    );
    
	// Return array with lat and long
    extract( $coords );
    return compact( 'lat', 'long' );
}


//add the [google_map] shortcode support
add_shortcode( 'google_map', 'boj_gmap_generate_map' );
add_shortcode( 'googlemap', 'boj_gmap_generate_map' );

// The shortcode callback
function boj_gmap_generate_map( $attr, $address ) {

    // Set map default
    $defaults = array(
        'width'  => '500',
        'height' => '500',
        'zoom'   => 12,
    );
    
    // Get map attributes (set to defaults if omitted)
    extract( shortcode_atts( $defaults, $attr ) );
    
    // get coordinates
    $coord = boj_gmap_get_coords( $address );
    
    // Make sure we have coordinates, otherwise return empty string
    if( !$coord )
        return '';
        
    // Output for the shortcode
    $output = '';
        
    // populate $lat and $long variables
    extract( $coord );
    
    // Sanitize variables depending on the context they will be printed in
    $lat     = esc_js( $lat );
    $long    = esc_js( $long );
    $address = esc_js( $address );
    $zoom    = esc_js( $zoom );
    $width   = esc_attr( $width );
    $height  = esc_attr( $height );
    
    // generate a unique map ID so we can have different maps on the same page
    $map_id = 'boj_map_'.md5( $address );
    
    // Add the Google Maps javascript only once per page
    static $script_added = false;
    if( $script_added == false ) {
        $output .= '<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?sensor=false"></script>';
        $script_added = true;
    }
    
    // Add the map specific code
    $output .= <<<CODE
    <div id="$map_id"></div>
    
    <script type="text/javascript">
    function generate_$map_id() {
        var latlng = new google.maps.LatLng( $lat, $long );
        var options = {
            zoom: $zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map(
            document.getElementById("$map_id"),
            options
        );

        var legend = '<div class="map_legend"><p> $address </p></div>';

        var infowindow = new google.maps.InfoWindow({
            content: legend,
        });

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

    }

    generate_$map_id();
    
    </script>
    
    <style type"text/css">
    .map_legend{
        width:200px;
        max-height:200px;
        min-height:100px;
    }
    #$map_id {
        width: {$width}px;
        height: {$height}px;
    }
    </style>
    
CODE;

    return $output;
}

?>