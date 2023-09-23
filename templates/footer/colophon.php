<?php

/**
 * The template part for displaying Colophon
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Footer\Colophon;
use ItalyStrap\Config\ConfigInterface;
use function wp_kses_post;

/** @var ConfigInterface $config */
$config = $this;
?>
<!-- wp:group {"layout":{"inherit":true}} -->
<div class="wp-block-group">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group">
        <!-- wp:paragraph -->
        <p><?php echo wp_kses_post((string)$config->get(Colophon::CONTENT, '')) ; ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
