<?php
declare(strict_types=1);

namespace ItalyStrap\Builders;

use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Event\SubscriberInterface;
use function ItalyStrap\Core\set_current_template_constants;

class Director implements SubscriberInterface {
	/**
	 * @var SubscriberRegisterInterface
	 */
	private $subscriber_register;

	/**
	 * @return array
	 */
	public function getSubscribedEvents(): iterable {

			yield 'template_include'	=> [
				self::CALLBACK	=> 'createPage',
				self::PRIORITY	=> PHP_INT_MAX - 100,
			];
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
	 */
	public function __construct(
		BuilderInterface $builder,
		SubscriberRegisterInterface $eventManager
		//		ParseAttr $parse_Attr
	) {
		$this->builder = $builder;
		$this->subscriber_register = $eventManager;
//		$this->parse_Attr = $parse_Attr;
	}

	/**
	 * Create the page
	 * @param string $current_template
	 * @return string
	 */
	public function createPage( string $current_template = '' ): string {

		/**
		 * ========================================================================
		 *
		 * Define CURRENT_TEMPLATE and CURRENT_TEMPLATE_SLUG constant.
		 *
		 * @see \ItalyStrap\Core\set_current_template_constants()
		 *
		 * ========================================================================
		 */
		set_current_template_constants($current_template);

		/**
		 * Injector setter is run on dependencies.php
		 */
		try {
			$this->builder->build();
		} catch ( \Exception $e ) {
			echo $e->getMessage();
		}

		return $current_template;
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
		$this->subscriber_register->removeSubscriber( $this );
	}
}
