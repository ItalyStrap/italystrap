<?php
declare(strict_types=1);

use Auryn\InjectorException;
use ItalyStrap\Builders\ParseAttr;
use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcher;
use function ItalyStrap\Config\get_config_file_content;
use function ItalyStrap\Factory\injector;

return function ( EventDispatcher $dispatcher, ConfigInterface $config ): void {

	/**
	 * Load at 'wp' hook to make sure get_queried_object_id() returns the current page ID
	 * 'wp_loaded' is too early
	 *
	 * @priority PHP_INT_MIN Make sure it will be loaded ASAP at 'wp' hook
	 */
	$dispatcher->addListener(
		'wp',
		function () use ( $config ) {

			$id = get_queried_object_id();

			/**
			 * Front page ID get_option( 'page_on_front' ); PAGE_ON_FRONT
			 * Home page ID get_option( 'page_for_posts' ); PAGE_FOR_POSTS
			 * get_queried_object_id() before $post is set
			 */
			$config->add( 'current_page_id', $id );

			/**
			 * If we are in singular page then load the template settings from post_meta
			 * If we are not in singular pages load the global post_content_template
			 * @TODO Forse qui è meglio settare i valori con l'hook "italystrap" nel file
			 * 		di template per avere la possibilità di poter cambiare il valore in esecuzione
			 */
			if ( is_singular() ) {
				$config->add(
					'post_content_template',
					(array) get_post_meta( $id, '_italystrap_template_settings', true )
				);
			} else {
				$config->add(
					'post_content_template',
					explode(
						',',
						is_array( $config->get( 'post_content_template' ) )
							? $config->get( 'post_content_template' )[0]
							: $config->get( 'post_content_template' )
					)
				);
			}

			/**
			 * If in page settings are set then override the global settings for the layout.
			 */
			if ( $page_layout = (string) get_post_meta( $id, '_italystrap_layout_settings', true ) ) {
				$config->add( 'site_layout', $page_layout );
			}

			/**
			 * If in page settings are set then override the global settings for the layout.
			 */
			if ( $container_width = (string) get_post_meta( $id, '_italystrap_width_settings', true ) ) {
				$config->add( 'container_width', $container_width );
			}

		//	$config->add( 'site_layout',
		//		(string) apply_filters( 'italystrap_get_layout_settings', $config->get( 'site_layout', 'content_sidebar' ) )
		//	);
		},
		PHP_INT_MIN
	);

	/**
	 * Questo va eseguito prima della registrazione delle sidebar
	 * se no non si può filtrare l'html dei widget
	 *
	 * @see \ItalyStrap\Builders\ParseAttr
	 */
	$dispatcher->addListener(
		'widgets_init',
		function () {
			try {
				$schema = get_config_file_content( 'schema' );
				$html_attrs = get_config_file_content( 'html_attrs' );

				$config = ConfigFactory::make( (array) array_replace_recursive( $schema, $html_attrs ) );

				$parser =  injector()->make(
					ParseAttr::class,
					[ ':config' => $config ]
				);

				$parser->apply();
			} catch ( InjectorException $exception ) {
				echo $exception->getMessage();
			}
		},
		-10
	);
};
