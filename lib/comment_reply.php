<?php
/**
 * Comment reply functions
 *
 * Functions for apply Bootstrap css to comment reply buttons
 *
 * @package ItalyStrap
 * @subpackage comments
 */

/**
 * Retrieve HTML content for new cancel comment reply link with Twitter Botstrap style.
 *
 * @link /wp-includes/comment-template.php
 * @since 1.9.1
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 * @param string $class Optional. Bootstrap button class. Default empty.
 */
function new_get_cancel_comment_reply_link( $text = '', $class = '' ) {

	if ( empty( $text ) )
		$text = __('Click here to cancel reply.', 'ItalyStrap');

	if ( empty( $class ) )
		$class = 'btn btn-danger btn-xs';

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';

	$formatted_link = '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . ' class="' . $class . '">' . $text . '</a>';

	/**
	 * Filter the new cancel comment reply link HTML.
	 *
	 * @since 1.9.1
	 *
	 * @param string $formatted_link The HTML-formatted cancel comment reply link.
	 * @param string $link           New Cancel comment reply link URL.
	 * @param string $class          New Cancel comment reply css class.
	 * @param string $text           New Cancel comment reply link text.
	 */
	return apply_filters( 'new_cancel_comment_reply_link', $formatted_link, $link, $class, $text);
}
/**
 * Display HTML content for new cancel comment reply link.
 *
 * @link /wp-includes/comment-template.php
 * @since 1.9.1
 *
 * @param string $text Optional. Text to display for cancel reply link. Default empty.
 * @param string $class Optional. Bootstrap button class. Default empty.
 */
function new_cancel_comment_reply_link($text = '', $class = '' ) {

	echo new_get_cancel_comment_reply_link($text, $class);

}


/**
 * Add a rel="nofollow" and Bootstrap button class to the comment reply links
 *
 * @link http://www.robertoiacono.it/aggiungere-nofollow-link-rispondi-commenti-wordpress/ (only for nofollow)
 * 
 * @since 1.9.1
 * 
 * @param string $link Comment reply url button
 */
function add_nofollow_and_bootstrap_button_css_to_reply_link( $link ) {

	$search = array( '")\'>', 'comment-reply-link');
	$replace = array( '")\' rel=\'nofollow\'>', 'btn btn-success btn-sm pull-right');
	$link = str_replace($search, $replace, $link);

	return $link;
}
add_filter( 'comment_reply_link', 'add_nofollow_and_bootstrap_button_css_to_reply_link' );