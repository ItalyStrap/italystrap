<?php
declare(strict_types=1);

namespace ItalyStrap\Core;

if ( ! \function_exists( '\ItalyStrap\Core\is_debug' ) ) {

	/**
	 * Is Beta version
	 *
	 * @return bool Return true if ITALYSTRAP_BETA version is declared
	 */
	function is_debug(): bool {
		return \defined( 'WP_DEBUG' ) && WP_DEBUG;
	}
}

/**
 * Is static front page
 *
 * @return bool Return true if it is a static page selected for front page, not blog
 */
function is_static_front_page(): bool {
	return is_front_page() && ! is_home();
}

/**
 * Is comment reply
 *
 * @return bool Return true if the comment is open.
 */
function is_comment_reply(): bool {
	return \is_singular() && \comments_open() && \get_option( 'thread_comments' );
}
