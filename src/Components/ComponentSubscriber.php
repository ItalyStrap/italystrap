<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Extension;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\VirtualProxyInterface;

class ComponentSubscriber implements Extension {

	private EventDispatcherInterface $dispatcher;
	private SubscriberRegisterInterface $subscriberRegister;

	public function __construct(
		SubscriberRegisterInterface $subscriberRegister,
		EventDispatcherInterface $dispatcher
	) {
		$this->subscriberRegister = $subscriberRegister;
		$this->dispatcher = $dispatcher;
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
		$this->dispatcher->addListener(
			'template_include',
			function ( string $current_template = '' ) use ( $application ): string {
				$application->walk( $this->name(), [$this, 'walk'] );
				return $current_template;
			},
			PHP_INT_MAX - 5,
			3
		);
	}

	public function walk( string $class, $index_or_optionName, Injector $injector ) {
		/** @var SubscriberInterface|ComponentInterface $instance */
		$instance = $injector
			->share($class)
			->proxy($class, $this->proxyCallback())
			->make($class);

		if ( $this->shouldNotDisplay( $instance ) ) {
			return;
		}

		$this->subscriberRegister->addSubscriber( $instance );
	}

	private function shouldNotDisplay( ComponentInterface $instance ): bool {
		return ! $instance->shouldDisplay();
	}

	private function proxyCallback() {
		return static function ( string $className, callable $callback ): VirtualProxyInterface {
			return (new LazyLoadingValueHolderFactory)->createProxy(
				$className,
				static function (
					?object &$object,
					?object $proxy,
					string $method,
					array $parameters,
					?\Closure &$initializer
				) use ( $callback ) {
					$object = $callback();
					$initializer = null;
				}
			);
		};
	}
}
