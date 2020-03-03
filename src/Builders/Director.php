<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 12:39
 */

declare(strict_types=1);

namespace ItalyStrap\Builders;

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
	public function getSubscribedEvents(): array {
		return [
//			'wp'	=> 'createPage', // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
			'italystrap_build'	=> 'createPage', // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
//			'italystrap_theme_loaded'	=> 'apply', // @TODO is it a good hook? Or I have to create one just before the 'italystrap'
		];
	}

	/**
	 * @var Builder_Interface
	 */
	private $builder;

	/**
	 * @var Parse_Attr
	 */
	private $parse_Attr;

	/**
	 * Director constructor.
	 *
	 * @param Builder_Interface $builder
	 * @param SubscriberRegisterInterface $eventManager
	 */
	public function __construct( Builder_Interface $builder, SubscriberRegisterInterface $eventManager ) {
		$this->builder = $builder;
//		$this->parse_Attr = $parse_Attr;
		$this->eventManager = $eventManager;
	}

	/**
	 * Create the page
	 */
	public function createPage() {

		/**
		 * Injector setter is run on dependencies.php
		 */
		try {
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
