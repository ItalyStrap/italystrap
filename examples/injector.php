<?php

$class = mb_strtolower( 'ItalyStrap\Css\Css' );

$inspect = $injector->inspect( $class );

// d( \Auryn\Injector::I_SHARES );

d( $inspect );
d( $inspect[ \Auryn\Injector::I_SHARES ] );
d( $inspect[ \Auryn\Injector::I_SHARES ][ $class ] );
d( $inspect[ \Auryn\Injector::I_SHARES ][ $class ]->get_subscribed_events() );
d( is_object( $inspect[16][ $class ] ) );


add_action( 'italystrap_theme_will_load', function ( Injector $injector ) use ( $theme_config ) {

	$args = [
		':array_to_merge' => $theme_config,
	];

	$injector->execute( '\ItalyStrap\Config\merge_array_to_config', $args );

} );
