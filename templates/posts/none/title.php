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

/**
 * The ".404_title" css class is used in customizer for change in real time the content
 *
 * @var array
 */
$headline_attr = [
	'class'		=> 'page-title 404-title',
	'itemprop'	=> 'headline',
];

?><header class="page-header">
	<h1 <?php HTML\get_attr( 'entry_title', $headline_attr, true ); ?>>
		<?php echo \esc_html( $this->get('404_title') ); ?>
	</h1>
</header>