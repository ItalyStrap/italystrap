<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Main\Events\Content;
use ItalyStrap\UI\Components\Main\Events\ContentAfter;
use ItalyStrap\UI\Components\Main\Events\ContentBefore;
use ItalyStrap\UI\Components\Main\Events\Footer;
use ItalyStrap\UI\Components\Main\Events\Header;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var $this ConfigInterface */

/** @var $dispatcher EventDispatcherInterface */
$dispatcher = (object)$this->get(EventDispatcherInterface::class);

$containerClassName = (string)$this->get('container_class_names');
$rowClassName = (string)$this->get('row_class_names');
?>
<?= $dispatcher->dispatch(new Header()); ?>
<!-- wp:group {"tagName":"main","align":"full","className":"<?= \wp_strip_all_tags($containerClassName); ?>","layout":{"inherit":false}} -->
<main class="wp-block-group alignfull <?= \esc_attr($containerClassName); ?>">
    <!-- wp:columns {"align":"wide","className":"<?= \wp_strip_all_tags($rowClassName); ?>","layout":{"inherit":true}} -->
    <div class="wp-block-columns alignwide <?= \esc_attr($rowClassName); ?>">

        <?= $dispatcher->dispatch(new ContentBefore()); ?>

        <!-- wp:column -->
        <div class="wp-block-column">
            <?= $dispatcher->dispatch(new Content()); ?>
        </div>
        <!-- /wp:column -->

        <?= $dispatcher->dispatch(new ContentAfter()); ?>

    </div>
    <!-- /wp:columns -->
</main>
<!-- /wp:group -->

<?= $dispatcher->dispatch(new Footer()); ?>

