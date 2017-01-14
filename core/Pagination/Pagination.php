<?php
/**
 * Pagination API
 *
 * This class rendere the pagination for posts lists.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package Italystrap
 */

namespace ItalyStrap\Core\Pagination;

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
	private $theme_mod;

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mod ) {
		$this->big = 999999999;
		$this->translated = __( 'Page: ', 'italystrap' );
		$this->theme_mod = $theme_mod;
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

		if ( ! isset( $wp_query ) ) {
			global $wp_query;
		}

		$paginate = paginate_links( 
			array(
				'base'					=>	str_replace(
					$this->big,
					'%#%',
					esc_url( get_pagenum_link( $this->big ) )
				),
				'format'				=>	'?paged=%#%',
				'current'				=>	max( 1, get_query_var( 'paged' ) ),
				'total'					=>	$wp_query->max_num_pages,
				'type'					=>	'list',
				'before_page_number'	=>	sprintf(
					'<span class="sr-only">%s</span>',
					$this->translated
				),
			)
		);

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
			'<span class="clearfix"></span><div class="text-center">%s</div>',
			$paginate
		);

	}
}
