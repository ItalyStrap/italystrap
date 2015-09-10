<?php
_deprecated_file( basename(__FILE__), 'ItalyStrap 3.1.0', 'template/content-author-info', __( 'This file no longer needs to be included. Please use the plugin ItalyStrap.' ) );
get_template_part( 'template/content', 'author-info' );
?>
<!-- AUTHOR -->
<section class="margin-top-25 well" itemprop="author" itemscope itemtype="http://schema.org/Person">
	<div class="row">
		<div class="col-md-2">
			<a href="<?php the_author_meta('url') ?>" rel="author" itemprop="url"><?php echo italystrap_get_avatar( get_the_author_meta('ID'), NULL, NULL, get_the_author(), 'img-circle img-responsive' ); ?></a>
		</div>
		<div class="col-md-10">
			<p itemprop="description"><?php the_author_meta( 'description' ) ?></p>
			<h4 itemprop="name"><?php the_author_posts_link(); ?></h4>
			<meta itemprop="image" content="<?php echo italystrap_get_avatar_url( get_the_author_meta('email') ); ?>"/>
			<ul class="list-inline">
			<?php   $twitter = get_the_author_meta( 'twitter' ); 
					if (!empty($twitter)){
						echo '<li><a href="' . $twitter . '" title="Twitter" rel="me" class="sprite32 twitter32" itemprop="sameAs"></a></li>';
					};
					$fb_profile = get_the_author_meta( 'fb_profile' ); 
					if (!empty($fb_profile)){
						echo '<li><a href="' . $fb_profile . '" title="Facebook" rel="me" class="sprite32 facebook32" itemprop="sameAs"></a></li>';
					};
					$google_profile = get_the_author_meta( 'google_profile' ); 
					if (!empty($google_profile)){
						echo '<li><a href="' . $google_profile . '" title="Google+" rel="me" class="sprite32 googleplus32" itemprop="sameAs"></a></li>';
					};
					$skype = get_the_author_meta( 'skype' ); 
					if (!empty($skype)){
						echo '<li><a href="skype:' . $skype . '?chat" title="skype" rel="me" class="sprite32 skype32"></a></li>';
					};
					$google_page = get_the_author_meta( 'google_page' ); 
					if (!empty($google_page)){
						echo '<li><a href="' . $google_page . '" title="Google Business page" rel="me" class="sprite32 googleplus32" itemprop="sameAs"></a></li>';
					};
					$linkedIn = get_the_author_meta( 'linkedIn' ); 
					if (!empty($linkedIn)){
						echo '<li><a href="' . $linkedIn . '" title="linkedIn" rel="me" class="sprite32 linkedin32" itemprop="sameAs"></a></li>';
					};
					$pinterest = get_the_author_meta( 'pinterest' ); 
					if (!empty($pinterest)){
						echo '<li><a href="' . $pinterest . '" title="pinterest" rel="me" class="sprite32 pinterest32" itemprop="sameAs"></a></li>';
					};
			?>
			</ul>
		</div>
	</div>
</section>