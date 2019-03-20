<?php

/**
 * @todo Verificare eventuali problemi di priorità con gli hook
 */
return [
//	[
//		'hook'	=> 'italystrap_before_loop',
//		'view'	=> 'posts/index',
//		'data'	=> [],
//		'priority'	=> 10, // Optional
//		'callback'	=> function () {
//			return 'Ciao';
//		}, // Optional
//	],
	'breadcrumbs'	=> [
		'hook'	=> 'italystrap_before_loop',
		'priority'	=> 10, // Optional
//		'view'	=> 'posts/index',
//		'data'	=> [],
		'callback'	=> '\ItalyStrap\Controllers\Posts\Parts\Breadcrumbs', // Optional
	],
	'title'	=> [
		'hook'	=> 'italystrap_entry_content',
		'priority'	=> 20, // Optional
		'view'	=> 'posts/parts/title',
		'data'	=> [],
		'callback'	=> 'ItalyStrap\Controllers\Posts\Parts\Title', // Optional
	],
	'entry'	=> [
		'hook'	=> 'italystrap_entry',
		'priority'	=> 10, // Optional
		'view'	=> 'posts/post',
		'data'	=> function ( array $value ) {
			return (array) get_post( null, ARRAY_A );
		},
		'callback'	=> '', // Optional
		'child_of'	=> '',
	],
	'none'	=> [
		'hook'	=> 'italystrap_content_none',
		'view'	=> 'posts/none',
//		'data'	=> [],
	],
	'loop'	=> [
		'hook'	=> 'italystrap_loop',
		'view'	=> 'posts/loop',
//		'data'	=> [],
	],
	'index'	=> [
		'hook'	=> 'italystrap',
		'view'	=> 'index',
//		'data'	=> [],
	],
];
