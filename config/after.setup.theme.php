<?php
declare(strict_types=1);

use Auryn\Injector;
use ItalyStrap\Event\EventDispatcher;

return static function ( Injector $injector, EventDispatcher $event_dispatcher): void {

	/**
	 * ========================================================================
	 *
	 * This will load the framework after setup theme
	 *
	 * ========================================================================
	 */
	$event_dispatcher->addListener( 'after_setup_theme', static function () use ( $injector, $event_dispatcher ) {

		/**
		 * Fires before ItalyStrap theme load.
		 *
		 * @since 4.0.0
		 */
		$event_dispatcher->dispatch( 'italystrap_theme_will_load', $injector );

		/**
		 * Fires once ItalyStrap theme is loading.
		 *
		 * @since 4.0.0
		 */
		$event_dispatcher->dispatch( 'italystrap_theme_load', $injector );

		/**
		 * Fires once ItalyStrap theme has loaded.
		 *
		 * @since 4.0.0
		 */
		$event_dispatcher->dispatch( 'italystrap_theme_loaded', $injector );
	}, 20 );
};
