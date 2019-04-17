<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 12/04/2019
 * Time: 14:24
 */

namespace ItalyStrap\HTML;

use function ItalyStrap\HTML\get_attr;

class Attributes
{
	private $attributes = [];

	/**
	 * @param string $context
	 * @param array $attr
	 * @return $this
	 */
	public function add_attr( string $context, array $attr ) {
		$this->attributes[ $context ] = $attr;
		return $this;
 	}

	/**
	 * @param string $context
	 * @return mixed
	 */
	public function get_attr( string $context ) {
		return $this->attributes[ $context ];
 	}

	/**
	 * @param string $context
	 * @return bool
	 */
	public function has_attr( string $context ) : bool {
		return array_key_exists( $context, $this->attributes );
 	}

	/**
	 * @param string $context
	 * @return self
	 */
	public function remove_attr( string $context ) {
		unset( $this->attributes[ $context ] );
		return $this;
 	}

	/**
	 * @todo Da finire di sviluppare
	 *
	 * @param string $context
	 * @return string
	 */
	public function render( string $context ) : string {
		$output = get_attr( $context, $this->get_attr( $context ) );
		$this->remove_attr( $context );
		return $output;
 	}

	/**
	 * @return array
	 */
	public function getAttributes(): array {
		return $this->attributes;
	}
}