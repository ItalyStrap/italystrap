<?php
declare(strict_types=1);

$min = '.min';

/**
 * Avoid caching script
 *
 * @var int
 */
$ver = null;

$suffix = '.min';

$dev_dir = '';

if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
	$ver = rand( 0, 100000 );
	// $ver = filemtime($file);
	// $suffix = '';
	// $dev_dir = 'src/'; // Sistemare il path corretto per i font
}

$script_file_url = TEMPLATEURL . '/js/custom' . $min . '.js';
$script_file_path = PARENTPATH . '/js/custom' . $min . '.js';

if ( file_exists( CHILDPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js' ) ) {
	$script_file_url = STYLESHEETURL . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js';
	$script_file_path = CHILDPATH . '/js/' . CURRENT_TEMPLATE_SLUG . $min . '.js';
} elseif ( file_exists( CHILDPATH . '/js/custom' . $min . '.js' ) ) {
	$script_file_url = STYLESHEETURL . '/js/custom' . $min . '.js';
	$script_file_path = CHILDPATH . '/js/custom' . $min . '.js';
}

$config_scripts = [
//	[
//		'handle'		=> 'jquery',
//		'file'			=> '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
//		'deps'			=> false,
////				'version'		=> $ver,
//		'version'		=> '2.1.1',
//		'in_footer'		=> true,
//		'pre_register'	=> true,
//		'deregister'	=> true, // This will deregister previous registered jQuery.
//	],
	[
		'handle'		=> CURRENT_TEMPLATE_SLUG,
		'file'			=> $script_file_url,
		'deps'			=> ['jquery'],
		'version'		=> filemtime( $script_file_path ),
		'in_footer'		=> true,

		/**
		 * For now the localize object is set only if the script is not deregister
		 * and if is appendend to the config array of the script to load.
		 */
		'localize'		=> [
			'object_name'	=> 'pluginParams',
			'params'		=> [
				'ajaxurl'		=> admin_url( '/admin-ajax.php' ),
				'ajaxnonce'		=> wp_create_nonce( 'ajaxnonce' ),
				// 'api_endpoint'	=> site_url( '/wp-json/rest/v1/' ),
			],
		],
	],
	[
		'handle'		=> 'comment-reply',
		'load_on'		=> 'ItalyStrap\Core\is_comment_reply',
	],
];

return $config_scripts;
