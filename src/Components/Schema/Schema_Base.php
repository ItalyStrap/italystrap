<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Schema;

/**
 * Schema_Base
 * @link https://schema.org/Article
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
