<?php
/**
 * The Header for ItalyStrap
 *
 * Displays all of the <head> section and Main menu
 *
 * For improve performance replace $lang_attr with lang="xx-XX" when xx_XX is your language (en_EN - de_DE - fr_FR - ecc)
 * Otherwise you can use <?php language_attributes(); ?> instead
 *
 * You can also replace <?php bloginfo( 'charset' ); ?> with "UTF-8" or your charset
 *
 * @package ItalyStrap
 * @since ItalyStrap 1.0
 */

namespace ItalyStrap;

?>
<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php \language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" <?php \language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" <?php \language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" <?php \language_attributes(); ?> prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php \wp_head(); ?>
</head>
<body <?php HTML\get_attr( 'body', [], true ); ?>>
<?php \do_action( 'italystrap_before' ); ?>
	<div <?php HTML\get_attr( 'wrapper', [], true ); ?>>
<?php

\do_action( 'italystrap_before_header' );

    \do_action( 'italystrap_content_header' );

\do_action( 'italystrap_after_header' );
