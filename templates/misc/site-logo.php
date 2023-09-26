<?php

declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Components\Header\SiteLogo;

/** @var \ItalyStrap\Config\ConfigInterface $config */
$config = $this;

?><!-- wp:site-logo <?php echo \strip_tags((string)$config->get(SiteLogo::ATTRIBUTES)) ?> /-->
