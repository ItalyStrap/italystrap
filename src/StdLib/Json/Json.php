<?php

namespace ItalyStrap\StdLib\Json;

class Json {

	/**
	 * Encodes the given value into a JSON string.
	 *
	 * @param mixed $value
	 * @param int $option
	 * @param int $depth
	 *
	 * @return string
	 * @throws \JsonException
	 */
	public function encode( $value, int $option = null, int $depth = null ): string {
		return \Yiisoft\Json\Json::encode(...func_get_args());
	}

	/**
	 * Decodes the given JSON string into a PHP data structure.
	 *
	 * @param string $json
	 * @param bool $as_array
	 * @param int $depth
	 * @param int $option
	 *
	 * @throws \JsonException
	 */
	public function decode( string $json, bool $as_array = true, int $depth = null, int $option = null ) {
		return \Yiisoft\Json\Json::decode(...func_get_args());
	}
}
