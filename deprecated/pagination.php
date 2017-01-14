<?php
/**
 * Function for show pagination with Bootstrap style
 * If you have a custom loop pass the object to functions like this:
 * bootstrap_pagination( $my_custom_query ), otherwise use only bootstrap_pagination()
 *
 * @link http://codex.wordpress.org/Function_Reference/paginate_links
 * 
 * @param  Query $wp_query A query for loop. Default NULL.
 * @return string       Boostrap navigation for WordPress
 */
function bootstrap_pagination( $wp_query = NULL ) {

	_deprecated_function( __FUNCTION__, '4.0.0', __( 'Use \ItalyStrap\Core\Pagination\Pagination::render instead.', 'italystrap' ) );

	if ( ! isset( $wp_query ) ) {
		global $wp_query;
	}

	/**
	 * Need an unlikely integer.
	 *
	 * @var int
	 */
	$big = 999999999;

	/**
	 * Supply translatable string.
	 *
	 * @var string
	 */
	$translated = __( 'Page: ', 'italystrap' );

	$paginate = paginate_links( 
		array(
			'base'					=>	str_replace(
				$big,
				'%#%',
				esc_url( get_pagenum_link( $big ) )
			),
			'format'				=>	'?paged=%#%',
			'current'				=>	max( 1, get_query_var( 'paged' ) ),
			'total'					=>	$wp_query->max_num_pages,
			'type'					=>	'list',
			'before_page_number'	=>	sprintf(
				'<span class="sr-only">%s</span>',
				$translated
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

/**
 * @todo New function for pagination
 */
// function ItalyStrap_get_bootstrap_pagination( $wp_query = NULL ){

// 	# code...
// }
/**
 * @todo Mettere a posto la paginazione nel caso si decida di togliere dal numero di articoli mostrati il numero degli articoli in sticky in modo da mostrere il numero corretto di articoli
 * Esempio:
 * visualizzo 10 post
 * 2 sono in sticky
 * ne verranno mostrati 12
 * fare in modo che ne risultino 10
 *
 * Piccolo problema
 * Se i post in evidenza sono più reventi dei 10 mostrati non verrà aggiunto nessun articolo oltre i 10 classici, se sono più vecchi invece verranno aggiunti allo stream.
 */
// http://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
// http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
						// $sticky = get_option( 'sticky_posts' );
						// $sticky = count($sticky);

						// $postperpage = ( ! empty( $sticky ) ) ? 12 - $sticky : 12;

						// query_posts( "posts_per_page=$postperpage" );