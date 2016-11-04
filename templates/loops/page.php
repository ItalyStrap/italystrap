<?php
/**
 * The template used for displaying page content
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

$template_settings = (array) apply_filters( 'italystrap_template_settings', array() );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'templates/loops/parts/title' ); ?>

	<?php get_template_part( 'templates/loops/parts/meta' ); ?>

	<?php get_template_part( 'templates/loops/parts/preview' ); ?>

	<?php get_template_part( 'templates/loops/parts/featured', 'image' ); ?>

	<?php get_template_part( 'templates/loops/parts/content' ); ?>

	<p class="sr-only"><?php esc_attr_e( 'Last edit:', 'ItalyStrap' ); ?> <time datetime="<?php the_modified_time( 'Y-m-d' ) ?>" itemprop="dateModified"><?php the_modified_time( 'd F Y' ) ?></time></p>
	<span class="clearfix"></span>

	<?php
	/**
	 * Arguments for edit_post_link()
	 *
	 * @var array
	 */
	$args = array(
		/* translators: %s: Name of current post */
		'link_text'	=> __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'ItalyStrap' ),
		'before'	=> '<span class="btn btn-sm btn-primary">',
		'after'		=> '</span>',
		);
	$args = apply_filters( 'italystrap_edit_post_link_args', $args );

	edit_post_link(
		sprintf(
			$args['link_text'],
			get_the_title()
		),
		$args['before'],
		$args['after']
	);
	?>

	<?php echo italystrap_ttr_wc(); // XSS ok.?>
	<span class="clearfix"></span>

	<?php
	/**
	 * Display author info box
	 */
	if ( ! in_array( 'hide_author', $template_settings, true ) ) {
		get_template_part( 'template/content', 'author-info' );
	}
	?>

	<meta itemprop="interactionCount" content="UserComments:<?php comments_number( 0, 1, '%' );?>" />
</article>
