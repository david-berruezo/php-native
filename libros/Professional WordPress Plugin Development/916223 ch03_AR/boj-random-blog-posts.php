<?php
add_action( 'pre_get_posts', 'boj_randomly_order_blog_posts' );
function boj_randomly_order_blog_posts( $query ) {
    if ( $query->is_home && empty( $query->query_vars['suppress_filters'] ) )
        $query->set( 'orderby', 'rand' );
}
?>
