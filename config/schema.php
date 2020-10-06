<?php
/**
 * ===========================================================
 *
 * Configuration file for adding attributes to relative hooks
 *
 * The hooks will returns at first argument an array, optionally
 * if the hook is created from \ItalyStrap\HTML\get_attr()
 * i will pass 3 arguments, (array) $attr, (string) $context and $data
 *
 * @example:
 * [
 * 	'filter_name'	=> [...filter_attributes],
 *  'filter_name'	=> callable()
 * ]
 *
 * ===========================================================
 */
declare(strict_types=1);

use function ItalyStrap\HTML\content_item_type_experimental;

return [
	/**
	 * Filter name
	 */
	'italystrap_content_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> content_item_type_experimental(),
	],
	'italystrap_entry_content_attr'	=> [
		'itemprop' => 'articleBody'
	],
	'italystrap_sidebar_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> 'https://schema.org/WPSideBar',
	],
	'italystrap_after_entry_content'	=> function () {
		?><meta itemprop="interactionCount" content="UserComments:<?php \comments_number( '0', '1', '%' );?>" /><?php
	},
	'italystrap_footer_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> 'https://schema.org/WPFooter',
	],
];
