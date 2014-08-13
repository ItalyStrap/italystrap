<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage ItalyStrap
 * @since ItalyStrap 1.8.1
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<section id="comments">

		<?php 
		// $count = 0;
		// $comment_entries = get_comments(array( 'type'=> 'comment', 'post_id' => $post->ID ));
		// if(count($comment_entries) > 0){
		//     foreach($comment_entries as $comment){
		//         if($comment->comment_approved)
		//             $count++;
		//     }
		// }

		// if (comments_open() ){
		// 		if($count == 0){
		// 		echo "";
		// 		}
		// 		else if($count == 1){
		// 		echo "<h3>$count Commento</h3>";
		// 		}				
		// 		else echo "<h3>$count Commenti</h3>";
		// 	}
		?>
		<div class="row">
			<div class="col-md-12">
			<?php if ( have_comments() ) : ?>
			
			          	<h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'ItalyStrap'), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h3>
			
			<?php 
			   	// if( !empty( $comment_entries ) ){
			                	wp_list_comments(
			                		array( 
			                			'walker' => new ItalyStrap_Walker_Comment,
			                			// 'type'=> 'comment',
			                			// 'callback' => 'ItalyStrap_custom_comment'
			                			)
			                		);
			            // }
			        ?>
			
				<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) : ?>
				            <nav itemscope itemtype="http://schema.org/SiteNavigationElement">
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
						    		'prev_text'	=> __('&laquo; Previous comments' , 'ItalyStrap'),
						    		'next_text'	=> __('Next comments &raquo;', 'ItalyStrap'),
						    		)
						    	);
						    if ( is_array( $pages ) ){
						    	$pages = str_replace('<a', '<a itemprop="url"', $pages);
						    	foreach($pages as $page){
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
				<?php endif; // Pagination ?>
			
			<?php endif;?>
			</div>
		</div>
</section><!-- /#comments -->

<section id="respond">
<?php
/**
 * Form dei commenti
 *
 */
if ( comments_open() ) : ?>

	<h3><?php comment_form_title( __("What do you think about?","ItalyStrap"), __("Reply","ItalyStrap") . ' %s' ); ?></h3>

	<p><?php new_cancel_comment_reply_link( __("Cancel" , "ItalyStrap") ); ?></p>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p class="alert alert-warning margin-top-25"><?php _e('You need to be', 'ItalyStrap'); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>" class="alert-link" ><?php _e("logged in","ItalyStrap"); ?></a> <?php _e('to write a comment :-)', 'ItalyStrap'); ?></p>
	<?php else : ?>

<div class="form-actions">
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" role="form">

		<?php if ( is_user_logged_in() ) : ?>

			<p class="comments-logged-in-as"><?php _e("Logged in as","ItalyStrap"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Exit","ItalyStrap"); ?>" class="btn btn-default btn-xs"><?php _e('Exit &raquo;', 'ItalyStrap'); ?></a></p>

		<?php else : ?>

				<div class="form-group">
					<label for="author" class="sr-only"><?php _e('Name','ItalyStrap'); ?> <?php if ($req) _e(' (required)', 'ItalyStrap'); ?></label>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

						<input type="text" class="form-control" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e('Name','ItalyStrap'); ?> <?php if ($req) _e(' (required)', 'ItalyStrap'); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="sr-only"><?php _e('Email (will not be published)','ItalyStrap'); ?> <?php if ($req) _e(' (required)', 'ItalyStrap'); ?></label>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						
						<input type="email" class="form-control" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e('Email (will not be published)','ItalyStrap'); ?> <?php if ($req) _e(' (required)', 'ItalyStrap'); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
					</div>
				</div>

				<div class="form-group">
					<label for="url" class="sr-only"><?php _e( 'Website' ,'ItalyStrap'); ?></label>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

						<input type="url" class="form-control" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e( 'Website (optional)' ,'ItalyStrap'); ?>" tabindex="3" />
					</div>
				</div>

		<?php endif; ?>

			<div class="form-group">
				<label for="comment" class="sr-only"><?php _e('Comment', 'ItalyStrap'); ?></label>
				<textarea class="form-control" name="comment" id="comment" placeholder="<?php _e( 'Write your comment here' ,'ItalyStrap'); ?>" tabindex="4" rows="6"></textarea>
			</div>

			<input class="btn btn-large btn-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'ItalyStrap'); ?>" />

			<?php comment_id_fields(); ?>

			<?php do_action('comment_form()', $post->ID); ?>

	</form>
</div>
		
		<?php endif; // If registration required and not logged in ?>

<?php else: ?>

<div class="alert alert-warning">
	<?php _e('Comments are closed.', 'ItalyStrap'); ?>
</div>

<?php endif; // Comment open ?>
</section>