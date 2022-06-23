<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Event\SubscriberInterface;
use function ItalyStrap\HTML\get_attr;

class OembedWrapper implements SubscriberInterface {


	/**
	 * Wrap embedded media as suggested by Readability
	 * Add code to Oembed media
	 *
	 * @link https://gist.github.com/965956
	 * @link http://www.readability.com/publishers/guidelines#publisher
	 * Rootstheme function
	 * Renamed and modify for new bootstrap class for video embed
	 *
	 * @since 1.0.0
	 * @since 4.0.0 (Refactored)
	 *
	 * @see WP_Embed::shortcode()
	 *
	 * @param mixed   $cache   The cached HTML result, stored in post meta.
	 * @param string  $url     The attempted embed URL.
	 * @param array   $attr    An array of shortcode attributes.
	 * @param int     $post_ID Post ID.
	 *
	 * @return string          Return the new HTML.
	 */
	function embed_wrap( $cache, $url, $attr, $post_ID ) {

		if ( \strpos( $cache, 'class="twitter-tweet"' ) ) {
			return $cache;
		}

		$container_attr = get_attr(
			'embed-responsive',
			[
				'class' => 'entry-content-asset embed-responsive embed-responsive-16by9'
			]
		);

		$ifr_attr = get_attr(
			'embed-responsive-item',
			[
				'class' => 'embed-responsive-item'
			]
		);

		$elements = \explode(' ', $cache );

		if ( ! \in_array( 'class', $elements, true ) ) {
			\array_splice( $elements, 1, 0, \trim( $ifr_attr ) );
		}

		return \sprintf(
			'<div%s>%s</div>',
			$container_attr,
			\implode( ' ', $elements )
		);
	}

	public function getSubscribedEvents(): iterable {

//		\add_filter( 'embed_oembed_html', __NAMESPACE__ . '\embed_wrap', 10, 4 );
		yield 'embed_oembed_html' => [
			SubscriberInterface::CALLBACK	    => 'embed_wrap',
			SubscriberInterface::PRIORITY	    => 10, // 10 default
			SubscriberInterface::ACCEPTED_ARGS	=> 4 // 3 default
		];
	}
}
