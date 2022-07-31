<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Injector;

class ConfigProviderExtension implements \ItalyStrap\Empress\Extension {

	/**
	 * @var ConfigInterface
	 */
	private ConfigInterface $config;

	/**
	 * @param ConfigInterface $config
	 */
	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	/**
	 * @inheritDoc
	 */
	public function name(): string {
		return self::class;
	}

	/**
	 * @inheritDoc
	 */
	public function execute(AurynConfigInterface $application) {
		$application->walk( self::class, [$this, 'walk'] );
	}

	public function walk( string $class, $index_or_optionName, Injector $injector ): void {
		$config_object = $injector->share($class)->make($class);
		if (\is_callable( $config_object )) {
			$this->config->merge( $injector->execute( $config_object ) );
		}
	}
}
