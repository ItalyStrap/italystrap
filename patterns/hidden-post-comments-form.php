<?php

declare(strict_types=1);

/**
 * Title: Post Comments Form
 * Slug: italystrap/hidden-post-comments-form
 * Inserter: no
 *
 * This pattern is used to customize the post comments form.
 * In a PHP file the function to load the comments template (comments.php) is `comments_template();`
 * the function to render only the form from the WP core is `comment_form();`
 */

/**
 * Exchange reposition of the 'comment' field
 */
\add_filter('comment_form_fields', static function (array $fields): array {
    $comment_field = $fields['comment'] ?? '';
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}, PHP_INT_MAX, 1);
?>
<!-- wp:post-comments-form /-->
