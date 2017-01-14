<?php
/**
 * Event Manager API
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Event;

/**
 * Class description
 */
class Manager {

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	function add_event( $tag, $controller ) {

		/**
		 * 'function_name_callable'
		 * array( $object, 'method' )
		 */
		if ( is_callable( $controller ) ) {
			add_filter( $tag, $controller, 10, 1 );
			return;
		}

		add_filter(
			$tag,
			$controller['function_to_add'],
			isset( $controller['priority'] ) ? $controller['priority'] : 10,
			isset( $controller['accepted_args'] ) ? $controller['accepted_args'] : 1
		);
	}

	/**
	 * Add events
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function add_events( array $events ) {

		foreach ( $events as $tag => $controller ) {

			if ( is_array( $controller[0] ) ) {
				foreach ( $controller as $value ) {
					$this->add_event( $tag, $value );
				}
				continue;
			}

			$this->add_event( $tag, $controller );
		}
	}

	/**
	 * Add events
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function add_events_test( Subscriber_Interface $class ) {

		foreach ( $class::get_subscribed_hooks() as $tag => $controller ) {

			if ( is_string( $controller ) ) {
				$this->add_event( $tag, array( $class, $controller ) );
				continue;
			}

			if ( is_array( $controller ) ) {
				$controller['function_to_add'] = array( $class, $controller['function_to_add'] );
				// echo "<pre>";
				// print_r($controller['function_to_add'] = array( $class, $controller['function_to_add'] ) );
				// echo "</pre>";
				$this->add_event( $tag, $controller );
				// foreach ( $controller as $value ) {
					// $this->add_event( $tag, $value );
				// }
				continue;
			}
		}
	}
}
