<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package ItalyStrap
 * @since ItalyStrap 1.8.1
 */

namespace ItalyStrap;

use ItalyStrap\Core\Comments\Comments;

/**
 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
 */
if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$template_settings = (array) apply_filters( 'italystrap_template_settings', array() );
/**
 * If there are comments
 */
if ( have_comments() && ! in_array( 'hide_comments', $template_settings, true ) ) : ?>
	<section id="comments" class="comments-area">
		<h3 class="comments-title"><?php printf( _n( 'One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'ItalyStrap' ), number_format_i18n( get_comments_number() ), get_the_title() ); // XSS ok. ?></h3>

		<?php
		/**
		 * This is an experimental filter
		 * The name of a custom Walker Comment
		 *
		 * @var string
		 */
		$comment_walker = apply_filters( 'comment_walker', 'ItalyStrap\Core\Comments\Comments' );

		/**
		 * Arguments for wp_list_comments()
		 *
		 * @var array
		 */
		$wp_list_comments_args = apply_filters(
			'wp_list_comments_args',
			array(
				'walker'		=> new $comment_walker,
				'max_depth'		=> 3, // See in WordPress option.
				'avatar_size'	=> 100,
			)
		);

		\ItalyStrap\Core\comment_pagination();
			echo '<ol class="parent list-unstyled">';
			wp_list_comments( $wp_list_comments_args );
			echo '</ol>';
		\ItalyStrap\Core\comment_pagination();
		?>
	</section><!-- /#comments -->
<?php elseif ( comments_open() && ! in_array( 'hide_comments', $template_settings, true ) ) : ?>
	<section id="comments" class="comments-area">
		<h3 id="comments-title"><?php esc_html_e( 'There are no comments yet, why not be the first', 'ItalyStrap' ); ?></h3>
	</section>
<?php endif;  // End have_comments(). ?>

<?php if ( ! in_array( 'hide_comments_form', $template_settings, true )  ) : ?>
<section class="form-actions">
	<?php
	/**
	 * Standard comment form with custom arguments
	 *
	 * @see /core/class-italystrap-comments.php
	 * @link https://codex.wordpress.org/Function_Reference/comment_form
	 * @since ItalyStrap 3.1
	 *
	 *  - Uses filter hooks
	 * comment_form_default_fields
	 * the_permalink
	 * comment_form_defaults
	 * comment_form_logged_in
	 * comment_form_field_{$name}
	 * comment_form_field_comment
	 *
	 *  - Pluggable actions
	 * comment_form_before
	 * comment_form_must_log_in_after
	 * comment_form_top
	 * comment_form_logged_in_after
	 * comment_form_before_fields
	 * comment_form_after_fields
	 * comment_form
	 * comment_form_after
	 * comment_form_comments_closed
	 */
	comment_form( \ItalyStrap\Core\comment_form_args( $comment_author, $user_identity ) );
	?>
</section>
<?php endif;
