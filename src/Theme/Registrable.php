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
	const REGISTER_CB = 'register';

	/**
	 * The register method is used to register theme things
	 * like sidebars, menus, image size and so on.
	 */
	public function register();
}
