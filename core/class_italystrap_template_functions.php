<?php

/**
 * 
 */
class ItalyStrap_template_functions{
	
	function __construct(){
	}

	public function navbar_brand( $arg = array() ){

		$html = '<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<a class="navbar-brand" href="' . home_url('/') . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" rel="home" itemprop="url"><span itemprop="name">' . get_bloginfo('name') . '</span></a>
				<meta  itemprop="image" content="' .  italystrap_logo() . '"/>
			</span>';
		return $html;

	}

}

function italystrap_navbar_brand(){

	$html = '<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<a class="navbar-brand" href="' . home_url('/') . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" rel="home" itemprop="url"><span itemprop="name">' . get_bloginfo('name') . '</span></a>
				<meta  itemprop="image" content="' .  italystrap_logo() . '"/>
			</span>';
			
	return $html;

}