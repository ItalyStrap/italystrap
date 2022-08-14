<?php
declare(strict_types=1);

namespace ItalyStrap\Headers;

use ItalyStrap\Components\CustomHeaderImage;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\EventDispatcherInterface;

/**
 * @var $this ConfigInterface
 */

/** @var EventDispatcherInterface $dispatcher */
$dispatcher = $this->get(EventDispatcherInterface::class);
?>
<!-- wp:group {"tagName":"header","className":"site-header","layout":{"inherit":true}} -->
<header class="wp-block-group site-header">
	<?php $dispatcher->dispatch('header_open'); ?>
	<?php echo \strip_tags( (string)$this->get( CustomHeaderImage::CONTENT ), ['img', 'figure']); ?>
	<?php $dispatcher->dispatch('header_closed'); ?>
</header>
<!-- /wp:group -->
