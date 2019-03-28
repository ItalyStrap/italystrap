<?php
/**
 * Author_Info Controller API
 *
 * This class renders the Author_Info output on the registered position.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Controllers\Misc;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

use ItalyStrap\Controllers\Controller;
use ItalyStrap\Event\Subscriber_Interface;
use ItalyStrap\User\Contact_Method_List;

/**
 * The pagination controller class
 */
class Author_Info extends Controller implements Subscriber_Interface  {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_before_loop'			=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 20,
			),
			'italystrap_after_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 30,
			),
		);
	}

	/**
	 * File name for the view
	 *
	 * @var string
	 */
	protected $file_name = 'misc/author-info';

	/**
	 * Render the output of the controller.
	 */
	public function render() {

		global $author_name;
		$this->data['author'] = array_key_exists( 'author_name', $_GET )
			? get_user_by( 'slug', $author_name )
			: get_userdata( absint( get_the_author_meta( 'ID' ) ) );


		$this->data['contact'] = new Contact_Method_List();

		$method_name = current_filter() === 'italystrap_before_loop'
		? 'before_loop'
		: 'after_entry_content';

		if ( ! $this->$method_name() ) {
			return '';
		}

		return parent::render();
	}

	/**
	 * Render the output of the controller.
	 */
	protected function before_loop() {
		return (bool) 'author' !== CURRENT_TEMPLATE_SLUG;
	}

	/**
	 * Render the output of the controller.
	 */
	protected function after_entry_content() {

		/**
		 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
		 */
		if ( ! post_type_supports( get_post_type(), 'author' ) ) {
			return false;
		}

		if ( ! is_singular() ) {
			return false;
		}

		if ( in_array( 'hide_author', $this->get_template_settings(), true ) ) {
			return false;
		}

		return true;
	}
}
