<?php
/**
 * Word_Count API
 *
 * Class for the itemprop="wordCount" of schema.org
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Components\Schema;

use ItalyStrap\Event\Subscriber_Interface;

/**
 * Word_Count
 */
class Word_Count extends Schema_Base implements Subscriber_Interface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_after_entry_content' - 99
	 *
	 * @return array
	 */
	public static function get_subscribed_events() {

		/**
		 * Try 'the_content'
		 */
		return array(
			// 'hook_name'				=> 'method_name',
			'italystrap_after_entry_content'	=> array(
				'function_to_add'	=> 'render',
				'priority'			=> 99,
			),
		);
	}

	/**
	 * Render the output
	 *
	 * @param  string $value
	 * @return string
	 */
	public function render( $content = '' ) {

		if ( ! is_singular() ) {
			return $content;
		}

		$this->set_words_count();

		$meta = '';
	
		/**
		 * Display wordCount only in singular
		 */
		$meta .= sprintf(
			'<meta  itemprop="wordCount" content="%d"/>',
			self::$words_count
		);

		if ( ! empty( $content ) ) {
			return $content . $meta;
		}

		echo $meta;
	}
}
