<?php
declare(strict_types=1);

// phpcs:ignoreFile

namespace ItalyStrap\Image;

use function absint;

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
