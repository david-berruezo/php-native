<?php
add_filter( 'single_template', 'boj_single_template' );
function boj_single_template( $template ) {
    global $wp_query;
    /* Check if viewing a singular post. */
    if ( is_singular( 'post' ) ) {
        /* Get the post ID. */
        $post_id = $wp_query->get_queried_object_id();
        /* Get the post categories. */
        $terms = get_the_terms( $post_id, 'category' );
        /* Loop through the categories, adding slugs as part of the file name. */
        $templates = array();
        foreach ( $terms as $term )
            $templates[] = "single-category-{$term->slug}.php";
        /* Check if the template exists. */
        $locate = locate_template( $templates );
        /* If a template was found, make it the new template. */
        if ( !empty( $locate ) )
            $template = $locate;
    }
    /* Return the template file name. */
    return $template;
}
?>