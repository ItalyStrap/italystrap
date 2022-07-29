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
	 * @throws \JsonException
	 */
	public function encode( $value, int $option, int $depth ): void {
		\Yiisoft\Json\Json::encode(...func_get_args());
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
	public function decode( string $json, bool $as_array, int $depth, int $option ): void {
		\Yiisoft\Json\Json::decode(...func_get_args());
	}
}
