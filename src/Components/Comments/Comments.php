<?php
/**
 * Walker Class for comments
 *
 * Use Bootstrap's media object for listing comments
 *
 * @link http://getbootstrap.com/components/#media
 *
 * In settings use max 3 level of depth
 *
 * @todo Ho ancora un po di lavoro da fare con questa classe
 *       Per esempio pulire il codice HTML ritornato, è ancora troppo sporco
 *       Troppi ul
 *
 * @package ItalyStrap
 * @since 3.1.0
 */

namespace ItalyStrap\Components\Comments;

use \Walker_Comment;

/**
 * ItalyStrap Walker Class
 */
class Comments extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param \WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = 'div' === $args['style'] ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php \comment_ID(); ?>" <?php \comment_class( $this->has_children ? 'parent' : '' ); ?>>
			<article id="div-comment-<?php \comment_ID(); ?>" class="comment-body row" itemscope itemtype="https://schema.org/Comment">
				<div class="col-sm-2">
					<?php
					/**
					 * Di default dovrebbe essere a 32 quindi la if non serve, controllare
					 *
					 * @TODO https://schema.org/Person
					 */
					$args['avatar_size'] = ( isset( $args['avatar_size'] ) ) ? $args['avatar_size'] : null ;
					echo \italystrap_get_avatar( $comment, $args['avatar_size'], null, \get_comment_author(), 'img-circle img-responsive center-block' );?>
				</div>
				<section class="col-sm-10">
					<footer class="comment-meta">
						<?php
						if ( $email =  \get_comment_author_email()) {
							echo '<meta  itemprop="image" content="' . \italystrap_get_avatar_url( $email ) . '"/>';
						}
						?>
					
						<div class="comment-author vcard">
					
							<?php // if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
							<?php \printf( \__( '%s <span class="says">says:</span>', 'italystrap' ), \sprintf( '<b class="fn">%s</b>', \get_comment_author_link() ) ); ?>
						</div><!-- .comment-author -->
					
						<div class="comment-metadata">
							<a href="<?php echo \esc_url( \get_comment_link( $comment->comment_ID, $args ) ); ?>">
								<time datetime="<?php \comment_time( 'c' ); ?>" itemprop="datePublished">
									<?php \printf( \_x( '%1$s at %2$s', '1: date, 2: time', 'italystrap' ), \get_comment_date(), \get_comment_time() ); ?>
								</time>
							</a>
							<?php // edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
					
					
						</div><!-- .comment-metadata -->
					
						<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation alert alert-info"><?php \_e( 'Your comment is awaiting moderation.', 'italystrap' ); ?></p>
						<?php endif; ?>
					</footer><!-- .comment-meta -->
					
					<div class="comment-content" itemprop="text">
						<?php \comment_text(); ?>
					</div><!-- .comment-content -->
					<div>
					<?php if ( \is_user_logged_in() && \current_user_can( 'manage_options' ) && 'pingback'!== $comment->comment_type ) : ?>
						<a href="<?php echo \get_edit_comment_link(); ?>" class=""><?php echo __( 'Edit', 'italystrap' ) ; ?></a> |
					<?php endif ?>

					<?php
					if ( 'pingback'!== $comment->comment_type ) {
						$comment_reply_link_args = \apply_filters(
							'comment_reply_link_args',
							[
							//                                    'reply_text' => sprintf(
							//                                        __( 'Reply to %s', 'italystrap' ),
							//                                        $comment->comment_author
							//                                    ),
									'add_below' => 'div-comment',
									'depth'     => $depth,
									'max_depth' => 1000,
									'before'    => '<span class="reply">',
									'after'     => '</span>'
								]
						);
						\comment_reply_link( \array_merge( $args, $comment_reply_link_args ) );
					} ?>
					</div>
				</section>
			</article><!-- .comment-body -->
		<?php
	}
}
