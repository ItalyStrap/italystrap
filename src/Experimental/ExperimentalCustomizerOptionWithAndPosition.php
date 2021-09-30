<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

class ExperimentalCustomizerOptionWithAndPosition implements \ItalyStrap\Event\SubscriberInterface
{

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'italystrap_theme_positions' => 'register_theme_positions';

		/**
		 * This filter is deprecated. Use 'italystrap_theme_positions' instead.
		 */
		yield 'italystrap_widget_area_position' => 'register_theme_positions';

		yield 'italystrap_theme_width' => 'register_theme_width';
	}


	/**
	 * Register theme position
	 *
	 * @param  string $new_position The position registered.
	 * @return array                Array with theme position.
	 */
	public function register_theme_positions( array $new_position ) {

		return array_merge(
			\ItalyStrap\Config\get_config_file_content( 'theme-positions' ),
			$new_position
		);
	}

	/**
	 * Register theme width
	 *
	 * @param  string $position The position registered.
	 * @return array            Array with theme position.
	 */
	public function register_theme_width( array $new_width ) {

		$with = \ItalyStrap\Config\get_config_file_content( 'theme-width' );

		return array_merge( $with, $new_width );
	}
//\add_filter( 'italystrap_theme_width', __NAMESPACE__ . '\register_theme_width' );
}