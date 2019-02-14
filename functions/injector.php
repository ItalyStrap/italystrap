<?php
/**
 * Get the Injector instance
 */

namespace ItalyStrap\Factory;

use Auryn\Injector;

function get_injector() {

	/**
	 * Injector from ACM if is active
	 */
	$injector = apply_filters( 'italystrap_injector', null );

	if ( ! isset( $injector ) ) {
		$injector = new Injector();
		add_filter( 'italystrap_injector', function () use ( $injector ) {
			return $injector;
		} );
	}

	return $injector;
}