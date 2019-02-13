<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 13/02/2019
 * Time: 21:07
 */

namespace ItalyStrap;
use Auryn\Injector;

interface Loadable_Test_Interface {

	/**
	 * @param Injector $injector
	 * @return mixed
	 */
	public function load( Injector $injector );
}