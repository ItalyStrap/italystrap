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

use Auryn\InjectionException;

//d(get_defined_vars());

/**
 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
 */
// if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
// 	return;
// }

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( \post_password_required() ) {
	return;
}

$template_settings = (array) \ItalyStrap\Factory\get_config()->get('post_content_template');

/**
 * If there are comments
 */
if ( \have_comments() ) : ?>
	<section id="comments" class="comments-area">
		<h3 class="comments-title">
            <?php
			/**
			 * The comment number
			 */
            $comment_number = \get_comments_number();
            \printf(
			    /* translators: 1: number of comments, 2: post title */
                \_n( '%1$s response to &ldquo;%2$s&rdquo;', '%1$s responses to &ldquo;%2$s&rdquo;', $comment_number, 'italystrap' ),
                \number_format_i18n( $comment_number ),
                \get_the_title()
            );
            ?>
        </h3>

		<?php
		/**
		 * This is an experimental filter
		 * The name of a custom Walker Comment
		 *
		 * @var string
		 */
		$comment_walker = \apply_filters( 'comment_walker', 'ItalyStrap\Components\Comments\Comments' );

		/**
		 * Arguments for wp_list_comments()
		 *
		 * filter 'wp_list_comments_args' since WP 4.0.0
		 *
		 * @var array
		 */
		try {
			$wp_list_comments_args = array(
				'walker'        => \ItalyStrap\Factory\get_injector()->make( $comment_walker ),
				'max_depth'     => 3, // See in WordPress option.
//				'avatar_size'   => 100,
//				'callback'          => function ( \WP_Comment $comment, array $args, int $depth ) {
//				    d( $comment, $args, $depth );
//				    return '';
//                },
			);
		} catch ( InjectionException $e ) {
		    echo $e->getMessage();
		}

		\ItalyStrap\Core\comment_pagination();
			echo '<ol class="parent">';
			\wp_list_comments( $wp_list_comments_args );
			echo '</ol>';
		\ItalyStrap\Core\comment_pagination();
		?>
	</section><!-- /#comments -->
<?php elseif ( \comments_open() && ! \in_array( 'hide_comments', $template_settings, true ) ) : ?>
	<section id="comments" class="comments-area">
		<h3 id="comments-title"><?php \esc_html_e( 'There are no comments yet, why not be the first', 'italystrap' ); ?></h3>
	</section>
<?php endif;  // End have_comments(). ?>

<?php if ( ! \in_array( 'hide_comments_form', $template_settings, true )  ) : ?>
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
	\comment_form( \ItalyStrap\Core\comment_form_args( $comment_author, $user_identity ) );
	?>
</section>
<?php endif;
