<?php
/**
 * The template used for displaying preview message
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

if ( ! is_preview() ) {
	return;
}

?><div <?php Core\get_attr( 'preview', [], true ); ?>><?php wp_kses_post( _e( '<strong>Note:</strong> You are previewing this post. This post has not yet been published.', 'italystrap' ) ); ?></div>
