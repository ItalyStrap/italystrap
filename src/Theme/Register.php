<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\Manager;

class Register implements RegisterInterface
{
	/**
	 * @var array
	 */
	private $registrables = [];

	/**
	 * @var ConfigInterface
	 */
	private $config;

	/**
	 * @var Manager
	 */
	private $event;

	public function __construct( ConfigInterface $config, Manager $event ) {
		$this->config = $config;
		$this->event = $event;
	}

	/**
	 * @param Registrable ...$registrables
	 */
	public function withRegistrable( Registrable ...$registrables ) {
		$this->registrables = \array_merge( $this->registrables, $registrables );
	}

	/**
	 * @return array
	 */
	public function getRegistrables(): array {
		return $this->registrables;
	}

	public function boot() {
		foreach ( $this->registrables as $registrable ) {
			$this->event->add_subscriber( $registrable );
		}
	}
}