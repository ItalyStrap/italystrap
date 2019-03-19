<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 15:20
 */

namespace ItalyStrap\Builders;


class Builder implements Builder_Interface, \ItalyStrap\Event\Subscriber_Interface
{

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
	public static function get_subscribed_events() {
		return [
			static::$hook => [
				'function_to_add'	=> 'output',
				'priority'			=> static::$priority,
			],
		];
	}

	public static $hook = '';
	public static $priority = 10;

	protected $output = '';

	protected function should_show() {
		return true;
	}

	/**
	 * @param $content
	 */
	protected function set_output( $output = '' ) {
		$this->output = $output;
	}

	/**
	 * @return string
	 */
	protected function get_output() {

		if ( ! $this->should_show() ) {
			return '';
		}

		return $this->output;
	}

	public function output() {
		echo $this->get_output();
	}
}