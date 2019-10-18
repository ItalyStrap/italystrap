<?php
declare(strict_types=1);
namespace ItalyStrap;
return \apply_filters(
	'italystrap_post_types_supports',
	[
		'post'		=> [ 'post_navigation', 'entry-meta' ],
		'page'		=> [ 'post_navigation', 'entry-meta' ],
		'download'	=> [ 'post_navigation', 'entry-meta' ],
	]
);