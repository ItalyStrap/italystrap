<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 05/03/2019
 * Time: 07:57
 */
declare(strict_types=1);

namespace ItalyStrap\View;

use ItalyStrap\View\Exceptions\TemplateNotFoundException;
use mysql_xdevapi\Exception;

class Finder implements Finder_Interface, \Countable {

	/**
	 * @var string
	 */
	private $dir_name = '';

	/**
	 * @var array
	 */
	private $files = [];

	/**
	 * @todo Future implementation.
	 *
	 * @param $dir_name
	 *
	 * @return $this
	 */
	public function in( $dir_name ) {
		$this->dir_name = $dir_name;
		return $this;
	}

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
	 * @return string Return the full path of the template filename if one is located.
	 */
	public function getRealPath( $slugs ) : string {

		$slugs = (array) $slugs;

		if ( $this->dir_name ) {
			$slugs[0] = $this->dir_name . DIRECTORY_SEPARATOR . $slugs[0];
		}

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
		\do_action( "italystrap_get_template_part_{$slugs[0]}", $slugs );

		$templates = [];

		if ( ! empty( $slugs[1] ) ) {
			$templates[] = "{$slugs[0]}-{$slugs[1]}.php";
		}

		$templates[] = "{$slugs[0]}.php";

		return $this->get( $templates );
	}

	/**
	 * Check if the template exists
	 *
	 * @param array $templates Template file(s) to search for, in order.
	 *
	 * @return bool            Return true if template exists
	 */
	private function has( array $templates ) : bool {

		if ( empty( $this->files[ $templates[0] ] ) ) {
			$this->files[ $templates[0] ] = \locate_template( $templates, false, false );
		}

		/**
		 * @todo Add some logic to load template from plugin in case the class is imported in that context
		 * @see \WC_Template_Loader::template_loader() in WooCommerce\includes\class-wc-template-loader.php
		 * Something like this:
		 * if ( ! $this->files[ $templates[0] ] || WC_TEMPLATE_DEBUG_MODE ) {
		 * 	$this->files[ $templates[0] ] = plugin_path() . $this->dir_name . $located_file_name . '.php';
		 * }
		 */

		return \is_readable( $this->files[ $templates[0] ] );
	}

	/**
	 * @param array $templates
	 * @return string Return a full path of the file searched
	 */
	private function get( array $templates ) : string {

		if ( ! $this->has( $templates ) ) {
			throw new TemplateNotFoundException(
				\sprintf( 'The template %s does not exists', $templates[0] )
			);
		}

		return $this->files[ $templates[0] ];
	}

	/**
	 * Count elements of an object
	 * @link https://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 * @since 5.1.0
	 */
	public function count(): int {
		return \count( $this->files );
	}
}