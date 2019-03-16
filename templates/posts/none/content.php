<div class="page-content"><?php

	if ( \is_home() && \current_user_can( 'publish_posts' ) ) :

		?><p class="no-posts"><?php

		\printf(
			\wp_kses(
				__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'italystrap' ),
				[
					'a' => [
						'href' => [],
						'title' => []
					]
				]
			),
			\esc_url( \admin_url( 'post-new.php' ) )
		);

		?></p><?php

	elseif ( \is_search() ) :

		?><p class="no-posts"><?php \esc_attr_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'italystrap' ); ?></p><?php

		\get_search_form();

	else :

	?><p class="404-content"><?php echo \wp_kses_post( $this->theme_mod['404_content'] ); ?></p><?php

		\get_search_form();

	endif;

	?>
</div><!-- .page-content -->