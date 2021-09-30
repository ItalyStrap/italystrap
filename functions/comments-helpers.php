<?php
// phpcs:ignoreFile
declare(strict_types=1);

namespace ItalyStrap\Core;

/**
 * Is comment reply
 *
 * @return bool Return true if the comment is open.
 */
function is_comment_reply(): bool {
	return \is_singular() && \comments_open() && \get_option( 'thread_comments' );
}
