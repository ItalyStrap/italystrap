<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 17/04/2019
 * Time: 08:46
 */

namespace ItalyStrap\Theme;

interface Registrable {

	/**
	 * Method name for filter callback
	 */
	const CALLBACK = 'register';

	/**
	 * The class that implements this can be registered
	 */
	public function register();
}
