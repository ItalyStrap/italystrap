<?php namespace ItalyStrap;
/**
 * New get_search_form function
 *
 * @link https://codex.wordpress.org/Function_Reference/get_search_form
 * @return string Return the search form
 */
function get_search_form() {

	$get_search_query = ( is_search() ) ? get_search_query() : '' ;

	$form = '<div itemscope itemtype="http://schema.org/WebSite"><meta itemprop="url" content="' . esc_attr( HOME_URL ) . '"/><form class="navbar-form navbar-right" role="search" method="get" action="' . esc_attr( HOME_URL ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction"><meta itemprop="target" content="' . esc_attr( HOME_URL ) . '?s={s}"/><div class="input-group input-group-sm"><input type="search" size="16" placeholder="' . __( 'Search now', 'ItalyStrap' ) . '" value="' . $get_search_query . '" name="s" class="form-control" itemprop="query-input"><span class="input-group-btn"><button type="submit" class="btn btn-default" value="' . __( 'Search', 'ItalyStrap' ) . '"><i class="glyphicon glyphicon-search"></i></button></span></div></form></div>';

	return apply_filters( 'italystrap-search-form', $form, $get_search_query );

}
