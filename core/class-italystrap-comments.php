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

/**
 * ItalyStrap Walker Class
 */
class ItalyStrap_Walker_Comment extends Walker_Comment {

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
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;

		}

		if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			// $this->boostrap_style( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
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
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
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
		<ul <?php comment_class( 'media list-unstyled comment-' . get_comment_ID() ); ?>>

		<?php
		/**
		 * @link http://codex.wordpress.org/Function_Reference/comment_class
		 */
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'margin-bottom-25 media comment-' . get_comment_ID() ); ?> itemscope itemtype="http://schema.org/Comment">

			<span class="pull-left">
				<?php echo italystrap_get_avatar( $comment, null, null, get_comment_author(), 'img-circle img-responsive' );?>
			</span>
			<div class="media-body"><h2>Bello</h2>
				<ul class="list-inline margin-bottom-10">
					<li>
						<h4 class="media-heading">

						<?php if ( get_comment_author_url() ) { ?>

							<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span></a>

						<?php } else { ?>

							<span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php echo get_comment_author() ?></span><meta itemprop="image" content="<?php echo italystrap_get_avatar_url(get_comment_author_email()); ?>"/></span>

						<?php }
							/**
							 * If current post author is also comment author,
							 * make it known visually.
							 */
							$post_author = 
								apply_filters( 'italystrap_post_author',
									' <span class="label label-primary"> ' . __(
									'Post Author',
									'ItalyStrap'
								) . '</span> ' );

							printf( ( $comment->user_id === $post->post_author ) ? $post_author : ''); ?>
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
		if ( $comment->comment_type === '' )
			comment_reply_link( 
				array_merge(
					$args, 
					array(
						'reply_text' => __('Reply to ', 'ItalyStrap') . $comment->comment_author . ' <i class="glyphicon glyphicon-arrow-down"></i>',
						'depth'      => $depth,
						// 'max_depth'  => $args['max_depth']
						'max_depth'  => 1000
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
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body row" itemscope itemtype="http://schema.org/Comment">
				<section class="col-sm-2">
					<?php
					/**
					 * Di default dovrebbe essere a 32 quindi la if non serve, controllare
					 */
					$args['avatar_size'] = ( isset( $args['avatar_size'] ) ) ? $args['avatar_size'] : null ;
					echo italystrap_get_avatar( $comment, $args['avatar_size'], NULL, get_comment_author(), 'img-circle img-responsive center-block' );?>
				</section>
				<section class="col-sm-10">
					<footer class="comment-meta">
					
							<?php if ( is_user_logged_in() && current_user_can( 'manage_options' ) ): ?>
								<a href="<?php echo get_edit_comment_link(); ?>" class="btn btn-sm btn-warning pull-right"><?php echo __('Edit', 'ItalyStrap') ; ?> <i class="glyphicon glyphicon-pencil"></i></a>
							<?php endif ?>
							<?php
							$email =  get_comment_author_email();
					
							if ( $email )
								echo '<meta  itemprop="image" content="' . italystrap_get_avatar_url( $email ) . '"/>';
							?>
					
						<div class="comment-author vcard">
					
							<?php // if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
							<?php printf( __( '%s <span class="says">says:</span>' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link() ) ); ?>
						</div><!-- .comment-author -->
					
						<div class="comment-metadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
									<?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
							<?php // edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
					
					
						</div><!-- .comment-metadata -->
					
						<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation alert alert-info"><?php _e( 'Your comment is awaiting moderation.', 'ItalyStrap' ); ?></p>
						<?php endif; ?>
					</footer><!-- .comment-meta -->
					
					<div class="comment-content" itemprop="text">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->
					
					<?php
					
					$comment_reply_link_args = apply_filters( 'comment_reply_link_args', array(
						'reply_text' => __('Reply to ', 'ItalyStrap') . $comment->comment_author . ' <i class="glyphicon glyphicon-arrow-down"></i>',
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => 1000,
						'before'    => '<div class="reply">',
						'after'     => '</div>'
					) );
					
					comment_reply_link( array_merge( $args, $comment_reply_link_args ) );
					
					?>
				</section>
			</article><!-- .comment-body -->
<?php
	}
}

/**
 * Add a bootstrap button class to cancel reply
 * @param string $formatted_link Cancel reply a tag
 * @param string $link           Link to reply
 * @param string $text           Text to display
 */
function add_class_button_to_cancel_reply( $formatted_link, $link, $text ){

	return str_replace( '<a ', '<a class="btn btn-danger btn-xs" ', $formatted_link);

}
add_filter( 'cancel_comment_reply_link', 'add_class_button_to_cancel_reply', 10, 3 );

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
	$replace = array( '")\' rel=\'nofollow\'>', 'btn btn-primary btn-sm pull-right');
	$link = str_replace($search, $replace, $link);

	return $link;
}
add_filter( 'comment_reply_link', 'add_nofollow_and_bootstrap_button_css_to_reply_link' );

/**
 * Display a message if comments are closed
 * @return string Return message
 */
function display_message_if_comments_are_closed(){

    echo '<div class="alert alert-warning">' . __('Comments are closed.', 'ItalyStrap') . '</div>';

}
add_action( 'comment_form_comments_closed', 'display_message_if_comments_are_closed' );


/**
 * Argument for standard comment_form()
 * @param  string $comment_author Author of comment
 * @param  string $user_identity  Identity of user logged in
 * @return array                  An array with arguments for comment_form()
 */
function comment_form_args( $comment_author, $user_identity ){

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
			'<div class="form-group comment-form-author"><label for="author" class="sr-only">' . __( 'Name', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) <span class="required">*</span>', 'ItalyStrap') : '' ) . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="author" id="author" value="' . esc_attr( $comment_author ) . '" placeholder="' . __('Name','ItalyStrap') . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" tabindex="1"' . ( $req ? 'aria-required="true"' : '') . ' title="' . __( 'Name', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '"/></div></div>',

		'email'		=>
			'<div class="form-group comment-form-email"><label for="email" class="sr-only">' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) <span class="required">*</span>', 'ItalyStrap') : '' ) . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" tabindex="2" aria-describedby="email-notes" ' . $aria_req . $html_req  . ' title="' . __( 'Email (will not be published)', 'ItalyStrap' ) . ' ' . ( $req ? __('(required) *', 'ItalyStrap') : '' ) . '" /></div></div>',

		'url'		=>
			'<div class="form-group comment-form-url"><label for="url" class="sr-only">' . __( 'Website' ,'ItalyStrap') . '</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input type="url" class="form-control" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website (optional)' ,'ItalyStrap') . '" tabindex="3" title="' . __( 'Website (optional)' ,'ItalyStrap') . '" /></div></div>',

		);

	$comment_field = apply_filters( 'italystrap_comment_form_default_fields', $comment_field, $comment_author, $commenter, $req, $aria_req, $html_req );

	$comment_array = array(
		'fields'			=>	$comment_field,
		'class_submit'		=>	'btn btn-large btn-primary',
		'format'			=>	'html5',
		'comment_field' 	=>
			'<div class="form-group comment-form-comment"><label for="comment" class="sr-only">' . _x( 'Comment', 'noun' ) . '</label><textarea class="form-control" name="comment" id="comment" placeholder="' . __( 'Write your comment here' ,'ItalyStrap') . '" tabindex="4" rows="6" aria-required="true" title="' . __( 'Write your comment here' ,'ItalyStrap') . '"></textarea></div>',
		'logged_in_as'		=>
			'<p class="logged-in-as">' . sprintf( 
				__( 'Logged in as <a href="%1$s" class="btn btn-primary btn-xs">%2$s</a>. <a href="%3$s" title="Log out of this account" class="btn btn-warning btn-xs">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		'must_log_in'		=>
			'<p class="alert alert-danger margin-top-25 must-log-in">' . sprintf( __( 'You must be <a href="%s" class="alert-link">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		// 'cancel_reply_link'	=> '<span class="btn btn-danger btn-xs">' . __( 'Cancel reply' ) . '</span>',

		);

	return $comment_array = apply_filters( 'italystrap_comment_form_defaults', $comment_array, $user_identity, $comment_field );

}

/**
 * Pagination for comment
 * @since ItalyStrap 3.1
 * @return string Return pagination
 */
function italystrap_comment_pagination(){

	if ( get_comment_pages_count() > 1 && get_option('page_comments') ){ ?>

		<nav class="text-center" itemscope itemtype="http://schema.org/SiteNavigationElement">
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
					'prev_text'	=> __( '&laquo; Previous comments' , 'ItalyStrap' ),
					'next_text'	=> __( 'Next comments &raquo;', 'ItalyStrap' ),
					)
				);
			if ( is_array( $pages ) ){
				$pages = str_replace('<a', '<a itemprop="url"', $pages);
				foreach($pages as $page){
					$position = strpos($page, '<span');
					if ( $position === false )
						echo '<li itemprop="name">' . $page . '</li>';
					else
						echo '<li class="active" itemprop="name">' . $page . '</li>';
				}
			}
			?>

			</ul>
		</nav>

	<?php }

}



















/**********************
 * DEPRECATED FUNCTION
 **********************/
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

	_deprecated_function( __FUNCTION__, 'ItalyStrap 3.1' );

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
			<div class="row margin-bottom-25 padding-15 <?php if ($comment->user_id === $post->post_author) { echo 'bg-color-author';} ?>"itemscope itemtype="http://schema.org/Comment">
				<div class="col-md-2"><?php echo get_avatar($comment, '92') ?></div>
				<div class="col-md-10">
					<ul class="list-inline margin-bottom-10">
						<li>
							<h4 class="media-heading">
								<a class="url" rel="external nofollow" href="<?php comment_author_url(); ?>" itemprop="url"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php echo get_comment_author() ?><meta itemprop="image" content="<?php  $thumbnailUrl = get_avatar($comment); echo estraiUrlsGravatar($thumbnailUrl);?>"/></span></a>
								<?php
								/**
								 * If current post author is also comment author,
								 * make it known visually.
								 * @var [type]
								 */
								printf(
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