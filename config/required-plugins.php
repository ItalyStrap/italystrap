<?php
/**
 * [Short Description (no period for file headers)]
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
return array(

	/**
	 * Require GitHub Updater
	 */
	// array(

	// 	/**
	// 	 * The plugin name.
	// 	 */
	// 	'name'                     => 'GitHub Updater',

	// 	/**
	// 	 * The plugin slug (typically the folder name).
	// 	 */
	// 	'slug'                     => 'github-updater',

	// 	/**
	// 	 * The plugin source.
	// 	 */
	// 	'source'                   => 'http://www.overclokk.net/TGM/github-updater.zip',

	// 	/**
	// 	 * If false, the plugin is only 'recommended' instead of required.
	// 	 */
	// 	'required'                 => false,

	// 	*
	// 	 * E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		 
	// 	'version'                 => '',

	// 	/**
	// 	 * If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 	 */
	// 	'force_activation'         => false,

	// 	/**
	// 	 * If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 	 */
	// 	'force_deactivation'     => false,

	// 	/**
	// 	 * If set, overrides default API URL and points to an external URL
	// 	 */
	// 	'external_url'             => 'https://github.com/afragen/github-updater',
	// ),

	/**
	 * Require ItalyStrap Plugin
	 */
	array(

		/**
		 * The plugin name
		 */
		'name'                     => 'Advanced Control Manager for WordPress by ItalyStrap',

		/**
		 * The plugin slug (typically the folder name)
		 */
		'slug'                     => 'advanced-control-manager',

		/**
		 * If false, the plugin is only 'recommended' instead of required
		 */
		'required'                 => true,

		/**
		 * E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		 */
		'version'                 => '',

		/**
		 * If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		 */
		'force_activation'         => true,

		/**
		 * If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		 */
		'force_deactivation'     => false,
	),

);
