<?php
/**
 * Form_Field Template API
 *
 * This file add a Form_Field suport for the theme
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\WooCommerce;

use ItalyStrap\Events\Subscriber_Interface;

/**
 * Form_Field
 */
class Form_Field implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'woocommerce_sidebar' - 10
	 *
	 * @return array
	 */
	public static function get_subscribed_hooks() {

		return array(
			// 'hook_name'				=> 'method_name',
			'woocommerce_form_field_args'	=> array(
				'function_to_add'	=> 'add_new_css_class_to_form_fields',
				'accepted_args'		=> 3,
			),
		);
	}

	/**
	 * Function description
	 *
	 * @param mixed  $args  Form elements arguments.
	 * @param string $key   Form elements key for ID attribute.
	 * @param string $value The value of the form elements (default: null).
	 *
	 * @return $args        Form elements arguments.
	 */
	public function add_new_css_class_to_form_fields( array $args, $key, $value ) {

		$args['class'][] = 'form-group';
		$args['input_class'][] = 'form-control';

		return $args;

	}
}
