<?php
/**
 * The template used for displaying the title.
 *
 * This file is still in BETA version.
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

$tag = is_singular() ? 'h1' : 'h2';
$title_prop = is_singular() ? 'headline' : 'name';
$args = array(
	'before'	=> sprintf(
		'<%1$s class="entry-title"><a itemprop="url" href="%2$s" title="%3$s" rel="bookmark"><span itemprop="%4$s">',
		$tag,
		esc_url( get_permalink() ),
		the_title_attribute( 'echo=0' ),
		$title_prop
	),
	'after'		=> sprintf(
		'</span></a></%1$s>',
		$tag
	),
);
// the_title( $args['before'], $args['after'] );
?><header class="page-header entry-header">
	<<?php echo $tag; ?> class="entry-title">
		<a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
			<span itemprop="<?php echo $title_prop; ?>"><?php the_title(); ?></span>
		</a>
	</<?php echo $tag; ?>>
</header>