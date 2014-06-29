<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>    
		<?php die('Non puoi accedere a questa pagina direttamente!'); ?>  
<?php endif; ?>

<?php if(!empty($post->post_password)) : ?>  
        <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
		<p>Questo post &egrave; protetto da password. Per leggerlo inserisci password per visualizzare i commenti<p>
        <?php endif; ?>  
<?php endif; ?>
<!-- Puoi cominciare le modifiche da qui. -->
<?php
$count = 0;
$comment_entries = get_comments(array( 'type'=> 'comment', 'post_id' => $post->ID ));
if(count($comment_entries) > 0){
    foreach($comment_entries as $comment){
        if($comment->comment_approved)
            $count++;
    }
}
?>
<section>
	<div id="comments">
		<?php if (comments_open() ){
				if($count == 0){
				echo "";
				}
				else if($count == 1){
				echo "<h3>$count Commento</h3>";
				}				
				else echo "<h3>$count Commenti</h3>";
			}
		?>
			<div class="row">
				<?php
                  if ( have_comments() ) : 
                  if(!empty($comment_entries)){
                  wp_list_comments( array( 'type'=> 'comment', 'callback' => 'ItalyStrap_custom_comment' ) );
                } ?>
                <ul class="pagination pagination-sm">
				    <?php 
				    /**
				    *http://wordpress.stackexchange.com/questions/125389/return-paginate-comments-links-as-array
				    * Then I modify below code, now print bootstrap style correctly
				    */
				        $pages = paginate_comments_links( array( 'echo' => false, 'type' => 'array', 'prev_text'    => __('&laquo; Previous comments' , 'italystrap'), 'next_text'    => __('Next comments &raquo;', 'italystrap'),) );
				        foreach($pages as $page){
				        	$position = strpos($page, '<span');
				        	if ( $position === false ) {
				        		echo '<li>' . $page . '</li>';
				        	} else {
				        		echo '<li class="active">' . $page . '</li>';
				        	}
						}
				    ?>
				</ul>
            <?php endif;?>
			</div>
	</div>
<?php  
    /**
     * ItalyStrap_custom_comment()
     * @return
     */
    function ItalyStrap_custom_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>

                <li class="comment media" id="comment-<?php comment_ID(); ?>">
                    <div class="media-body">
                        <p>
                            <?php _e('Pingback:', 'ItalyStrap'); ?> <?php comment_author_link(); ?>
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
												printf(
												// If current post author is also comment author, make it known visually.
													($comment->user_id === $post->post_author) ? '<span class="label label-danger"> ' . __(
														'The Boss :-)',
														'ItalyStrap'
													) . '</span> ' : ''); ?>
											</h4>
											
											</li>
											<li><time datetime="<?php comment_date('Y-m-d', $comment) ?>" itemprop="datePublished"><?php comment_date('j M Y', $comment) ?></time></li>
											<?php edit_comment_link(__('Modifica','ItalyStrap'),'<span class="btn btn-sm btn-info pull-right"><i class="glyphicon glyphicon-pencil"></i> ','</span>') ?>
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
																	'reply_text' => __('Rispondi <i class="glyphicon glyphicon-arrow-down"></i>', 'ItalyStrap'),
																	'depth'      => $depth,
																	'max_depth'  => $args['max_depth'],
																	'class'      => _('btn'),
																	)
																),
																$comment->comment_ID
															); 
														// $reply = get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID);
														// echo $reply;
													?>
												</p>
									</div>
								</div>

                </div>
                <?php
                break;
        endswitch;
    }
?>


<?php if ( comments_open() ) : ?>
		<h3><?php comment_form_title( __("E tu cosa ne pensi?","ItalyStrap"), __("Rispondi a ","ItalyStrap") . ' %s' ); ?></h3>
			<p><?php new_cancel_comment_reply_link( __("Annulla" , "ItalyStrap") ); ?></p>
				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p class="alert margin-top-25">Devi essere <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e("loggato","ItalyStrap"); ?></a> per scrivere il tuo commento :-)</p>
				<?php else : ?>
				<div class="form-actions">
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" role="form">
						<?php if ( is_user_logged_in() ) : ?>
						<p class="comments-logged-in-as"><?php _e("Loggato come","ItalyStrap"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Esci","ItalyStrap"); ?>">Esci &raquo;</a></p>

						<?php else : ?>
							<ul id="comment-form-elements" class="clearfix list-unstyled">
								
								<li>
									<div class="form-group">
										<label for="author" class="sr-only"><?php _e("Nome","ItalyStrap"); ?> <?php if ($req) echo "(Richiesto)"; ?></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
												<input type="text" class="form-control" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e("Il tuo nome (Richiesto)","ItalyStrap"); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
											</div>
									</div>
								</li>
								<li>
									<div class="form-group">
										<label for="email" class="sr-only"><?php _e("Mail","ItalyStrap"); ?> <?php if ($req) echo "(Richiesta)"; ?></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
												<input type="email" class="form-control" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e("La tua mail (Richiesta)","ItalyStrap"); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
											</div>
									</div>
								</li>
								<li>
									<div class="form-group">
										<label for="url" class="sr-only"><?php _e("Sito web","ItalyStrap"); ?></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
												<input type="url" class="form-control" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e("Il tuo sito web (opzionale)","ItalyStrap"); ?>" tabindex="3" />
											</div>
									</div>
								</li>
							</ul>
						<?php endif; ?>
							<textarea class="form-control" name="comment" id="comment" placeholder="Scrivi il tuo commento qui" tabindex="4" rows="6"></textarea>
						  <input class="btn btn-large btn-primary margin-top-25" name="submit" type="submit" id="submit" tabindex="5" value="Invia il commento" />
						  <?php comment_id_fields(); ?>
					
						<?php 
							//comment_form();
							do_action('comment_form()', $post->ID); 
						
						?>
					</form>
				</div>
		
		<?php endif; // If registration required and not logged in ?>
<?php endif; // If registration required and not logged in ?>
</section>