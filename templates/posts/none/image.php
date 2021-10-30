<?php
/**
 * The template part for displaying a 404 image
 *
 * List of built in action:
 * do_action( 'begin_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size );
 * do_action( 'end_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size );
 *
 * List of built in filters:
 * $size = apply_filters( 'post_thumbnail_size', $size );
 * return apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr );
 *
 * @uses has_post_thumbnail()
 * @uses the_post_thumbnail( $size, $attr )
 *
 * @see get_the_post_thumbnail() wp-includes/post-thumbnail-template.php
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */
declare(strict_types=1);


namespace ItalyStrap;

$context = null;

$featured_image_class = array(
	'class' => '404-image',
);

if ( \is_404() ) { ?>
	<figure <?php HTML\get_attr_e( '404_image', $featured_image_class ); ?>>
		<?php echo Image\get_404_image( 'img-responsive center-block' ); ?>
	</figure>
<?php }
