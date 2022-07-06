<?php
declare(strict_types=1);

namespace ItalyStrap\Test\Components;

trait UndefinedFunctionDefinitionTrait {

	private function postTypeSupports(
		string $post_type = 'post',
		$feature = '',
		bool $return = true
	) {
		\tad\FunctionMockerLe\define(
			'post_type_supports',
			static function ( string $post_type, string $feature ) use ( $return ) {
				return $return;
			}
		);
	}
}
