<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 07/03/2019
 * Time: 21:48
 */

declare(strict_types=1);

namespace ItalyStrap\Builders;

use \ItalyStrap\Config\ConfigInterface as Config;

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
	 * @param Config|null $config
	 */
	public function __construct( Config $config = null ) {
		$this->config = $config;
	}

	/**
	 * @see \ItalyStrap\HTML\filter_attr()
	 */
	public function apply() {

		/**
		 * @var string|int|bool|array|callable $filter_attr
		 */
		foreach ( $this->config as $filter_name => $filter_attr ) {
			if ( \is_callable( $filter_attr ) ) {
				\add_filter( $filter_name, $filter_attr, 10, static::$accepted_args );
				continue;
			}

			if ( ! \is_array( $filter_attr ) ) {
				\add_filter( $filter_name, [ $this, 'parse_scalar' ], 10, static::$accepted_args );
				continue;
			}

			\add_filter( $filter_name, [ $this, 'parse_array' ], 10, static::$accepted_args );
		}
	}

	/**
	 * @param array $attr
	 * @return array
	 */
	public function parse_array( array $attr ) {
		return \array_merge( $attr, $this->config->get( \current_filter(), [] ) );
	}

	/**
	 * @param  string|int|bool $value
	 * @return string|int|bool
	 */
	public function parse_scalar( $value ) {
		return $this->config->get( \current_filter(), $value );
	}
}
