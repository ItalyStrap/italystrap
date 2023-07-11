<?php

declare(strict_types=1);

namespace ItalyStrap\Components;

use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\open_tag_e;

class Preview implements ComponentInterface, \ItalyStrap\Event\SubscriberInterface
{
    use SubscribedEventsAware;

    public const EVENT_NAME = 'italystrap_entry_content';
    public const EVENT_PRIORITY = 40;

    public function shouldDisplay(): bool
    {
        return is_preview();
    }

    public function display(): void
    {
        echo \do_blocks($this->output());
    }

    /**
     * @return false|string
     */
    private function output()
    {
        \ob_start();
        ?>
        <!-- wp:group {"className":"preview"} -->
        <div class="wp-block-group preview">
            <?php
            echo \wp_kses_post(
                __(
                    '<strong>Note:</strong> You are previewing this post. This post has not yet been published.',
                    'italystrap'
                )
            );
            ?>
        </div>
        <!-- /wp:group -->
        <?php
        return \ob_get_clean();
    }
}
