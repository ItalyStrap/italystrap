<?php
/**
 * Template file for Archive headline
 * s
 *
 * @link www.italystrap.com
 * @since 1.0.0
 * @since WP 4.9.0 Added support for post type archives
 *
 * @package ItalyStrap
 */
declare(strict_types=1);

namespace ItalyStrap\Misc;

?>
<!-- wp:group {"tagName":"header","className":"page-header","layout":{"inherit":true}} -->
<header class="wp-block-group page-header">

	<?php if ( 'search' === \CURRENT_TEMPLATE_SLUG ) : ?>
		<h1 itemprop="headline">
			<?php \printf(
				\esc_html__('Search result of: %s', 'italystrap' ),
				'<span>' . \get_search_query() . '</span>'
			);
			?>
		</h1>
	<?php else : ?>
		<!-- wp:query-title {"type":"archive"} /-->
		<!-- wp:term-description /-->
	<?php endif; ?>

</header>
<!-- /wp:group -->