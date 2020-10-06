<?php
/**
 * The template used for displaying preview message
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */
declare(strict_types=1);

namespace ItalyStrap;

use function __;
use function is_preview;
use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\open_tag_e;
use function wp_kses_post;

if ( ! is_preview() ) {
	return;
}

open_tag_e('preview', 'div', []);

	echo wp_kses_post(
		__(
			'<strong>Note:</strong> You are previewing this post. This post has not yet been published.',
			'italystrap'
		)
	);

	close_tag_e('preview' );
