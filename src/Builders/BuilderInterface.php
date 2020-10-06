<?php
declare(strict_types=1);

namespace ItalyStrap\Builders;

interface BuilderInterface {

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function setInjector( \Auryn\Injector $injector );

	/**
	 * Build the page
	 *
	 * @throws \Exception
	 */
	public function build();
}
