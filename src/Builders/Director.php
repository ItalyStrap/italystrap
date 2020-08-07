<?php
declare(strict_types=1);

namespace ItalyStrap\Builders;

use Auryn\Injector;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Event\SubscriberInterface;

class Director implements SubscriberInterface {
	/**
	 * @var SubscriberRegisterInterface
	 */
	private $eventManager;

	/**
	 * @return array
	 */
	public function getSubscribedEvents(): iterable {

//			yield 'wp'	=> 'createPage'; // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
			yield 'italystrap_build'	=> 'createPage'; // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
//			yield 'italystrap_theme_loaded'	=> 'apply'; // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
//			yield 'italystrap_theme_will_load'	=> 'apply'; // @TODO is it a good hook? Or I have to create one just before the 'italystrap'

	}

	/**
	 * @var BuilderInterface
	 */
	private $builder;

	/**
	 * @var ParseAttr
	 */
	private $parse_Attr;

	/**
	 * Director constructor.
	 *
	 * @param BuilderInterface $builder
	 * @param SubscriberRegisterInterface $eventManager
	 * @param Injector $injector
	 */
	public function __construct(
		BuilderInterface $builder,
		SubscriberRegisterInterface $eventManager
//		ParseAttr $parse_Attr
	) {
		$this->builder = $builder;
		$this->eventManager = $eventManager;
//		$this->parse_Attr = $parse_Attr;
	}

	/**
	 * Create the page
	 */
	public function createPage() {

		/**
		 * Injector setter is run on dependencies.php
		 */
		try {
//			$this->parse_Attr->apply();
			$this->builder->build();
		} catch ( \Exception $e ) {
			echo $e->getMessage();
		}
	}

	/**
	 * Filter elements attr
	 */
//	public function apply() {
//		$this->parse_Attr->apply();
//	}

	/**
	 * Remove from hooks
	 */
	public function destroy() {
		$this->eventManager->removeSubscriber( $this );
	}
}
