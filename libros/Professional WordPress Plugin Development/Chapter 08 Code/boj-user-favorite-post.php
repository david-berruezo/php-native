<?php
/*
Plugin Name: User Favorite Post
Plugin URI: http://example.com
Description: Allows users to select their favorite post from the site.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Add the post form to the user/profile edit page in the admin. */
add_action( 'show_user_profile', 'boj_user_favorite_post_form' );
add_action( 'edit_user_profile', 'boj_user_favorite_post_form' );

/* Function for displaying an extra form on the user edit page. */
function boj_user_favorite_post_form( $user ) {

    /* Get the current user's favorite post. */
    $favorite_post = get_user_meta( $user->ID, 'favorite_post', true );

    /* Get a list of all the posts. */
    $posts = get_posts( array( 'numberposts' => -1 ) );
    ?>

    <h3>Favorites</h3>

    <table class="form-table">

        <tr>
            <th><label for="favorite_post">Favorite Post</label></th>

            <td>
                <select name="favorite_post" id="favorite_post">
                    <option value=""></option>

                <?php foreach ( $posts as $post ) { ?>
                    <option value="<?php echo esc_attr( $post->ID ); ?>" 
                    <?php selected( $favorite_post, $post->ID ); ?>>
                        <?php echo esc_html( $post->post_title ); ?>
                    </option>
                <?php } ?>

                </select>
                <br />
                <span class="description">Select your favorite post.</span>
            </td>
        </tr>

    </table>
<?php }

/* Add the update function to the user update hooks. */
add_action( 'personal_options_update', 'boj_user_favorite_post_update' );
add_action( 'edit_user_profile_update', 'boj_user_favorite_post_update' );

/* Function for updating the user's favorite post. */
function boj_user_favorite_post_update( $user_id ) {

    /* Check if the current user has permission to edit the user. */
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Only accept numbers 0-9 since it's a post ID. */
    $favorite_post = preg_replace( "/[^0-9]/", '', $_POST['favorite_post'] );

    /* Update the user's favorite post. */
    update_user_meta( $user_id, 'favorite_post', $favorite_post );
}

?>