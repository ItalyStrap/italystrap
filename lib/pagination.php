<?php
// http://codex.wordpress.org/Function_Reference/paginate_links
function bootstrap_pagination( $query = NULL ){
	global $wp_query;
	if ( !isset( $query ) ) {
		$query = $wp_query;
	}
	$big = 999999999; // need an unlikely integer
	$translated = __( 'Page: ', 'ItalyStrap' ); // Supply translatable string

	$paginate = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'type'         => 'list',
		'before_page_number' => '<span class="sr-only">'.$translated.' </span>',
			) 
		);

	$paginate = str_replace("<ul class='page-numbers'", "<ul class='pagination'", $paginate);
	$paginate = str_replace("<li><span class='page-numbers current'", "<li class='active'><span class='page-numbers current'", $paginate);

	echo '<span class="clearfix"></span><div class="text-center">' . $paginate . '</div>';

}
?>