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
 */

namespace ItalyStrap\Core\Example;

use ItalyStrap\Core\Event\Manager as Event_Manager;

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
			// 'priority'			=> 10,
			// 'accepted_args'		=> null,
		),
		array(
			'function_to_add'	=> array( $template_settings, 'content' ),
			// 'priority'			=> 10,
			// 'accepted_args'		=> null,
		),
	),

);

$events_manager = new Event_Manager();
$events_manager->add_events( $events );
