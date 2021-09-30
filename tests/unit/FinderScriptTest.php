<?php
declare(strict_types=1);

namespace ItalyStrap\Test;

use Codeception\Test\Unit;
use ItalyStrap\Finder\FileInfoFactory;
use ItalyStrap\Finder\FilesHierarchyIterator;
use ItalyStrap\Finder\Finder;
use ItalyStrap\Tests\InstantiableTrait;
use UnitTester;
use function codecept_data_dir;

class FinderScriptTest extends Unit {

	use InstantiableTrait;

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// phpcs:ignore
	protected function _before() {
	}

	// phpcs:ignore
	protected function _after() {
	}

	private function getInstance() {
		$sut = new Finder(
			new FilesHierarchyIterator(
				new FileInfoFactory()
			)
		);
		return $sut;
	}

	/**
	 * @test
	 */
	public function checkHierarchy() {
		$sut = $this->getInstance();
		$sut->in(
			[
				codecept_data_dir('fixtures/deprecated'),
				codecept_data_dir('fixtures/child-assets/src'),
				codecept_data_dir('fixtures/child-assets'),
				codecept_data_dir('fixtures/parent-assets/src'),
				codecept_data_dir('fixtures/parent-assets'),
			]
		);

		$file = $sut->firstFile(['old', 'min'], 'css');
		$file = $sut->firstFile(['style', 'min'], 'css');
//		codecept_debug(PHP_EOL);
//		codecept_debug($file);
//		codecept_debug(\file_get_contents($file->getRealPath()));
	}
}
