<?php
/**
 * Pagination API
 *
 * This class rendere the pagination for posts lists.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Pagination;

use WP_Query;

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
	 * Supply translatable string.
	 *
	 * @var string
	 */
	private $translated;

	/**
	 * Theme config.
	 *
	 * @var array
	 */
	private $config;

	/**
	 * WP_Query object
	 *
	 * @var WP_Query
	 */
	private $query;

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $config, WP_Query $query = null ) {
		// $this->big = 999999999;
		$this->big = PHP_INT_MAX;
		$this->translated = __( 'Page: ', 'italystrap' );
		$this->config = $config;
		$this->query = $query;
	}

	/**
	 * Get max num pages
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	private function set_max_num_pages( $max_num_pages ) {
	
		return $max_num_pages;
	
	}

	/**
	 * Get paginate link
	 *
	 * @return string        Return the paginate link
	 */
	public function get_paginate_link() {

		if ( ! $this->query instanceof WP_Query ) {
			global $wp_query;
			$this->query = $wp_query;
		}

		// if ( ! isset( $wp_query ) ) {
		// 	global $wp_query;
		// }

		/**
		 * wp-includes/general-template.php
		 *
		 * @var array
		 */
		// $defaults = array(
		// 	'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		// 	'format' => $format, // ?page=%#% : %#% is replaced by the page number
		// 	'total' => $total,
		// 	'current' => $current,
		// 	'show_all' => false,
		// 	'prev_next' => true,
		// 	'prev_text' => __('&laquo; Previous'),
		// 	'next_text' => __('Next &raquo;'),
		// 	'end_size' => 1,
		// 	'mid_size' => 2,
		// 	'type' => 'plain',
		// 	'add_args' => array(), // array of query args to add
		// 	'add_fragment' => '',
		// 	'before_page_number' => '',
		// 	'after_page_number' => ''
		// );

		if ( $this->query->max_num_pages <= 1 ) {
			return;
		}

		$args = array(
			'base'					=>	str_replace(
				$this->big,
				'%#%',
				esc_url( get_pagenum_link( $this->big ) )
			),
			'format'				=>	'?paged=%#%',
			'current'				=>	max( 1, get_query_var( 'paged' ) ),
			'total'					=>	$this->query->max_num_pages,
			'type'					=>	'list',
			// 'type'					=>	'plain',
			// 'type'					=>	'array',
			'before_page_number'	=>	sprintf(
				'<span class="sr-only">%s</span>',
				$this->translated
			),
		);

		return paginate_links( $args );
	}

	/**
	 * Function for show pagination with Bootstrap style
	 * If you have a custom loop pass the object to functions like this:
	 * bootstrap_pagination( $my_custom_query ), otherwise use only bootstrap_pagination()
	 *
	 * @link http://codex.wordpress.org/Function_Reference/paginate_links
	 * 
	 * @param  WP_Query $wp_query A query for loop. Default NULL.
	 *
	 * @return string             Boostrap navigation for WordPress
	 */
	public function render( $wp_query = NULL ) {

		$paginate = $this->get_paginate_link();

		if ( ! $paginate ) {
			return;
		}

		$paginate = str_replace(
			"<ul class='page-numbers'",
			'<ul class="pagination"',
			$paginate
		);

		$paginate = str_replace(
			"<li><span class='page-numbers current'",
			'<li class="active"><span class="page-numbers current"',
			$paginate
		);

		printf(
			'<span class="clearfix"></span><nav aria-label="%s %s">%s</nav>',
			ucfirst( get_post_type() ),
			__( 'navigation', 'italystrap' ),
			apply_filters( 'italystrap_pagination_html', $paginate, $this )
		);

	}
}
