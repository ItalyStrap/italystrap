<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\Core;

/**
 * Add a bootstrap button class to cancel reply
 *
 * @param string $formatted_link Cancel reply a tag
 *
 * @return string
 */
function add_class_button_to_cancel_reply( $formatted_link ) {

	$replace = sprintf(
		'<a%s ',
		\ItalyStrap\HTML\get_attr(
			'cancel_comment_reply_class',
			[
				'class'	=> 'btn btn-danger btn-xs',
			]
		)
	);

	return str_replace( '<a ', $replace, $formatted_link);
}
add_filter( 'cancel_comment_reply_link', __NAMESPACE__ . '\add_class_button_to_cancel_reply', 10 );

/**
 * Add a rel="nofollow" and Bootstrap button class to the comment reply links
 *
 * @link http://www.robertoiacono.it/aggiungere-nofollow-link-rispondi-commenti-wordpress/ (only for nofollow)
 *
 * @since 1.9.1
 *
 * @param string $link Comment reply url button
 *
 * @return string
 */
//function add_nofollow_and_bootstrap_button_css_to_reply_link( $link ) {
//
//	$search = [
//		'")\'>',
//	];
//
//	$replace = [
//		'")\' rel=\'nofollow\'>',
//	];
//
//	$link = str_replace( $search, $replace, $link );
//
//	return $link;
//}
//add_filter( 'comment_reply_link', __NAMESPACE__ . '\add_nofollow_and_bootstrap_button_css_to_reply_link' );

/**
 * Display a message if comments are closed
 *
 * @TODO Maybe create an option on customizer for showing this alert
 *
 * @return string Return message
 */
function display_message_if_comments_are_closed() {

	echo '<div class="alert alert-warning">' . __( 'Comments are closed.', 'italystrap' ) . '</div>';
	return '';
}
add_action( 'comment_form_comments_closed', __NAMESPACE__ . '\display_message_if_comments_are_closed' );


/**
 * Argument for standard comment_form()
 *
 * @param  string $comment_author Author of comment
 * @param  string $user_identity  Identity of user logged in
 *
 * @return array                  An array with arguments for comment_form()
 */
function comment_form_args( $comment_author, $user_identity ) {

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	/**
	 * The comment field with bootstrap style
	 * @var array
	 */
	$comment_field = array(
		'author'	=>
			'<div class="form-group comment-form-author"><label for="author" class="sr-only">'
			. __( 'Name', 'italystrap' ) . ' ' . ( $req ? __( '(required)', 'italystrap')
				. '<span class="required">*</span>' : '' )
			. '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="author" id="author" value="' . esc_attr( $comment_author ) . '" placeholder="' . __('Name', 'italystrap') . ' ' . ( $req ? __('(required) *', 'italystrap') : '' ) . '" tabindex="1"' . ( $req ? 'aria-required="true"' : '') . ' title="' . __( 'Name', 'italystrap' ) . ' ' . ( $req ? __('(required) *', 'italystrap') : '' ) . '"/></div></div>',

		'email'		=>
			'<div class="form-group comment-form-email"><label for="email" class="sr-only">' . __( 'Email (will not be published)', 'italystrap' ) . ' ' . ( $req ? __( '(required)', 'italystrap') . '<span class="required">*</span>' : '' ) . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (will not be published)', 'italystrap' ) . ' ' . ( $req ? __('(required) *', 'italystrap') : '' ) . '" tabindex="2" aria-describedby="email-notes" ' . $aria_req . $html_req  . ' title="' . __( 'Email (will not be published)', 'italystrap' ) . ' ' . ( $req ? __('(required) *', 'italystrap') : '' ) . '" /></div></div>',

		'url'		=>
			'<div class="form-group comment-form-url"><label for="url" class="sr-only">' . __( 'Website', 'italystrap') . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input type="url" class="form-control" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website (optional)', 'italystrap') . '" tabindex="3" title="' . __( 'Website (optional)', 'italystrap') . '" /></div></div>',

	);

	$comment_field = apply_filters( 'italystrap_comment_form_default_fields', $comment_field, $comment_author, $commenter, $req, $aria_req, $html_req );

	$comment_array = array(
		'fields'			=>	$comment_field,
		'class_submit'		=>	'btn btn-large btn-primary',
		'format'			=>	'html5',
		'comment_field' 	=>
			'<div class="form-group comment-form-comment"><label for="comment" class="sr-only">' . _x( 'Comment', 'noun', 'italystrap' ) . '</label><textarea class="form-control" name="comment" id="comment" placeholder="' . __( 'Write your comment here', 'italystrap') . '" tabindex="4" rows="6" aria-required="true" title="' . __( 'Write your comment here', 'italystrap' ) . '"></textarea></div>',
		'logged_in_as'		=>
			'<p class="logged-in-as">' . sprintf(
				__( 'Logged in as <a href="%1$s" class="badge badge-primary">%2$s</a> <a href="%3$s" title="Log out of this account" class="badge badge-warning">Log out?</a>', 'italystrap' ),
				get_edit_user_link(),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
			) . '</p>',
		'must_log_in'		=>
			'<p class="alert alert-danger must-log-in">' . sprintf( __( 'You must be <a href="%s" class="alert-link">logged in</a> to post a comment.', 'italystrap' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		// 'cancel_reply_link'	=> '<span class="btn btn-danger btn-xs">' . __( 'Cancel reply' ) . '</span>',

	);

	return $comment_array = apply_filters( 'italystrap_comment_form_defaults', $comment_array, $user_identity, $comment_field );
}

/**
 * Pagination for comment
 *
 * @todo wp-includes\link-template.php 2894
 *       the_comments_pagination( $args = array() );
 *
 * @since ItalyStrap 3.1
 *
 * @return string Return pagination
 */
function comment_pagination() {

	if ( get_comment_pages_count() > 1 && get_option('page_comments') ) { ?>
		<nav class="text-center" itemscope itemtype="https://schema.org/SiteNavigationElement">
			<ul class="pagination pagination-sm">

				<?php
				/**
				 * http://wordpress.stackexchange.com/questions/125389/return-paginate-comments-links-as-array
				 * Then I modify below code, now print bootstrap style correctly
				 */
				$pages = paginate_comments_links(
					array(
						'echo'		=> false,
						'type'		=> 'array',
						'prev_text'	=> __( '&laquo; Previous comments', 'italystrap' ),
						'next_text'	=> __( 'Next comments &raquo;', 'italystrap' ),
					)
				);
				if ( is_array( $pages ) ) {
					$pages = str_replace('<a', '<a itemprop="url"', $pages);
					foreach ($pages as $page) {
						$position = strpos($page, '<span');
						if ( $position === false ) {
							echo '<li itemprop="name">' . $page . '</li>';
						} else {
							echo '<li class="active" itemprop="name">' . $page . '</li>';
						}
					}
				}
				?>

			</ul>
		</nav>

	<?php }
}

/**
 * Is comment reply
 *
 * @return bool Return true if the comment is open.
 */
function is_comment_reply() {
	return (bool) \is_singular() && \comments_open() && \get_option( 'thread_comments' );
}
