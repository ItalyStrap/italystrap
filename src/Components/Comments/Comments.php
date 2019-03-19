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
	 * Start the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 2.7.0
	 *
	 * @global int $comment_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of comment.
	 * @param array  $args   Uses 'style' argument for type of HTML list.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="list-unstyled children">' . "\n";
				break;
		}
	}

	/**
	 * Start the element output.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 *
	 * @global int    $comment_depth
	 * @global object $comment
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment Comment data object.
	 * @param int    $depth   Depth of comment in reference to parents.
	 * @param array  $args    An array of arguments.
	 * @param int    $id      
	 */
	public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {

		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;

		if ( ! empty( $args['callback'] ) ) {
			\ob_start();
			\call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= \ob_get_clean();
			return;

		}

		/**
		 * There are a few ways to list 'pingback'.
		 * 		Above the comments
		 * 		Below the comments
		 * 		Included within the normal flow of comments
		 */

		if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
			\ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= \ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			\ob_start();
			$this->html5_comment( $comment, $depth, $args );
			// $this->boostrap_style( $comment, $depth, $args );
			$output .= \ob_get_clean();
		} else {
			\ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= \ob_get_clean();
		}

	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string $output  Passed by reference. Used to append additional content.
	 * @param object $comment The comment object. Default current comment.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {

		if ( ! empty( $args['end-callback'] ) ) {
			\ob_start();
			\call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= \ob_get_clean();
			return;

		}
		if ( 'div' === $args['style'] )
			$output .= "</div><!-- #comment-## -->\n";

		else $output .= "</li><!-- #comment-## -->\n";

		// Close ".media-body" <div> located in templates/comment.php, and then the comment's <li>
		// echo "</div></li></ul>\n";

	}

	protected function boostrap_style( $comment, $depth, $args ) {

		global $post;
		?>

		<span class="clearfix"></span>
		<ul <?php \comment_class( 'media list-unstyled comment-' . get_comment_ID() ); ?>>

		<?php
		/**
		 * @link http://codex.wordpress.org/Function_Reference/comment_class
		 */
		?>
		<li id="comment-<?php \comment_ID(); ?>" <?php \comment_class( 'media comment-' . get_comment_ID() ); ?> itemscope itemtype="https://schema.org/Comment">

			<span class="pull-left">
				<?php echo italystrap_get_avatar( $comment, null, null, get_comment_author(), 'img-circle img-responsive' );?>
			</span>
			<div class="media-body"><h2>Bello</h2>
				<ul class="list-inline">
					<li>
						<h4 class="media-heading">

						<?php if ( get_comment_author_url() ) { ?>

							<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span></a>

						<?php } else { ?>

							<span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span>

						<?php }
							/**
							 * If current post author is also comment author,
							 * make it known visually.
							 */
							$post_author = 
								apply_filters( 'italystrap_post_author',
									' <span class="label label-primary"> ' . __(
									'Post Author',
									'italystrap'
								) . '</span> ' );

							printf( ( $comment->user_id === $post->post_author ) ? $post_author : ''); ?>
						</h4>
					</li>
					<li>
						<time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time>
					</li>
					
					<?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ): ?>
						<a href="<?php echo get_edit_comment_link(); ?>" class="btn btn-sm btn-warning pull-right"><?php echo __('Edit','italystrap') ; ?> <i class="glyphicon glyphicon-pencil"></i></a>
					<?php endif ?>

				</ul>

				<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<?php _e('Your comment is awaiting moderation.', 'italystrap'); ?>
				</div>
				<?php endif; ?>

				<div itemprop="text">
					<?php comment_text( $comment->comment_ID ); ?>
				</div>

		<?php
		/**
		 * If comment type is not pingback and trackback add comment reply button
		 *
		 * @link http://codex.wordpress.org/Function_Reference/comment_reply_link
		 * @see comment_reply.php for customizations
		 * @todo Se è impostata la possibilità di commentare solo da loggati viene
		 *       stampato solo un link, eventualmente provare ad inserire uno
		 *       stile bottone che è più bellino :-)
		 */
		if ( $comment->comment_type === '' )
			comment_reply_link( 
				array_merge(
					$args, 
					array(
						'reply_text' => __('Reply to ', 'italystrap') . $comment->comment_author . ' <i class="glyphicon glyphicon-arrow-down"></i>',
						'depth'      => $depth,
						// 'max_depth'  => $args['max_depth']
						'max_depth'  => -1,
					)
				)
			);
	}

	/**
	 * Output a comment in the HTML5 format.
	 *
	 * @access protected
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php \comment_ID(); ?>" <?php \comment_class( $this->has_children ? 'parent' : '' ); ?>>
			<article id="div-comment-<?php \comment_ID(); ?>" class="comment-body row" itemscope itemtype="https://schema.org/Comment">
				<section class="col-sm-2">
					<?php
					/**
					 * Di default dovrebbe essere a 32 quindi la if non serve, controllare
					 */
					$args['avatar_size'] = ( isset( $args['avatar_size'] ) ) ? $args['avatar_size'] : null ;
					echo \italystrap_get_avatar( $comment, $args['avatar_size'], NULL, \get_comment_author(), 'img-circle img-responsive center-block' );?>
				</section>
				<section class="col-sm-10">
					<footer class="comment-meta">
					
							<?php if ( \is_user_logged_in() && \current_user_can( 'manage_options' ) && 'pingback'!== $comment->comment_type ): ?>
								<a href="<?php echo \get_edit_comment_link(); ?>" class="btn btn-sm btn-warning pull-right"><?php echo __('Edit', 'italystrap') ; ?> <i class="glyphicon glyphicon-pencil"></i></a>
							<?php endif ?>
							<?php
							$email =  \get_comment_author_email();
					
							if ( $email )
								echo '<meta  itemprop="image" content="' . \italystrap_get_avatar_url( $email ) . '"/>';
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
					
					<?php
					if ( 'pingback'!== $comment->comment_type ) {
						$comment_reply_link_args = \apply_filters( 'comment_reply_link_args', array(
							'reply_text' => sprintf(
								__('Reply to %s %s', 'italystrap'),
								$comment->comment_author,
								'<i class="glyphicon glyphicon-arrow-down"></i>'
							),
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => 1000,
							'before'    => '<div class="reply">',
							'after'     => '</div>'
						) );
						\comment_reply_link( \array_merge( $args, $comment_reply_link_args ) );
					} ?>
				</section>
			</article><!-- .comment-body -->
<?php
	}
}
