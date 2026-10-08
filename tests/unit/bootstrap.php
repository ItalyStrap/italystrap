<?php
// phpcs:ignoreFile
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';


/** Stubs */
class WP_Theme {
	public function display(string $header) {
		return $header;
	}
}

if ( ! \class_exists( 'WP_Customize_Manager' ) ) {
	class WP_Customize_Manager {
		public function get_setting(string $string) {
			return new \stdClass();
		}
		public function get_section(string $string) {
			return new \stdClass();
		}
		public function add_setting(string $string, array $array) {
			return $this;
		}
	}
}

if ( ! \class_exists( 'WP_Block' ) ) {
	class WP_Block {
		public $name;
		public $context = [];
	}
}
