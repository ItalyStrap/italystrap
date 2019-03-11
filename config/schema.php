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

$content_itemType = '';

switch ( true ) {
	case \ItalyStrap\Core\is_static_front_page():
	case is_singular():
		$content_itemType = 'https://schema.org/Article';
		break;
	case is_home():
		$content_itemType = 'https://schema.org/WebSite';
		break;
	case is_search():
		$content_itemType = 'https://schema.org/SearchResultsPage';
		break;
	default:
		$content_itemType = 'https://schema.org/CollectionPage';
		break;
}

return [
	/**
	 * Filter name
	 */
	'italystrap_content_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> $content_itemType,
	],
	'italystrap_entry_content_attr'	=> [
		'itemprop' => 'articleBody'
	],
	'italystrap_sidebar_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> 'https://schema.org/WPSideBar',
	],
	'italystrap_footer_attr'	=> [
		'itemscope'	=> true,
		'itemtype'	=> 'https://schema.org/WPFooter',
	],
];