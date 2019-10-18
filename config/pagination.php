<?php
/**
 * Default configuration for pagination
 */
declare(strict_types=1);
return [

	/**
	 * ===================================================================
	 * WordPress default
	 * ===================================================================
	 */
	'before_page_number'	=> sprintf(
		'<span class="screen-reader-text sr-only">%s</span>',
		__( 'Page: ', 'italystrap' )
	),

//	'after_page_number'		=> '',
//	'aria_current'			=> '',
//	'prev_next'				=> true,
//	'prev_text'				=> '<i class="fas fa-arrow-left">&nbsp;</i>',
//	'next_text'				=> '<i class="fas fa-arrow-right">&nbsp;</i>',

	/**
	 * ===================================================================
	 * Pagination params
	 * ===================================================================
	 */
	'active_class'			=> ' active',








	/**
	 * This is the container of the breadcrumbs
	 * @example <nav aria-label="breadcrumb">...</nav>
	 */
//	'container_tag'				=> 'nav',
//	'container_attr'			=> [
//		'aria-label'	=> 'breadcrumb',
//	],

	/**
	 * This is the container tag of the list
	 *
	 * @classes:
	 * justify-content-{center|end}
	 * pagination-{lg|sm}
	 * @example <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">...</ol>
	 */
	'list_tag'					=> 'ul',
	'list_attr'					=> [
		'class'			=> 'pagination justify-content-center',
	],

	/**
	 * This is the item tag of the breadcrumbs
	 * @example <li class="breadcrumb-item [...active]" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">...</li>
	 */
	'item_tag'					=> 'li',
	'item_attr'					=> [
		'class'			=> "page-item",
	],

	/**
	 * Css class for active element
	 */
	'item_attr_class_active'	=> ' active',
];