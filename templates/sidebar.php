<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;

/** @var ConfigInterface $config */
$config = $this;

$index = (string)$config->get('index');

if (\is_active_sidebar($index)) :
    \do_action('italystrap_before_sidebar_widget_area');

    ?>
    <!-- wp:column {"width":"33.33%","className":"sidebar"} -->
    <div class="wp-block-column sidebar" style="flex-basis:33.33%">
        <?php \dynamic_sidebar($index) ?>
    </div>
    <!-- /wp:column -->
    <?php

    \do_action('italystrap_after_sidebar_widget_area');
endif; ?>
