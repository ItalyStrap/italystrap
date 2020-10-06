<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Schema;

use ItalyStrap\Event\SubscriberInterface;

/**
 * Class for the itemprop="timeRequired" of schema.org
 */
class TimeRequired extends SchemaBase implements SubscriberInterface {

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

		$this->setWordsCount();

		$meta = '';

		/**
		 * Number of total words in content
		 *
		 * @var integer
		 */
		$word_count = self::$words_count;

		/**
		 * Number of words per minute
		 *
		 * @var integer
		 */
		$words_per_minute = 150;

		/**
		 * Get Estimated time to read
		 */
		$minutes = floor( $word_count / $words_per_minute );
		$seconds = floor( ( $word_count / ( $words_per_minute / 60 ) ) - ( $minutes * 60 ) );

		$estimated_time = '';

		/**
		 * If less than a minute
		 */
		if ( $minutes < 1 ) {
			$estimated_time = 'PT1M';
		}

		/**
		 * If more than a minute
		 */
		if ( $minutes >= 1 ) {
			if ( $seconds > 0 ) {
				$estimated_time = 'PT' . $minutes . 'M' . $seconds . 'S';
			}
		} else {
			$estimated_time = 'PT' . $minutes . 'M';
		}

		$meta .= sprintf(
			'<meta  itemprop="timeRequired" content="%s"/>',
			$estimated_time
		);

		if ( ! empty( $content ) ) {
			return $content . $meta;
		}

		echo $meta;
		return '';
	}
}
