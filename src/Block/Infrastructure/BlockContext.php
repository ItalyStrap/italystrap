<?php

declare(strict_types=1);

namespace ItalyStrap\Block\Infrastructure;

/**
 * The post a block renders, read from the block context like the core post blocks,
 * so the blocks render the right post inside query loops.
 */
final class BlockContext
{
    /**
     * Outside a loop it falls back to the current post.
     */
    public function postId(\WP_Block $block): int
    {
        $postId = $block->context['postId'] ?? \get_the_ID();

        return \is_numeric($postId) ? (int) $postId : 0;
    }

    /**
     * The author of the post in the block context, or the queried author outside a loop on author archives.
     */
    public function authorId(\WP_Block $block): int
    {
        if (!\array_key_exists('postId', $block->context) && \is_author()) {
            return \get_queried_object_id();
        }

        $postId = $this->postId($block);

        return $postId === 0 ? 0 : (int) \get_post_field('post_author', $postId);
    }
}
