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

if ( SCRIPT_DEBUG ) {
	$ver = rand( 0, 100000 );
	// $ver = filemtime($file);
	// $suffix = '';
	// $dev_dir = 'src/'; // Sistemare il path corretto per i font
}

$style_file_url = TEMPLATEURL . '/css/' . $dev_dir . 'custom.css';
$style_file_path = PARENTPATH . '/css/' . $dev_dir . 'custom.css';

if ( file_exists( CHILDPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' ) ) {
	$style_file_url = STYLESHEETURL . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css';
	$style_file_path = CHILDPATH . '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css';
} elseif ( file_exists( CHILDPATH . '/css/' . $dev_dir . 'custom.css' ) ) {
	$style_file_url = STYLESHEETURL . '/css/' . $dev_dir . 'custom.css';
	$style_file_path = CHILDPATH . '/css/' . $dev_dir . 'custom.css';
}

//		d( get_theme_file_uri( '/css/' . $dev_dir . CURRENT_TEMPLATE_SLUG . '.css' ) );

$config_styles = [
	[
		'handle'	=> CURRENT_TEMPLATE_SLUG,
		'file'		=> $style_file_url,
		'url'		=> $style_file_url,
//		'version'	=> filemtime( $style_file_path ),
		'media'		=> null,
	],
];

return $config_styles;
