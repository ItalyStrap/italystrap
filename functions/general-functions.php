<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\Core;

/**
 * Get the template parts settings.
 * This methos has to be called inside a loop.
 *
 * @return array Return the array with template part settings.
 */
function get_template_settings(): array {

	static $parts = null;

	/**
	 * Cache the post_meta data
	 */
	if ( ! $parts ) {

		/**
		 * This is a little different from the layout settings because
		 * only in singular it must return the data from post_meta
		 *
		 * @var [type]
		 */
//			$parts = ! is_singular()
//? (array) self::$post_content_template
//: (array) get_post_meta( $this->get_the_ID(), '_italystrap_template_settings', true );
		$parts = (array) \ItalyStrap\Factory\get_config()->get('post_content_template');
	}

	return (array) apply_filters( 'italystrap_get_template_settings', $parts );
}
