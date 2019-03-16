<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 *
 * @todo Add to customizer custom 404 page
 */

namespace ItalyStrap;

?>
<section id="post-not-found" <?php HTML\get_attr( 'section_none', ['class' => 'no-results not-found'], true ); ?>>
<?php
	\do_action( 'italystrap_before_entry_content_none' );

		\do_action( 'italystrap_entry_content_none' );

	\do_action( 'italystrap_after_entry_content_none' );
?>
</section><!-- #post-0 -->
