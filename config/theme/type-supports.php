<?php

return \apply_filters(
	'italystrap_post_types_supports',
	[
		'post'		=> [ 'post_navigation', 'entry-meta' ],
		'page'		=> [ 'post_navigation', 'entry-meta' ],
		'download'	=> [ 'post_navigation', 'entry-meta' ],
	]
);