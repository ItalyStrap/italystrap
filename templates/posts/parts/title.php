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

use function ItalyStrap\HTML\{open_tag_e, close_tag_e};

$html_tag = \is_singular() ? 'h1' : 'h2';
$title_prop = \is_singular() ? 'headline' : 'name';

?><header class="page-header entry-header">
    <?php open_tag_e( 'entry_title', $html_tag, ['class'	=> 'entry-title'] ); ?>
		<a itemprop="url" href="<?php \the_permalink(); ?>" title="<?php \the_title_attribute() ?>" rel="bookmark">
			<span itemprop="<?php echo $title_prop; ?>"><?php \the_title(); ?></span>
		</a>
    <?php close_tag_e( 'entry_title' ); ?>
</header>
