<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 05/03/2019
 * Time: 07:57
 */

namespace ItalyStrap\Template;


class Finder implements Finder_Interface
{

	private $files = [];

	/**
	 * @todo Future implementation.
	 *
	 * @param $dirNameOrArrayOfDirName
	 *
	 * @return $this
	 */
//	private function in( $dirNameOrArrayOfDirName ) {
////		foreach ( (array) $dirNameOrArrayOfDirName as $dirName ) {
//////			d( $dirName );
////		}
//
//		return $this;
//	}

	/**
	 * Load a template part into a template
	 *
	 * Makes it easy for a theme to reuse sections of code in a easy to overload way
	 * for child themes.
	 *
	 * Includes the named template part for a theme or if a name is specified then a
	 * specialised part will be included. If the theme contains no {slug}.php file
	 * then no template will be included.
	 *
	 * The template is included using require, not require_once, so you may include the
	 * same template part multiple times.
	 *
	 * For the $name parameter, if the file is called "{slug}-special.php" then specify
	 * "special".
	 *
	 * @see get_template_part() - wp-includes/general-template.php
	 *
	 * @param string|array $slugs The slug name for the generic template.
	 *
	 * @return string            Return the file part rendered
	 */
	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH and wp-includes/theme-compat
	 * so that themes which inherit from a parent theme can just overload one file.
	 *
	 * @param string|array $slugs Template file(s) to search for, in order.
	 *
	 * @return string The template filename if one is located.
	 */
	public function getRealPath( $slugs ) {

		$slugs = (array) $slugs;

		/**
		 * Fires before the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, `$slug`, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 3.0.0
		 *
		 * @param string      $slug The slug name for the generic template.
		 * @param string      $name The name of the specialized template.
		 */
//		do_action( "italystrap_get_template_part_{$slugs[0]}", $slugs );

		$templates = [];

		if ( ! empty( $slugs[1] ) ) {
			$templates[] = "{$slugs[0]}-{$slugs[1]}.php";
		}

		$templates[] = "{$slugs[0]}.php";

		if ( ! $this->has( $templates ) ) {
			/**
			 * @todo Make exception also for $templates[1] if is not empty
			 */
			throw new \InvalidArgumentException( sprintf( 'The template %s does not exists', $templates[0] ) );
		}

		return locate_template( $templates, false, false );
	}

	/**
	 * Check if the template exists
	 *
	 * @param string|array $templates Template file(s) to search for, in order.
	 *
	 * @return bool                        Return true if template exists
	 */
	public function has( $templates ) {

//		$this->files[ $templates ] = locate_template( $templates, false, false );

		return (bool) locate_template( $templates, false, false );
	}
}