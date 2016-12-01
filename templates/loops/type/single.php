<?php
/**
 * The template part for displaying single posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 */

namespace ItalyStrap;

$template_settings = (array) apply_filters( 'italystrap_template_settings', array() );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php get_template_part( 'templates/loops/type/parts/title' ); ?>

	<?php get_template_part( 'templates/loops/type/parts/meta' ); ?>

	<?php get_template_part( 'templates/loops/type/parts/preview' ); ?>

	<?php get_template_part( 'templates/loops/type/parts/featured', 'image' ); ?>

	<?php get_template_part( 'templates/loops/type/parts/content' ); ?>

	<?php
	/**
	 * Arguments for wp_link_pages
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_link_pages/
	 * @var array
	 */
	$args = array(
		'before'	=> '<p class="text-muted lead"><b>' . __( 'Pages:', 'ItalyStrap' ) . '</b>',
		'after'		=> '</p>',
	);
	$args = apply_filters( 'italystrap_wp_link_pages_args', $args );

	wp_link_pages( $args );
	?>
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
		get_template_part( 'templates/parts/author', 'info' );
	}
	?>
	<meta itemprop="interactionCount" content="UserComments:<?php comments_number( 0, 1, '%' );?>" />
</article>
<?php
/**
 * Arguments for previous_post_link() and next_post_link()
 *
 * @var array
 */
$args = array(
	'previous_format'	=> '<li class="previous pager-prev"> %link',
	'previous_link'		=> '<i class="glyphicon glyphicon-arrow-left"></i> %title</li>',
	'next_format'		=> '<li class="next pager-next"> %link',
	'next_link'			=> '%title <i class="glyphicon glyphicon-arrow-right"></i></li>',
	);
$args = apply_filters( 'italystrap_previous_next_post_link_args', $args );
?>
<ul class="pager">
	<?php
	previous_post_link( $args['previous_format'], $args['previous_link'] );
	next_post_link( $args['next_format'], $args['next_link'] );
	?>
</ul>
<span class="clearfix"></span>
<hr>
