<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Schema;

use ItalyStrap\Event\SubscriberInterface;

/**
 * Class for the itemprop="wordCount" of schema.org
 */
class WordCount extends SchemaBase implements SubscriberInterface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked 'italystrap_after_entry_content' - 99
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

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

		$this->setWordsCount();

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
