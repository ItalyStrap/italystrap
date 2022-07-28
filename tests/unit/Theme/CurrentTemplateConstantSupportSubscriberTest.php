<?php
declare(strict_types=1);

namespace ItalyStrap\Test\Theme;

use Codeception\Test\Unit;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Tests\BaseUnitTrait;
use ItalyStrap\Theme\CurrentTemplateConstantSupportSubscriber;
use ItalyStrap\Theme\Registrable;
use PHPUnit\Framework\Assert;
use Prophecy\Argument;

class CurrentTemplateConstantSupportSubscriberTest extends Unit {
	use BaseUnitTrait;

	protected function getInstance(): CurrentTemplateConstantSupportSubscriber {
		$sut = new CurrentTemplateConstantSupportSubscriber($this->getConfig(), $this->getFileInfoFactory());
		$this->assertInstanceOf(SubscriberInterface::class, $sut, '');
		$this->assertInstanceOf(Registrable::class, $sut, '');
		return $sut;
	}

	/**
	 * @test
	 */
	public function itShouldRegister() {
		$sut = $this->getInstance();

		$current_template = 'Current template';

		$file_info = $this->prophet->prophesize(\SplFileObject::class);

		$file_info->getBasename()->willReturn('index.php');
		$file_info->getExtension()->willReturn('php');

		$file_info->getBasename( Argument::type('string') )->willReturn('index');
		$file_info->__toString()->willReturn($current_template);


		$this->fileInfoFactory->make( $current_template )->willReturn($file_info->reveal());

		$this->config->add(
			'current_template_file',
			'index.php'
		)->shouldbeCalled();


		$this->config->add(
			'current_template_slug',
			'index'
		)->shouldbeCalled();

		$this->assertSame($current_template, $sut->register( $current_template ), '');
	}
}
