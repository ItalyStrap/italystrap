<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 07/03/2019
 * Time: 21:48
 */

namespace ItalyStrap\HTML;


class Parse_Attr {

	const ACCEPTED_ARGS = 3;

	/**
	 * Default accepted args.
	 *
	 * @var int
	 */
	public static $accepted_args = self::ACCEPTED_ARGS;

	private $config;

	/**
	 * Parse_Attr constructor.
	 * @param \ItalyStrap\Config\Config_Interface|null $config
	 */
	public function __construct( \ItalyStrap\Config\Config_Interface $config = null ) {
		$this->config = $config;
	}

	/**
	 *
	 */
	public function apply() {

		/**
		 * @var string|int|bool|array|callable $filter_attr
		 */
		foreach ( $this->config as $filter_name => $filter_attr ) {

			if ( is_callable( $filter_attr ) ) {
				add_filter( $filter_name, $filter_attr, 10, static::$accepted_args );
				continue;
			}

			if ( ! is_array( $filter_attr ) ) {
				add_filter( $filter_name, [ $this, 'parse_scalar' ], 10, static::$accepted_args );
				continue;
			}

			add_filter( $filter_name, [ $this, 'parse_array' ], 10, static::$accepted_args );
		}
	}

	/**
	 * @param array $attr
	 * @return array
	 */
	public function parse_array( array $attr ) {
		return array_merge( $attr, $this->config->get( current_filter() ) );
	}

	/**
	 * @param array $attr
	 * @return array
	 */
	public function parse_scalar( $value ) {

		if ( null === $new_val = $this->config->get( current_filter() ) ) {
			return $value;
		}

		return $new_val;
	}

	/**
	 * @param array $attr
	 * @return string
	 */
	private function prepend_append_string( $prepended = '', $appended = '' ) {
		return (string) $prepended . $appended;
	}
}