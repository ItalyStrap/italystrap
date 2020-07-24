<?php
/**
 * Example file
 *
 * Example on how to use Event Manager API
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 * @deprecated
 */

namespace ItalyStrap\Core\Example;

use ItalyStrap\Event\Manager as Event_Manager;

/**
 * Template object
 *
 * @var Template
 */
$template_settings = new Template( (array) $theme_mods );

$events = array(

	// 'italystrap_before_entry_content' => 'the_content',
	// 'italystrap_before_entry_content' => array( $template_settings, 'title' ),

	// $tag - event name
	// 'italystrap_before_entry_content'	=> array(
	// 	'function_to_add'	=> array( $template_settings, 'title' ),
	// 	// 'priority'			=> 10,
	// 	// 'accepted_args'		=> null,
	// ),
	'italystrap_after_entry_content'	=> array(
		array(
			'function_to_add'	=> array( $template_settings, 'title' ),
			'priority'			=> 10,
			'accepted_args'		=> null,
		),
		array(
			'function_to_add'	=> array( $template_settings, 'content' ),
			// 'priority'			=> 10,
			// 'accepted_args'		=> null,
		),
	),

);

$event_manager = new Event_Manager();
$event_manager->add_subscriber( $class );
$event_manager->remove_subscriber( $class );
$event_manager->hard_remove_subscriber( 'some_hook', 'some_method_name', 10 );
// $events = array(

// 	// 'italystrap_before_entry_content' => 'the_content',
// 	// 'italystrap_before_entry_content' => array( $template_settings, 'title' ),

// 	// $tag - event name
// 	// 'italystrap_before_entry_content'	=> array(
// 	// 	'function_to_add'	=> array( $template_settings, 'title' ),
// 	// 	// 'priority'			=> 10,
// 	// 	// 'accepted_args'		=> null,
// 	// ),
// 	'italystrap_after_entry_content'	=> array(
// 		array(
// 			'function_to_add'	=> array( $template_settings, 'title' ),
// 			// 'priority'			=> 10,
// 			// 'accepted_args'		=> null,
// 		),
// 		array(
// 			'function_to_add'	=> array( $template_settings, 'content' ),
// 			// 'priority'			=> 10,
// 			// 'accepted_args'		=> null,
// 		),
// 	),

// );

$events_manager = new Event_Manager();
// $events_manager->add_events( $events );

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Class description
 */
class ClassName extends AnotherClass implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'wp_footer' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_footer'	=> array(
				'function_to_add'	=> 'lazy_load_fonts',
				'priority'			=> 9999, // Optional
				'accepted_args'		=> null, // Optional
			),
		);
	}
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Class description
 */
class ClassName extends AnotherClass implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'wp_footer' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_footer'	=> 'lazy_load_fonts',
		);
	}
}

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Class description
 */
class ClassName extends AnotherClass implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'wp_footer' - 20
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'							=> 'method_name',
			'wp_footer'	=> array(
				'function_to_add'	=> 'lazy_load_fonts',
				'priority'			=> 9999, // Optional
				'accepted_args'		=> null, // Optional
			),
			'wp_footer'	=> 'lazy_load_fonts',
		);
	}
}
