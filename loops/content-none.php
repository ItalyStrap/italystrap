<?php namespace ItalyStrap;
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package ItalyStrap
 * @since 1.0.0
 *
 * @todo Add to customizer custom 404 page
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h1  class="page-title" itemprop="headline">
			<?php esc_attr_e( 'Nothing Found', 'ItalyStrap' ); ?>
		</h1>
	</header>
	<div class="page-content">

		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :?>

			<p>
				<?php printf( esc_attr__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ItalyStrap' ), esc_url( admin_url( 'post-new.php' ) ) ); ?>
			</p>

		<?php
		elseif ( is_search() ) : ?>

			<p>
				<?php esc_attr_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ItalyStrap' ); ?>
			</p>

		<?php
			get_search_form();

		else : ?>

			<p>
				<?php esc_attr_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ItalyStrap' ); ?>
			</p>
			<?php
			get_search_form();
			echo italystrap_get_404_image( 'margin-top-25 img-responsive center-block' );

		endif; ?>

	</div><!-- .page-content -->

</section><!-- #post-0 -->
<hr>
