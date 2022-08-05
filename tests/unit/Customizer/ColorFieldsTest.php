<?php
declare(strict_types=1);

namespace ItalyStrap\Tests\Customizer;

use ItalyStrap\Config\ConfigColorSectionProvider;
use ItalyStrap\Customizer\ColorFields;
use ItalyStrap\Tests\BaseUnitTrait;
use Prophecy\Argument;

class ColorFieldsTest extends \Codeception\Test\Unit {

	use BaseUnitTrait;

	protected function getInstance() {
		$sut = new \stdClass();
//		$this->assertInstanceOf(Extension::class, $sut, '');
		return $sut;
	}

//	protected function getInstance(): ColorFields {
//		$sut = new ColorFields(
//			$this->getWPCustomizeManager(),
//			$this->getConfig(),
//			$this->getFieldControlFactory()
//		);
////		$this->assertInstanceOf(Extension::class, $sut, '');
//		return $sut;
//	}

	/**
	 *
	 */
	public function itShouldInvoke() {
		$sut = $this->getInstance();

		$this->manager->get_setting( Argument::type('string') )->willReturn(new \stdClass());
		$this->manager->get_section( Argument::type('string') )->willReturn(new \stdClass());

		$this->manager->add_setting(Argument::type('string'), Argument::type('array'));

//		$this->control->make(
//			Argument::type('string'),
//			$this->getWPCustomizeManager(),
//			Argument::type('string'),
//			Argument::type('array')
//		);

		$sut();
	}
}
