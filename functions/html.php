<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\HTML;

use function ItalyStrap\Core\is_static_front_page;
use function ItalyStrap\Factory\get_config;

if ( ! \function_exists( __NAMESPACE__ . '\build_site_layout_experimental' ) ) {
	function build_site_layout_experimental( string $type ): string {

		if ( ! \did_action('wp') ) {
			throw new \RuntimeException( __( __FUNCTION__ . ' must be loaded after "wp" hook', 'italystrap' ) );
		}

		$config = get_config();

		$site_layout = (string) $config->get( 'site_layout' );

		/**
		 * @var array $classes
		 */
		$classes = [
			'full_width'				=> [
				'content'			=> $config->get('full_width'),
				'sidebar'			=> '',
				'sidebar_secondary'	=> '',
			],
			'content_sidebar'			=> [
				'content'			=> $config->get('content_class'),
				'sidebar'			=> $config->get('sidebar_class'),
				'sidebar_secondary'	=> '',
			],
			'content_sidebar_sidebar'	=> [
				'content'			=> 'col-md-7',
				'sidebar'			=> 'col-md-3',
				'sidebar_secondary'	=> 'col-md-2',
			],
			'sidebar_content_sidebar'	=> [
				'content'			=> 'col-md-7 col-md-push-3',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2',
			],
			'sidebar_sidebar_content'	=> [
				'content'			=> 'col-md-7 col-md-push-5',
				'sidebar'			=> 'col-md-3 col-md-pull-7',
				'sidebar_secondary'	=> 'col-md-2 col-md-pull-10',
			],
			'sidebar_content'			=> [
				'content'			=> $config->get('content_class') . '  col-md-push-4',
				'sidebar'			=> $config->get('sidebar_class') . '  col-md-pull-8',
				'sidebar_secondary'	=> '',
			],
		];

		return $classes[ $site_layout ][ $type ];
	}
}

function content_item_type_experimental(): string {

	switch ( true ) {
		case is_static_front_page():
		case \is_singular():
			$content_itemType = 'https://schema.org/Article';
			break;
		case \is_home():
			$content_itemType = 'https://schema.org/WebSite';
			break;
		case \is_search():
			$content_itemType = 'https://schema.org/SearchResultsPage';
			break;
		default:
			$content_itemType = 'https://schema.org/CollectionPage';
			break;
	}

	return $content_itemType;
}

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
add_filter( 'embed_oembed_html', __NAMESPACE__ . '\embed_wrap', 10, 4 );
