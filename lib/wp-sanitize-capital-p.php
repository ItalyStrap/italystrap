<?php
/**
 * The problem:
 * @link https://developer.wordpress.org/reference/functions/capital_p_dangit/
 *       Forever eliminate "Wordpress" from the planet
 *       (or at least the little bit we can influence).
 * @link http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit
 */
remove_filter( 'the_title', 'capital_P_dangit', 11 );
remove_filter( 'the_content', 'capital_P_dangit', 11 );
remove_filter( 'comment_text', 'capital_P_dangit', 31 );

/**
 * Forever eliminate "Wordpress" from the planet
 * (or at least the little bit we can influence).
 *
 * @see capital_P_dangit( $text );
 * @link http://codex.wordpress.org/Function_Reference/capital_P_dangit
 * @param string $text sanitize WordPress word.
 * @return string Return string sanitized
 */
function italyStrap_capital_P_dangit( $text ) {

	return str_replace(
		array( ' Wordpress', '&#8216;Wordpress', 'Wordpress', '>Wordpress', '(Wordpress', ' wordpress', '&#8216;wordpress', 'wordpress', '>wordpress', '(wordpress' ),
		array( ' WordPress', '&#8216;WordPress', 'WordPress', '>WordPress', '(WordPress', ' WordPress', '&#8216;WordPress', 'WordPress', '>WordPress', '(WordPress' ),
		$text
	);
}

/**
 * Remove p lowercase in content and title
 *
 * @link https://wordpress.org/support/topic/modifying-title-before-saving-custom-post?replies=2 The idea from
 * @see wp_insert_post_data filter
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_insert_post_data
 *
 * @param array $data    Post data array.
 * @param array $postarr Raw post data.
 * @return P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_content( $data, $postarr ) {

	$data['post_title'] = italyStrap_capital_P_dangit( $data['post_title'] );
	/**
	 * Disattivato momentaneamente perché mi sostituiva anche la scritta wordpress in caso fosse in una url
	 */
	// $data['post_content'] = italyStrap_capital_P_dangit( $data['post_content'] );

	return $data;
}

add_filter( 'wp_insert_post_data' , 'ItalyStrap_P_dangit_sanitize_content' , '99', 2 );

/**
 * Remove p lowercase in comments contents when publish
 *
 * @see preprocess_comment filter
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/preprocess_comment
 *
 * @param array $commentdata Comment data array.
 * @return array P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_comments( $commentdata ) {

	$commentdata['comment_content'] = italyStrap_capital_P_dangit( $commentdata['comment_content'] );

	return $commentdata;
}
add_filter( 'preprocess_comment' , 'ItalyStrap_P_dangit_sanitize_comments' );


/**
 * Remove p lowercase in comments contents when updating/editing
 *
 * @see comment_save_pre filter
 * @link https://developer.wordpress.org/reference/hooks/comment_save_pre/
 *
 * @param string $comment_content Comment content.
 * @return string P lowercase sanitized
 */
function ItalyStrap_P_dangit_sanitize_comments_update( $comment_content ) {

	$comment_content = italyStrap_capital_P_dangit( $comment_content );

	return $comment_content;
}
add_filter( 'comment_save_pre', 'ItalyStrap_P_dangit_sanitize_comments_update', 10 , 3 );