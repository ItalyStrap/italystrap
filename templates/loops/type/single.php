<?php
/**
 * The template part for displaying single posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	do_action( 'italystrap_before_entry_content' );

		do_action( 'italystrap_entry_content' );

	do_action( 'italystrap_after_entry_content' );

?>
	<span class="clearfix"></span>
	<meta itemprop="interactionCount" content="UserComments:<?php comments_number( 0, 1, '%' );?>" />
</article>
