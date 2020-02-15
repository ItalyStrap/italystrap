<?php
/**
 * A Subscriber knows what specific WordPress plugin API hooks it wants to register to.
 *
 * When an EventManager adds a Subscriber, it gets all the hooks that it wants to
 * register to. It then registers the subscriber as a callback with the WordPress
 * plugin API for each of them.
 *
 * @author Carl Alexander <contact@carlalexander.ca>
 */
declare(strict_types=1);

namespace ItalyStrap\Event;

interface Subscriber_Interface {
	/**
	 * Returns an array of events (hooks) that this subscriber wants to register with
	 * the Events Manager API.
	 *
	 * The array key is the name of the hook. The value can be:
	 *
	 *  * The method name
	 *  * An array with the method name and priority
	 *  * An array with the method name, priority and number of accepted arguments
	 *
	 * For instance:
	 *
	 * array(
	 *     // 'event_name'             => 'method_name',
	 *     'italystrap_before_header'  => 'render',
	 * )
	 * array(
	 *     // 'event_name'                     => 'method_name',
	 *     'italystrap_before_entry_content'   => array(
	 *         'function_to_add'   => 'render',
	 *         'priority'          => 30, // Default 10
	 *         'accepted_args'     => 1 // Default 1
	 *     ),
	 * );
	 *
	 * @return array
	 */
	public static function get_subscribed_events();
}
