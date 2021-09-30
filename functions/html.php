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
