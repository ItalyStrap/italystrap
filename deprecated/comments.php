<?php  
/**
 * ItalyStrap_custom_comment()
 * @return
 */
function ItalyStrap_custom_comment($comment, $args, $depth){
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>

                <li class="comment media" id="comment-<?php comment_ID(); ?>">
                    <div class="media-body">
                        <p>
                            Pingback: <?php comment_author_link(); ?>
                        </p>
                    </div><!--/.media-body -->
                <?php
                break;
            default :
                // Proceed with normal comments.
                global $post; ?>
				
				
                <div class="<?php if($depth == 1) echo 'col-md-12'; else echo 'col-md-11 col-md-offset-1'; ?>">
					<div class="row <?php if ($comment->user_id === $post->post_author) { echo 'bg-color-author';} ?>"itemscope itemtype="https://schema.org/Comment">
                        <div class="col-md-2"><?php echo get_avatar($comment, '92') ?></div>
                        <div class="col-md-10">
							<ul class="list-inline">
								<li>
								<h4 class="media-heading">
									<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="https://schema.org/Person"><?php echo get_comment_author() ?><meta itemprop="image" content="<?php  $thumbnailUrl = get_avatar($comment); echo estraiUrlsGravatar($thumbnailUrl);?>"/></span></a>
									<?php
									printf(
									// If current post author is also comment author, make it known visually.
										($comment->user_id === $post->post_author) ? '<span class="label label-danger"> ' . __('The Boss :-)', 'ItalyStrap') . '</span> ' : ''); ?>
								</h4>
								
								</li>
								<li><time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time></li>
								<?php edit_comment_link(__('Edit','ItalyStrap'),'<span class="btn btn-sm btn-warning pull-right"><i class="glyphicon glyphicon-pencil"></i> ','</span>') ?>
							</ul>

								<p itemprop="text"><?php echo get_comment_text($comment); ?></p>
								<?php if ($comment->comment_approved == '0') : ?>
									 <span  class="alert alert-success">Il tuo commento &egrave; in attesa di moderazione.</span>
								<?php endif; ?>

								<p class="reply btn btn-small btn-success pull-right">
									<?php 
									comment_reply_link( 
											array_merge(
												$args, 
												array(
													'reply_text' => __('Reply <i class="glyphicon glyphicon-arrow-down"></i>', 'ItalyStrap'),
													'depth'      => $depth,
													'max_depth'  => $args['max_depth'],
													'class'      => 'btn',
													)
												),
												$comment->comment_ID
											);
									?>
								</p>
						</div>
					</div>

                </div>
                <?php
                break;
        endswitch;
    }

/**
* Use Bootstrap's media object for listing comments
*
* @link http://getbootstrap.com/components/#media
*/
class ItalyStrap_Walker_Comment extends Walker_Comment {
	function start_lvl(&$output, $depth = 0, $args = array()) {

		$GLOBALS['comment_depth'] = $depth + 1;
		?>

		<span class="clearfix"></span>
		<ul <?php comment_class('media list-unstyled comment-' . get_comment_ID()); ?>>

		<?php
		}

		function end_lvl(&$output, $depth = 0, $args = array()) {
			$GLOBALS['comment_depth'] = $depth + 1;
		?>
		</ul>
		<?php
		}

		function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;

			if (!empty($args['callback'])) {
				call_user_func($args['callback'], $comment, $args, $depth);
				return;
			}

			extract($args, EXTR_SKIP);
			global $post;
			?>

		<span class="clearfix"></span>
		<ul <?php comment_class('media list-unstyled comment-' . get_comment_ID()); ?>>

			<?php 
			/**
			 * http://codex.wordpress.org/Function_Reference/comment_class
			 */
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class('media comment-' . get_comment_ID()); ?> itemscope itemtype="https://schema.org/Comment">

				<span class="pull-left">
					<?php echo italystrap_get_avatar( $comment, NULL, NULL, get_comment_author(), 'img-circle img-responsive' );?>
				</span>
				<div class="media-body">
					<ul class="list-inline">
						<li>
							<h4 class="media-heading">

							<?php if ( get_comment_author_url() ) { ?>

								<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span></a>

							<?php } else { ?>

								<span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span>

							<?php	}

								printf(
								// If current post author is also comment author, make it known visually.
									($comment->user_id === $post->post_author) ? ' <span class="label label-danger"> ' . __(
										'The Boss :-)',
										'ItalyStrap'
									) . '</span> ' : ''); ?>
							</h4>
						</li>
						<li>
							<time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time>
						</li>
						
						<?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ): ?>
							<a href="<?php echo get_edit_comment_link(); ?>" class="btn btn-sm btn-warning pull-right"><?php echo __('Edit','ItalyStrap') ; ?> <i class="glyphicon glyphicon-pencil"></i></a>
						<?php endif ?>

					</ul>

					<?php if ($comment->comment_approved == '0') : ?>
					<div class="alert alert-info">
						<?php _e('Your comment is awaiting moderation.', 'ItalyStrap'); ?>
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
				if ( $comment->comment_type === '' ) {

					$comment_author = $comment->comment_author;
					comment_reply_link( 
							array_merge(
								$args, 
								array(
									'reply_text' => __('Reply to ', 'ItalyStrap') . $comment_author . ' <i class="glyphicon glyphicon-arrow-down"></i>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth']
									)
								)
							);
					}
			}

			function end_el(&$output, $comment, $depth = 0, $args = array()) {
				if (!empty($args['end-callback'])) {
					call_user_func($args['end-callback'], $comment, $args, $depth);
					return;
				}
// Close ".media-body" <div> located in templates/comment.php, and then the comment's <li>
				echo "</div></li></ul>\n";
			}
		}