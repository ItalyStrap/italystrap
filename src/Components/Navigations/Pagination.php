<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Navigations;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML;

/**
 * Pagination Class
 */
class Pagination {

	/**
	 * Need an unlikely integer.
	 *
	 * @var int
	 */
	private $big;

	/**
	 * Theme config.
	 *
	 * @var array
	 */
	private $config;

	/**
	 * WP_Query object
	 *
	 * @var \WP_Query
	 */
	private $query;

	/**
	 * Pagination constructor.
	 *
	 * @param ConfigInterface $config
	 * @param \WP_Query|null $query
	 */
	public function __construct( ConfigInterface $config, \WP_Query $query = null ) {

		$this->big = PHP_INT_MAX;
		$this->config = $config;
		$this->query = $query ?: $GLOBALS['wp_query'];
	}

	/**
	 * Get paginate link
	 *
	 * @return array        Return the paginate link
	 */
	private function getPaginateLink() {

		if ( $this->getMaxNumPages() <= 1 ) {
			return [];
		}

		$args = array(
			'base'					=> $this->getPagenumLink(),
			'format'				=> '?paged=%#%',
			'current'				=> $this->getCurrentPage(),
			'total'					=> $this->getMaxNumPages(),
			'type'					=> 'array',
			'before_page_number'	=> $this->config->get( 'before_page_number' ),
//			'prev_text'         	=> $this->config->get( 'prev_text', null ),
//			'next_text'          	=> $this->config->get( 'next_text', null ),
		);

		return (array) paginate_links( $args );
	}

	/**
	 * function for show pagination with bootstrap style
	 * if you have a custom loop pass the object to functions like this:
	 * bootstrap_pagination( $my_custom_query ), otherwise use only bootstrap_pagination()
	 *
	 * @link http://codex.wordpress.org/function_reference/paginate_links
	 *
	 * @return string             boostrap navigation for WordPress
	 */
	public function render() {

		$paginate = $this->getPaginateLink();

		if ( empty( $paginate ) ) {
			return '';
		}

		$html = '';
		$tag = $this->config->get( 'item_tag', 'li' );

		foreach ( $paginate as $key => $anchor ) {

			/**
			 * Add a css class to the anchor link or to the span tag of the element
			 */
			$anchor = str_replace( 'page-numbers', 'page-numbers page-link', $anchor );

			$attr = $this->config->get( 'item_attr' );

			if ( strpos( $anchor, 'current' ) !== false ) {
				$attr['class'] .= $this->config->get( 'active_class' );
			}

			$html .= sprintf(
				'<%1$s%2$s>%3$s</%1$s>',
				$tag,
				HTML\get_attr( 'pagination_el', $attr ),
				$anchor
			);
		}

		$html = sprintf(
			'<%1$s%2$s>%3$s</%1$s>',
			$this->config->get( 'list_tag', 'ul' ),
			HTML\get_attr(
				'pagination_list',
				(array) $this->config->get( 'list_attr' )
			),
			$html
		);

		return _navigation_markup( $html );

//		return sprintf(
//			'<span class="clearfix">&nbsp;</span><nav aria-label="%s %s">%s</nav>',
//			ucfirst( get_post_type() ),
//			__( 'navigation', 'italystrap' ),
//			apply_filters( 'italystrap_pagination_html', $html, $this )
//		);
	}

	/**
	 * Get max num pages
	 *
	 * @return int
	 */
	private function getMaxNumPages() {
		return (int) $this->query->max_num_pages;
	}

	/**
	 * @return int
	 */
	private function getCurrentPage() {

		static $current = null;

		if ( ! $current ) {
			$current = max( 1, get_query_var( 'paged' ) );
		}

		return (int) $current;
	}

	/**
	 * Get pagenum link
	 *
	 * @return string
	 */
	private function getPagenumLink() {

		return str_replace(
			$this->big,
			'%#%',
			esc_url( get_pagenum_link( $this->big ) )
		);
	}
}
