<?php

/**
 * 
 */
class ItalyStrap_template_functions{
	
	function __construct(){
	}

	public function navbar_brand( $arg = array() ){

		$html = '<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<a class="navbar-brand" href="' . esc_attr( HOME_URL ) . '" title="' . esc_attr( GET_BLOGINFO_NAME ) . '" rel="home" itemprop="url"><span itemprop="name">' . GET_BLOGINFO_NAME . '</span></a>
				<meta  itemprop="image" content="' .  italystrap_logo() . '"/>
			</span>';
		return $html;

	}

}

function italystrap_navbar_brand(){

	$html = '<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<a class="navbar-brand" href="' . esc_attr( HOME_URL ) . '" title="' . esc_attr( GET_BLOGINFO_NAME ) . '" rel="home" itemprop="url"><span itemprop="name">' . GET_BLOGINFO_NAME . '</span></a>
				<meta  itemprop="image" content="' .  italystrap_logo() . '"/>
			</span>';
			
	return $html;

}