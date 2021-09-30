<?php
declare(strict_types=1);

namespace ItalyStrap\Tests;

trait InstantiableTrait {

	abstract protected function getInstance();

	/**
	 * @test
	 */
	public function itShouldBeInstantiable() {
		$this->getInstance();
	}
}