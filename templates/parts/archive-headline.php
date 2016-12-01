<?php
/**
 * Template file for Archive headline
 * s
 *
 * @link [URL]
 * @since 1.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

?><header class="page-header">
	<?php 

	if ( 'search' === CURRENT_TEMPLATE_SLUG ) {
		?>
		<h1 itemprop="headline"><?php printf( esc_html__( 'Search result of: %s', 'italystrap' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php
		return null;
	}

	?>
	<?php
	the_archive_title( '<h1 class="page-title" itemprop="name">', '</h1>' );
	the_archive_description( '<div class="well taxonomy-description" role="alert" itemprop="description">', '</div>' );

	/**
	 * Display or retrieve title for a Custom Post Type archive.
	 * This is optimized for archive.php and archive-{posttype}.php template files for displaying the title of the CPT.
	 */
	if ( is_post_type_archive() ) {

		$cpt_description = get_post_type_object( get_post_type() );

		if ( $cpt_description ) { ?>

		<div class="well" role="alert" itemprop="description"><p>
			<?php echo esc_attr( $cpt_description->description ); ?>
		</p></div>

		<?php }
	} ?>
</header>
