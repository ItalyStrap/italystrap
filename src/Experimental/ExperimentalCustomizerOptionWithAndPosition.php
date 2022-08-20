<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Event\SubscriberInterface;

class ExperimentalCustomizerOptionWithAndPosition implements SubscriberInterface {

	/**
	 * @inheritDoc
	 */
	public function getSubscribedEvents(): iterable {
		yield 'italystrap_theme_positions' => 'registerThemePositions';

		/**
		 * This filter is deprecated. Use 'italystrap_theme_positions' instead.
		 */
		yield 'italystrap_widget_area_position' => 'registerThemePositions';

		yield 'italystrap_theme_width' => 'registerThemeWidth';
	}


	/**
	 * Register theme position
	 *
	 * @param array $new_position
	 *
	 * @return array                Array with theme position.
	 */
	public function registerThemePositions( array $new_position ): array {
		return array_merge(
			[
				'italystrap_before'			=> \__( 'After the <code>&lt;/body&gt;</code>', 'italystrap' ),

				'italystrap_before_header'	=> \__( 'Before the header', 'italystrap' ),
				'italystrap_content_header'	=> \__( 'The content header', 'italystrap' ),
				'italystrap_after_header'	=> \__( 'After the header', 'italystrap' ),

				'italystrap_before_main'	=> \__( 'Before the Main Content', 'italystrap' ),
				'italystrap_before_content'	=> \__( 'Before the Content', 'italystrap' ),

				'italystrap_before_loop'	=> \__( 'Before the Loop', 'italystrap' ),
				'italystrap_loop'			=> \__( 'The Loop', 'italystrap' ),
				'italystrap_after_loop'		=> \__( 'After the Loop', 'italystrap' ),

				'italystrap_after_content'	=> \__( 'After the Content', 'italystrap' ),

				'italystrap_after_main'		=> \__( 'After the Main Content', 'italystrap' ),
				'italystrap_before_footer'	=> \__( 'In the footer open', 'italystrap' ),
				'italystrap_footer'			=> \__( 'In the footer', 'italystrap' ),
				'italystrap_after_footer'	=> \__( 'In the footer closed', 'italystrap' ),

				// phpcs:disable
				'italystrap_after'			=> \__( 'At the end of the page before the <code>&lt;/body&gt;</code>', 'italystrap' ),
				// phpcs:enable
			],
			$new_position
		);
	}

	/**
	 * Register theme width
	 *
	 * @param array $new_width
	 * @return array            Array with theme position.
	 */
	public function registerThemeWidth( array $new_width ): array {

		$site_width = \apply_filters(
			'italystrap_theme_width_settings',
			[
				//		'none'				=> \__( 'None', 'italystrap' ),
				'container'			=> \__( 'Standard container (deprecated)', 'italystrap' ),
				'container-fluid'	=> \__( 'Fluid container (deprecated)', 'italystrap' ),
			]
		);

		return array_merge( $site_width, $new_width );
	}
}
