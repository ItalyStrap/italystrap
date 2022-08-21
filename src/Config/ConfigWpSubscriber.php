<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Registrable;

final class ConfigWpSubscriber implements Registrable, SubscriberInterface {

	public const CURRENT_PAGE_ID = 'current_page_id';

	private ConfigInterface $config;
	private \WP_Query $query;

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'wp'	=> [
			self::CALLBACK	=> self::REGISTER_CB,
			self::PRIORITY	=> PHP_INT_MIN,
		];
	}

	/**
	 * Init sidebars registration
	 */
	public function __construct(
		ConfigInterface $config,
		\WP_Query $query
	) {
		$this->config = $config;
		$this->query = $query;
	}

	public function register(): void {
		$id = $this->query->get_queried_object_id();

		if ( is_singular() ) {
			$this->config->add(
				ConfigLayoutProvider::POST_CONTENT_TEMPLATE,
				(array) get_post_meta( $id, '_italystrap_template_settings', true )
			);
		} else {
			$this->config->add(
				ConfigLayoutProvider::POST_CONTENT_TEMPLATE,
				explode(
					',',
					is_array( $this->config->get( ConfigLayoutProvider::POST_CONTENT_TEMPLATE ) )
						? $this->config->get( ConfigLayoutProvider::POST_CONTENT_TEMPLATE )[0]
						: $this->config->get( ConfigLayoutProvider::POST_CONTENT_TEMPLATE )
				)
			);
		}

		/**
		 * If in page settings are set then override the global settings for the layout.
		 */
		if ( $page_layout = (string) get_post_meta( $id, '_italystrap_layout_settings', true ) ) {
			$this->config->add( ConfigLayoutProvider::SITE_LAYOUT, $page_layout );
		}

		/**
		 * If in page settings are set then override the global settings for the layout.
		 */
		if ( $container_width = (string) get_post_meta( $id, '_italystrap_width_settings', true ) ) {
			$this->config->add( ConfigLayoutProvider::CONTAINER_WIDTH, $container_width );
		}

		$array = [
			self::CURRENT_PAGE_ID => $id,
		];

		$this->config->merge($array);
	}
}
