<?php

use tad\FunctionMocker\FunctionMocker;

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

FunctionMocker::init([
	'blacklist' => dirname(__DIR__),
//	'cache-path' => dirname(__DIR__) . '/_output/patchwork-cache',
]);

/** Stubs */
class WP_Theme {
	public function display(string $header) {
		return $header;
	}
}


