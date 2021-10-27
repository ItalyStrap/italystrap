<?php
declare(strict_types=1);

// phpcs:ignoreFile

namespace ItalyStrap\Image;

use function __;
use function absint;
use function apply_filters;
use function esc_attr;
use function esc_url;
use function get_posts;
use function get_the_ID;
use function get_the_title;
use function has_post_thumbnail;
use function is_numeric;
use function ItalyStrap\Core\get_attr;
use function ItalyStrap\Factory\get_config;
use function remove_theme_mod;
use function wp_get_attachment_image_src;
use function wp_get_attachment_url;

/**
 * Get the custom image URL from customizer
 *
 * @param string|null $key 		Custom image array's key name
 *                         		 - default_image
 *                         		 - logo
 *                         		 - default_404.
 * @param string|null $default 	SRC of a default image url.
 * @return string          		Return the image URL if exist
 */
function get_the_custom_image_url( string $key = null, string $default = null ): string {

	if ( ! $key ) {
		return '';
	}

	$theme_mods = get_config();
	$image_id_or_url = (string) $theme_mods->get( $key, $default );

	if ( empty( $image_id_or_url ) ) {
		return '';
	}

	if ( is_numeric( $image_id_or_url ) ) {
		return esc_url( (string) wp_get_attachment_url( (int) $image_id_or_url ) );
	}

	return esc_url( $image_id_or_url );
}

/**
 * Get the image for 404 page
 * The image is set in the customizer
 *
 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
 * @see https://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
 *
 * @param string $class
 * @return string Return html image string for 404 page
 */
function get_404_image( string $class = '' ): string {

	$config = get_config();

	if ( 'show' !== $config->get('404_show_image') ) {
		return '';
	}

	/**
	 * Back compat with the old setting name
	 */
	$default_image = $config->get('default_404');

	if ( empty( $config['404_image'] ) ) {
		$config['404_image'] = $config['default_404'];
		remove_theme_mod( 'default_404' ); // Remove the old value from database
	}

	$image_404_url = $default_image;
	$width = absint( $config['content_width'] );
	$height = '';
	$alt = __( 'Image for 404 page', 'italystrap' ) . ' ' . esc_attr( $config->get( 'GET_BLOGINFO_NAME') );

	if ( is_numeric( $config['404_image'] ) ) {
		$size = apply_filters( 'italystrap_404_image_size', $config['post_thumbnail_size'] );

		$id = (int) $config['404_image'];
		$meta = wp_get_attachment_image_src( $id, $size );
		$image_404_url = $meta[0];
		$width = esc_attr( $meta[1] );
		$height = esc_attr( $meta[2] );
	}

	$attr = [
		'class'		=>	$class,
		'width'		=>	empty( $width ) ? '' : $width . 'px',
		'height'	=>	empty( $height ) ? '' : $height . 'px',
		'src'		=>	$image_404_url,
		'alt'		=>	$alt,

	];

	$html = sprintf(
		'<img %s>',
		get_attr( '', $attr )
	);

	$html = apply_filters( 'italystrap_404_image_html', $html );

	return apply_filters('italystrap_lazyload_images_in_this_content', $html);
}

/**
 * Get the attachment ID from image url
 *
 * @link https://wordpress.org/support/topic/need-to-get-attachment-id-by-image-url
 *
 * @param  string $url The url of image
 * @return int         The ID of the image
 */
function get_ID_image_from_url( string $url ): int {
	global $wpdb;
	$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM %s WHERE guid=%s", [ $wpdb->posts, $url ] ) );
	return absint( $id );
}

/**
 * Show thumbnail image of a post if exist or fallback to
 * an image inside the post itself if exists.
 *
 * @param null $postID Post ID inside the loop
 * @param string $size Thumb name declare in add_image_size()
 * @param array $attr
 * @param int $default_width
 * @param int $default_height
 * @param string $default_image
 * @return string
 */
function get_the_post_thumbnail(
	$postID = null,
	string $size = 'post-thumbnail',
	array $attr = [],
	int $default_width = 0,
	int $default_height = 0,
	string $default_image = ''
): string {

	/**
	 * If has feautured image bail.
	 */
	if ( has_post_thumbnail() ) {
		return \get_the_post_thumbnail( $postID, $size, $attr );
	}

	$postID = ( null === $postID ) ? get_the_ID() : $postID;

	/**
	 * Array arguments for get_posts()
	 *
	 * @var array
	 */
	$args = array(
		'numberposts' => 1,
		'post_parent' => $postID,
		'post_type' => 'attachment',
		// 'post_status' => null,
		'post_mime_type' => 'image',
		'order' => 'ASC',
	);

	/**
	 * Get the post object
	 *
	 * @var object
	 */
	$first_images = get_posts( $args );

	/**
	 * Text alternative for image
	 *
	 * @var string
	 */
	$alt = ( empty( $first_images[0]->post_title ) ) ? get_the_title() : $first_images[0]->post_title ;

	/**
	 * Set the default alt value if $attr['alt'] is empty
	 */
	$attr['alt'] = ( ! empty( $attr['alt'] ) ) ? $attr['alt'] : $alt;

	/**
	 * Set the default class value if $attr['class'] is empty
	 */
	$attr['class'] = ( ! empty( $attr['class'] ) ) ? $attr['class'] : '';

	$default_image = get_the_custom_image_url( 'default_image' );

	/**
	 * Fallback image
	 *
	 * @var string
	 */
	$default_image = '<img src="'
		. $default_image . '" width="'
		. $default_width . 'px" height="'
		. $default_height . 'px" alt="'
		. $attr['alt'] . '" class="'
		. $attr['class'] . '">';

	/**
	 * Set the default image
	 *
	 * @var string
	 */
	$image_html = $default_image;

	if ( $first_images ) {

		/**
		 * Get the attachment value
		 *
		 * @var array
		 */
		$image_attributes = wp_get_attachment_image_src( $first_images[0]->ID, $size );

		/**
		 * $default_width imposta la larghezza di default dell'immagine
		 * Se l'immagine nel post è più piccola del 10% la mostra altrimenti no.
		 */
		if ( $image_attributes[1] >= $default_width / 1.1 ) {
			$image_html = '<img src="'
				. $image_attributes[0] . '" width="'
				. $image_attributes[1] . '" height="'
				. $image_attributes[2] . '" alt="'
				. $attr['alt'] . '" class="'
				. $attr['class'] . '">';
		}
	}

	return apply_filters('italystrap_lazyload_images_in_this_content', $image_html);
}
