<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\UI\Components\Main\Canvas as MainCanvas;
use ItalyStrap\UI\Components\Main\Events\Canvas;
use Psr\EventDispatcher\EventDispatcherInterface;

/** @var $this ConfigInterface */

/** @var $dispatcher EventDispatcherInterface */
$dispatcher = (object)$this->get(EventDispatcherInterface::class);

?><!DOCTYPE html>
<html <?php \language_attributes(); ?>>
<head>
    <meta charset="<?php \bloginfo('charset'); ?>" />
    <?php \wp_head(); ?>
</head>

<body <?= \esc_attr((string)$this->get(MainCanvas::BODY_CLASS_NAMES, '')); ?>>
<?php \wp_body_open(); ?>

<?= $dispatcher->dispatch(new Canvas()); ?>

<?php \wp_footer(); ?>
</body>
</html>
