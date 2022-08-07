<?php
/**
 * The template used for displaying the title.
 *
 * This file is still in BETA version.
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */
declare(strict_types=1);

namespace ItalyStrap;

use ItalyStrap\Config\ConfigInterface;

/** @var ConfigInterface $config */
$config = $this;
?>
<!-- wp:group {"tagName":"header","className":"page-header entry-header","layout":{"inherit":true}} -->
<header class="wp-block-group page-header entry-header">
	<h1 <?php HTML\get_attr_e( 'entry_title', (array)$config->get('headlineAttributes') ); ?>>
		<?php echo \esc_html( (string)$config->get('content') ); ?>
	</h1>
</header>
<!-- /wp:group -->
