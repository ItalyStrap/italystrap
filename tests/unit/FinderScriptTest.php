<?php

use ItalyStrap\View\Exceptions\ViewNotFoundException;

class FinderScriptTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;
	
	protected function _before() {
	}

	protected function _after() {
	}

	private function getInstance() {
		$sut = new ItalyStrap\Finder\Finder(
			new \ItalyStrap\Finder\FilesHierarchyIterator(
				new \ItalyStrap\Finder\FileInfoFactory()
			)
		);
		return $sut;
	}

	/**
	 * @test
	 */
	public function instanceOk() {
		$sut = $this->getInstance();
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
		codecept_debug(PHP_EOL);
		codecept_debug($file);
		codecept_debug(\file_get_contents($file->getRealPath()));
	}
}
