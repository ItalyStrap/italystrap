<?php
declare(strict_types=1);
namespace ItalyStrap\Event;

use Auryn\ConfigException;
use Auryn\InjectionException;

use function \ItalyStrap\Factory\injector;
use function \ItalyStrap\Factory\get_event_manager;

if ( ! function_exists( '\ItalyStrap\Event\add_subscriber' ) ) {

	function add_subscriber( $name, array $args = [] ) {

		try {
			get_event_manager()->add_subscriber(
				injector()
					->share( $name )
					->make( $name, $args )
			);
		} catch ( ConfigException $configException ) {
			echo $configException->getMessage();
		} catch ( InjectionException $injectionException ) {
			echo $injectionException->getMessage();
		} catch ( \Exception $exception ) {
			echo $exception->getMessage();
		}
	}
}

if ( ! function_exists( '\ItalyStrap\Event\remove_subscriber' ) ) {

	function remove_subscriber( $name ) {

		try {
			get_event_manager()->remove_subscriber(
				injector()
					->share( $name )
					->make( $name )
			);
		} catch ( ConfigException $configException ) {
			echo $configException->getMessage();
		} catch ( InjectionException $injectionException ) {
			echo $injectionException->getMessage();
		} catch ( \Exception $exception ) {
			echo $exception->getMessage();
		}
	}
}