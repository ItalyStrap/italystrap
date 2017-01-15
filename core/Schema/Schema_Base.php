<?php
/**
 * Schema_Base abstract API
 *
 * Class base for some schema.org itemprop
 *
 * @link http://schema.org/Article
 *
 * @link www.italystrap.com
 * @since 1.0.0
 * @since 2.1.0
 * @since 4.0.0 // OOP refactored
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Core\Schema;

/**
 * Schema_Base
 */
class Schema_Base {

	/**
	 * Number of total words in content
	 *
	 * @var int
	 */
	protected static $words_count;

	/**
	 * set_words_count
	 */
	protected function set_words_count() {
		if ( empty( self::$words_count ) ) {
			self::$words_count = (int) str_word_count( get_the_content() );
		}
	}
}
