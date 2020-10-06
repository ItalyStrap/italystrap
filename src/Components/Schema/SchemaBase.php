<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Schema;

/**
 * Schema_Base
 * @link https://schema.org/Article
 */
class SchemaBase {

	/**
	 * Number of total words in content
	 *
	 * @var int
	 */
	protected static $words_count;

	/**
	 * set_words_count
	 */
	protected function setWordsCount() {
		if ( empty( self::$words_count ) ) {
			self::$words_count = (int) str_word_count( get_the_content() );
		}
	}
}
