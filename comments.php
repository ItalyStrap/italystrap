<?php namespace ItalyStrap;
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package ItalyStrap
 * @since ItalyStrap 1.8.1
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;

/**
 * If there are comments
 */
if ( have_comments() ) : ?>
	<section id="comments" class="comments-area">
		<h3 class="comments-title"><?php printf( _n( 'One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'ItalyStrap' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h3>
				
		<?php
		/**
		 * This is an experimental filter
		 * The name of a custom Walker Comment
		 * @var string
		 */
		$comment_walker = apply_filters( 'comment_walker', 'ItalyStrap_Walker_Comment' );

		/**
		 * Arguments for wp_list_comments()
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

		italystrap_comment_pagination();
			echo '<ol class="parent list-unstyled">';
			wp_list_comments( $wp_list_comments_args );
			echo '</ol>';
		italystrap_comment_pagination();
		?>
	</section><!-- /#comments -->
<?php elseif ( comments_open() ) : ?>
	<section id="comments" class="comments-area">
		<h3 id="comments-title"><?php esc_html_e( 'There are no comments yet, why not be the first', 'ItalyStrap' ); ?></h3>
	</section>
<?php endif;  // End have_comments(). ?>

<section class="form-actions">
	<?php
	/**
	 * Standard comment form with custom arguments
	 * @see /core/class-italystrap-comments.php
	 * @link https://codex.wordpress.org/Function_Reference/comment_form
	 * @since ItalyStrap 3.1
	 */
	comment_form( comment_form_args( $comment_author, $user_identity ) );
	?>
</section>
