<?php
/**
 * The template used for displaying page content
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

$template_settings = (array) apply_filters( 'italystrap_template_settings', array() );

if ( in_array( 'hide_title', $template_settings, true ) ) {
	return;
}

?>
<header class="page-header entry-header">
	<h1 class="entry-title">
		<a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
			<span itemprop="headline">
				<?php the_title(); ?>
			</span>
		</a>
	</h1>
</header>