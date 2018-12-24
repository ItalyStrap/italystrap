<?php
/**
 * Protected post/page function print bootstrap layout
 * @link http://codex.wordpress.org/Using_Password_Protection
 *
 * @package WordPress
 * @since ItalyStrap 1.8.4
 *
 * @todo Creare un alert per password non corretta.
 */

namespace ItalyStrap\Core;

/**
 * [get_the_password_form description]
 *
 * @param  string $output The password form HTML output.
 *
 * @return string         HTML content for password form for password protected post.
 */
function get_the_password_form( $output = '' ) {

	global $post;

	$form = sprintf(
		'<div class="alert alert-danger" role="alert"><form action="%1$s" method="post" role="form"><p>%2$s</p><div class="form-group  has-error"><label for="%3$s" class="sr-only">%4$s</label><p><input name="post_password" id="%3$s" type="password"  class="form-control" placeholder="%5$s"></p><input type="submit"  class="btn btn-danger btn-block" name="Submit" value="%6$s" /></div></form></div>',
		esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ),
		__( 'To view this protected post, enter the password below:', 'italystrap' ),
		'pwbox-'. ( empty( $post->ID ) ? rand() : $post->ID ),
		__( 'Password: ', 'italystrap' ),
		__( 'Enter password', 'italystrap' ),
		esc_attr__( "Submit", 'italystrap' )
	);

	return $form;
}
add_filter( 'the_password_form', __NAMESPACE__ . '\get_the_password_form' );

/**
 * [excerpt_password_form description]
 *
 * @param  string $excerpt The post excerpt.
 *
 * @return string          The post has password return the password form.
 */
function excerpt_password_form( $excerpt ) {

	if ( post_password_required() ) {
		return get_the_password_form();
	}

	return $excerpt;
}
add_filter( 'the_excerpt', __NAMESPACE__ . '\excerpt_password_form' );