<?php
declare(strict_types=1);

use ItalyStrap\Config\ConfigInterface;

/** @var ConfigInterface $config */
$config = $this;
?>
<div class="page-content"><?php

if ( \is_home() && \current_user_can( 'publish_posts' ) ) :
	?>
	<p class="no-posts">
	<?php
	$message = \wp_kses(
		__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'italystrap' ),
		[
			'a'	=> [
				'href'	=> [],
				'title'	=> [],
			]
		]
	);
	\printf(
		$message,
		\esc_url( \admin_url( 'post-new.php' ) )
	);

	?>
	</p>
	<?php
elseif ( \is_search() ) :
	?>
	<p class="no-posts">
	<?php
	\esc_attr_e(
		'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
		'italystrap'
	); ?></p><?php

	echo \do_blocks( '<!-- wp:search {"buttonUseIcon":true} /-->' );
else :
	?><p class="no-posts"><?php echo \wp_kses_post( (string)$config->get('content') ); ?></p><?php
		echo \do_blocks( '<!-- wp:search {"buttonUseIcon":true} /-->' );
endif;

?>
</div><!-- .page-content -->
