<?php
// phpcs:ignoreFile
declare(strict_types=1);

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

//if ( ! \class_exists( 'WP_Customize_Manager' ) ) {
//	class WP_Customize_Manager {
//		public function get_setting(string $string) {
//			return new \stdClass();
//		}
//		public function get_section(string $string) {
//			return new \stdClass();
//		}
//		public function add_setting(string $string, array $array) {
//			return $this;
//		}
//	}
//}
