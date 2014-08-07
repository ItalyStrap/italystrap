<?php
/*Defined at: wp-includes/comment-template.php, line 1153*/
function new_get_cancel_comment_reply_link($text = '') {
	if ( empty($text) )
		$text = __('Click here to cancel reply.', 'italystrap');

	$style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
	$link = esc_html( remove_query_arg('replytocom') ) . '#respond';
	return apply_filters('new_cancel_comment_reply_link', '<a rel="nofollow" id="cancel-comment-reply-link" href="' . $link . '"' . $style . ' class="btn btn-danger btn-sm">' . $text . '</a>', $link, $text);
}
function new_cancel_comment_reply_link($text = '') {
	echo new_get_cancel_comment_reply_link($text);
}
/*Fine modifica wp-includes/comment-template.php*/


/**
 * Add a rel="nofollow" and Bootstrap button class to the comment reply links
 *
 * @link http://www.robertoiacono.it/aggiungere-nofollow-link-rispondi-commenti-wordpress/ (only for nofollow)
 * @since 1.9.1
 */
function add_nofollow_and_bootstrap_button_css_to_reply_link( $link ) {

	$search = array( '")\'>', 'comment-reply-link');
	$replace = array( '")\' rel=\'nofollow\'>', 'btn btn-success pull-right');
	$link = str_replace($search, $replace, $link);

	return $link;
}
add_filter( 'comment_reply_link', 'add_nofollow_and_bootstrap_button_css_to_reply_link' );
?>