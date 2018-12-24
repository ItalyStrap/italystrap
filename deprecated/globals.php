<?php
_deprecated_file( 'globals.php', '3.0.6', null, __( 'All globals now are in functions.php', 'italystrap' ) );
//definisco una variabile globale per la url del template e dell'immagine di default
$path = get_template_directory_uri();
$pathchild = get_stylesheet_directory_uri();
$italystrap_options = get_option( 'italystrap_theme_settings' );