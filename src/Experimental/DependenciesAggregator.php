<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscribersConfigExtension;
use ItalyStrap\Finder\FinderFactory;
use function ItalyStrap\Config\get_config_file_content;

final class DependenciesAggregator {

	/**
	 * @var array|iterable
	 */
	private iterable $config;

	public function __construct( iterable $dependencies_provider = [] ) {
		$this->config = $dependencies_provider;
	}

	public function __invoke(): array {
		$experimental_file = $this->config[0];

		$config_file_content = [];
		foreach ( $experimental_file() as $item ) {
			$config_file_content = array_replace_recursive(
				$config_file_content,
				$item
			);
		}

		/**
		 * removes all NULL, FALSE and Empty Strings but leaves 0 (zero) values
		 * https://php.net/manual/en/function.array-filter.php#111091
		 */
		return array_filter( $config_file_content, fn( $val ) => ! is_null( $val ) );
	}
}
