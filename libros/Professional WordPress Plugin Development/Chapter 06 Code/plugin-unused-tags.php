<?php
/*
Plugin Name: Unused Tags
Plugin URI: http://example.com/
Description: Find unused tags and rename or delete them
Author: WROX
Author URI: http://wrox.com
*/

// Add an entry for our option page to the Posts menu
add_action('admin_menu', 'boj_utags_add_page');
function boj_utags_add_page() {
    add_posts_page( 'Unused Tags', 'Unused Tags', 'manage_options',
        'boj_utags', 'boj_utags_option_page' );
}

// Catch any action parameter in query string
add_action( 'admin_init', 'boj_utags_do_action' );

// Proceed to requested boj_action if applicable
function boj_utags_do_action() {
    if( !isset( $_REQUEST['boj_action'] ) )
        return;

    if( !current_user_can( 'manage_options' ) )
        wp_die( 'Insufficient privileges!' );
        
    $id     = $_REQUEST['id'];
    $action = $_REQUEST['boj_action'];
    
    if( $action == 'done' ) {
        add_action( 'admin_notices', 'boj_utags_message' );
        return;
    }
    
    check_admin_referer( 'boj_utags-'.$action.'_tag'.$id );
    
    switch( $action ) {
        case 'rename':
            $newtag = array( 'name' => $_POST['name'], 'slug' => $_POST['name'] );
            wp_update_term( $id, 'post_tag', $newtag );
            break;
        case 'delete':
            wp_delete_term( $id, 'post_tag' );
            break;
    }

    wp_redirect( add_query_arg( array( 'boj_action' => 'done' ) ) );

}

// Admin notice
function boj_utags_message() {
    echo "<div class='updated'><p>Action completed</p></div>";
}

// Draw the tag management page
function boj_utags_option_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Unused Tags</h2>
            
        <?php
        
        if( $tags = boj_utags_find_orphans() ):
        
        echo '<p>You currently have '.count( $tags ). ' unused tags:</p>';
        echo '<ol>';
        
        foreach( $tags as $tag ) {
            $id   = $tag->term_id;
            $name = esc_attr( $tag->name );

            $delete_url= add_query_arg( array('boj_action'=>'delete','id'=>$id) );
            $nonced_url= wp_nonce_url( $delete_url, 'boj_utags-delete_tag'.$id );
            ?>
            <li>
            <form action="" method="post">
            <?php wp_nonce_field( 'boj_utags-rename_tag'.$id ); ?>
            <input type="hidden" name="boj_action" value="rename" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="text" name="name" value="<?php echo $name; ?>" />
            <input type="submit" value="Rename" /> or
            <a href="<?php echo $nonced_url; ?>">delete</a> this tag
            </form>
            </li>
            
        <?php }
        
        else: ?>
        <p>You have no unused tags.</p>
        
        <?php endif; ?>
        
        </ol>
    </div>
    <?php
}

// Find unused tags, return them in an array
function boj_utags_find_orphans() {
    global $wpdb;
    
    $sql = "SELECT terms.term_id, terms.name FROM {$wpdb->terms} terms
            INNER JOIN {$wpdb->term_taxonomy} taxo
            ON terms.term_id=taxo.term_id
            WHERE taxo.taxonomy = 'post_tag'
            AND taxo.count=0";
            
    return $wpdb->get_results( $sql );
}
