<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

trait UndefinedFunctionDefinitionTrait {

	private function postTypeSupports(
		string $post_type = 'post',
		$feature = '',
		bool $return = true
	) {
		$this->defineFunction(
			'post_type_supports',
			static fn(string $post_type, string $feature) => $return
		);
	}

	private function defineFunction( string $function, callable $callback) {
		\tad\FunctionMockerLe\define(...func_get_args());
	}
}
