<?php
namespace ItalyStrap\Core;


use Auryn\Injector;

function injector_factory() {
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