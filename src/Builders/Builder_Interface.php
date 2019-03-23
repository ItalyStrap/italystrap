<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 18/03/2019
 * Time: 15:14
 */

namespace ItalyStrap\Builders;


interface Builder_Interface {

	/**
	 * @param \Auryn\Injector $injector
	 * @return Builder
	 */
	public function set_injector( \Auryn\Injector $injector );

	/**
	 * @param array $structure
	 * @return Builder
	 */
	public function set_structure( array $structure );

	/**
	 * Build the page
	 *
	 * @throws \Exception
	 */
	public function build();
}