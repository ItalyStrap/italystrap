<?php
/**
 * Protected post/page function print bootstrap layout
 * @link http://codex.wordpress.org/Using_Password_Protection
 *
 * @package WordPress
 * @since ItalyStrap 1.8.4
 *
 */

function italystrap_password_protection_post_page() {
    global $post;
    $label = 'pwbox-'. ( empty( $post->ID ) ? rand() : $post->ID );
    $form = '<div class="alert alert-danger" role="alert">
                <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" role="form"><p>
                ' . __( 'To view this protected post, enter the password below:', 'ItalyStrap' ) . '</p>
                    <div class="form-group  has-error">
                        <label for="' . $label . '" class="sr-only">' . __( 'Password: ', 'ItalyStrap' ) . ' </label>
                        <p><input name="post_password" id="' . $label . '" type="password"  class="form-control" placeholder="' . __( 'Enter password', 'ItalyStrap' ) . '"></p>
                        <input type="submit"  class="btn btn-danger btn-block" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
                    </div>
                </form>
            </div>';
    return $form;
}
add_filter( 'the_password_form', 'italystrap_password_protection_post_page' );

function italystrap_excerpt_password_form( $excerpt ) {
    if ( post_password_required() )
        $excerpt = get_the_password_form();
    return $excerpt;
}
add_filter( 'the_excerpt', 'italystrap_excerpt_password_form' );