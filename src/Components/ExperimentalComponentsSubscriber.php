<?php
declare(strict_types=1);

namespace ItalyStrap\Components;

use Auryn\Injector;
use ItalyStrap\Builders\BuilderInterface;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\VirtualProxyInterface;

class ExperimentalComponentsSubscriber implements SubscriberInterface {


	private FileInfoFactoryInterface $fileInfoFactory;
	private ConfigInterface $config;
	private SubscriberRegisterInterface $subscriberRegister;
	private iterable $components;
	private Injector $injector;

	public function getSubscribedEvents(): iterable {

		yield 'template_include'	=> [
			self::CALLBACK	=> 'exec',
			self::PRIORITY	=> PHP_INT_MAX - 100,
		];
	}

	public function destroy() {
		$this->subscriberRegister->removeSubscriber( $this );
	}

	public function __construct(
		Injector $injector,
		ConfigInterface $config,
		SubscriberRegisterInterface $eventManager,
		FileInfoFactoryInterface $fileInfoFactory,
		iterable $components
	) {
		$this->injector = $injector;
		$this->config = $config;
		$this->subscriberRegister = $eventManager;
		$this->fileInfoFactory = $fileInfoFactory;
		$this->components = $components;
	}

	public function exec( string $current_template = '' ): \SplFileInfo {

		$current_template = $this->fileInfoFactory->make( $current_template );

		$this->config->add(
			'current_template_file',
			$current_template->getBasename()
		);
		$this->config->add(
			'current_template_slug',
			$current_template->getBasename('.'.$current_template->getExtension())
		);

		$this->composeComponents();
		return $current_template;
	}

	private function composeComponents() {
		/** @var string|object $component */
		foreach ($this->components as $component) {
			/** @var SubscriberInterface|ComponentInterface $instance */
			$instance = $this->injector
				->share($component)
				->proxy($component, $this->proxyCallback())
				->make($component);

			if ( $this->shouldNotDisplay( $instance ) ) {
				continue;
			}

			$this->subscriberRegister->addSubscriber( $instance );
		}
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
