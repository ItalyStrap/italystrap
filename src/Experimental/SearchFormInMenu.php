<?php
declare(strict_types=1);

namespace ItalyStrap\Experimental;

use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Tests\Subscriber;

class SearchFormInMenu implements SubscriberInterface
{

	/**
	 * New get_search_form function
	 *
	 * @since 4.0.0 ItalyStrap
	 *
	 * @link https://codex.wordpress.org/Function_Reference/get_search_form
	 * @return string Return the search form
	 */
	function get_search_form() {

		/**
		 * Retrieve the contents of the search WordPress query variable.
		 * The search query string is passed through esc_attr() to ensure
		 * that it is safe for placing in an html attribute.
		 *
		 * @var string
		 */
		$get_search_query = is_search() ? get_search_query() : '' ;

		// phpcs:disable
		$form = '<div itemscope itemtype="https://schema.org/WebSite"><meta itemprop="url" content="' . esc_attr( HOME_URL ) . '"/><form class="navbar-form navbar-right" role="search" method="get" action="' . esc_attr( HOME_URL ) . '" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction"><meta itemprop="target" content="' . esc_attr( HOME_URL ) . '?s={s}"/><div class="input-group input-group-sm"><input type="search" placeholder="' . __( 'Search now', 'italystrap' ) . '" value="' . $get_search_query . '" name="s" class="form-control" itemprop="query-input"><span class="input-group-btn"><button type="submit" class="btn btn-default" value="' . __( 'Search', 'italystrap' ) . '"><i class="glyphicon glyphicon-search"></i></button></span></div></form></div>';
		// phpcs:enable

		return apply_filters( 'italystrap_search_form', $form, $get_search_query );
	}

	/**
	 * Funzione per aggiungere il form di ricerca nel menù di navigazione
	 * Per funzionare aggiungere il parametro search con valore true all'array passato a wp_nav_menu()
	 * wp_nav_menu( array( 'search' => true ) );
	 *
	 * @todo Aggiungere opzione per stampare il form prima o dopo wp_nav_menu()
	 * @todo Aggiungere opzione nel customizer
	 *
	 * @param  string $nav_menu The nav menu output.
	 * @param  object $args     wp_nav_menu arguments in object.
	 * @return string           The nav menu output
	 * @uses italystrap_get_search_form()
	 */
	function print_search_form_in_menu( $nav_menu, $args ) {

		if ( ! isset( $args->search ) ) {
			return $nav_menu;
		}

		return str_replace( '</div>', $this->get_search_form() . '</div>', $nav_menu );
	}

	public function getSubscribedEvents(): iterable {
		// add_filter( 'wp_nav_menu', __NAMESPACE__ . '\print_search_form_in_menu', 10, 2 );
		yield 'wp_nav_menu' => [
			SubscriberInterface::CALLBACK	    => 'print_search_form_in_menu',
			SubscriberInterface::PRIORITY	    => 10, // 10 default
			SubscriberInterface::ACCEPTED_ARGS	=> 2 // 3 default
		];
	}
}