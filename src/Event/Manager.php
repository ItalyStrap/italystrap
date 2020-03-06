<?php
declare(strict_types=1);

/**
 * Event Manager API
 *
 * [Long Description.]
 *
 * @link https://carlalexander.ca/design-system-wordpress-event-management/
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Event;

/**
 * Class description
 */
class Manager {

	const CALLBACK = 'function_to_add';
	const PRIORITY = 'priority';
	const ACCEPTED_ARGS = 'accepted_args';

	/**
	 * Adds an event subscriber.
	 *
	 * The event manager adds the given subscriber to the list of event listeners
	 * for all the events that it wants to listen to.
	 *
	 * @param Subscriber_Interface $subscriber
	 */
	public function add_subscriber( Subscriber_Interface $subscriber ) {
		foreach ( $subscriber->get_subscribed_events() as $event_name => $parameters ) {
			$this->add_subscriber_listener( $subscriber, $event_name, $parameters );
		}
	}
 
	/**
	 * Adds the given subscriber listener to the list of event listeners
	 * that listen to the given event.
	 *
	 * @param Subscriber_Interface $subscriber
	 * @param string               $event_name
	 * @param mixed                $parameters
	 */
	private function add_subscriber_listener( Subscriber_Interface $subscriber, $event_name, $parameters ) {
		if ( \is_string( $parameters ) ) {
			$this->add_listener( $event_name, array( $subscriber, $parameters ) );
		} elseif ( \is_array( $parameters ) && isset( $parameters['function_to_add'] ) ) {
			$this->add_listener(
				$event_name,
				array( $subscriber, $parameters['function_to_add'] ),
				isset( $parameters['priority'] ) ? $parameters['priority'] : 10,
				isset( $parameters['accepted_args'] ) ? $parameters['accepted_args'] : 1
			);
		}
	}
 
	/**
	 * Adds the given event listener to the list of event listeners
	 * that listen to the given event.
	 *
	 * @param string   $event_name
	 * @param callable $listener
	 * @param int      $priority
	 * @param int      $accepted_args
	 */
	public function add_listener( $event_name, $listener, $priority = 10, $accepted_args = 1 ) {
		\add_filter( $event_name, $listener, $priority, $accepted_args );
	}
 
	/**
	 * Hard removing a method registerd by an anonimous object.
	 *
	 * From an idea of Tonia Mork of KnowTheCode
	 * @link https://knowthecode.io/
	 *
	 * @example
	 * $event_manager->hard_remove_subscriber( 'wp', 'schedule_events', 10 );
	 *
	 * @param  string $event_name    The event name.
	 * @param  string $method_name   The method name callback to remove.
	 * @param  int    $priority      The priority of the callback.
	 * @param  int    $accepted_args The number of the accepted args.
	 */
	public function hard_remove_subscriber( $event_name, $method_name, $priority, $accepted_args = null ) {

		global $wp_filter;

		if ( ! isset( $wp_filter[ $event_name ][ $priority ] ) ) {
			return;
		}

		foreach ( (array) $wp_filter[ $event_name ][ $priority ] as $method_name_regstered => $value ) {
			if ( \strpos( $method_name_regstered, $method_name ) !== false ) {
				\remove_filter( $event_name, $method_name_regstered, $priority );
			}
		}
	}
 
	/**
	 * Removes an event subscriber.
	 *
	 * The event manager removes the given subscriber from the list of event listeners
	 * for all the events that it wants to listen to.
	 *
	 * @param Subscriber_Interface $subscriber
	 */
	public function remove_subscriber( Subscriber_Interface $subscriber ) {
		foreach ( $subscriber->get_subscribed_events() as $event_name => $parameters ) {
			$this->remove_subscriber_listener( $subscriber, $event_name, $parameters );
		}
	}
 
	/**
	 * Adds the given subscriber listener to the list of event listeners
	 * that listen to the given event.
	 *
	 * @param Subscriber_Interface $subscriber
	 * @param string               $event_name
	 * @param mixed                $parameters
	 */
	private function remove_subscriber_listener( Subscriber_Interface $subscriber, $event_name, $parameters ) {
		if ( \is_string( $parameters ) ) {
			$this->remove_listener( $event_name, array( $subscriber, $parameters ) );
		} elseif ( \is_array( $parameters ) && isset( $parameters['function_to_add'] ) ) {
			$this->remove_listener(
				$event_name,
				array( $subscriber, $parameters['function_to_add'] ),
				isset( $parameters['priority'] ) ? $parameters['priority'] : 10
			);
		}
	}
 
	/**
	 * Removes the given event listener from the list of event listeners
	 * that listen to the given event.
	 *
	 * @param string   $event_name
	 * @param callable $listener
	 * @param int      $priority
	 */
	public function remove_listener( $event_name, $listener, $priority = 10 ) {
		\remove_filter( $event_name, $listener, $priority );
		// $this->plugin_api_manager->remove_callback( $event_name, $listener, $priority );
	}
}
