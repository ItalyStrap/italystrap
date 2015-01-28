<?php
_deprecated_file( basename(__FILE__), 'ItalyStrap 2.1.0', null, __( 'This file no longer needs to be included.' ) );
/**
 * @link http://mkoerner.de/breadcrumbs-for-wordpress-themes-with-bootstrap-3/
 * Bootstrap breadcrumbs for wordpress modified by Enea Overclokk
 *
 * Da modificare - inserire funzione get_category_parent per le categorie genitori
 * @link http://wordpress.org/support/topic/how-to-get-parent-category-name?replies=4
 * @link http://codex.wordpress.org/Function_Reference/get_category_parents
 * @link https://core.trac.wordpress.org/browser/tags/4.0/src/wp-includes/category-template.php#L0
 * Inserire markup rdfa per google richsnippet
 *
 * @deprecated 2.1.0
 * @deprecated Use new ItalyStrapBreadcrumbs( $defaults );
 * @see ItalyStrapBreadcrumbs( $defaults );
 */
function create_breadcrumbs() {
  _deprecated_function( __FUNCTION__, 'ItalyStrap 2.1.0', 'ItalyStrap_the_breadcrumbs' );
  global $post;
  if (isset($post->ID)) {
    $postID = $post->ID;
  }else{
    $postID = NULL;
  }
  $categories = get_the_category($postID);
  // var_dump(get_category_parents( get_query_var('cat'), false, ' / ' ));
  // var_dump($categories);
  if(!is_home() || !is_front_page()) {

    echo '<div itemscope itemtype="http://schema.org/WebPage"><ol class="breadcrumb" itemprop="breadcrumb">';
    echo '<li><a href="' . home_url() . '">' . __('Home', 'ItalyStrap') . '</a></li>';

    if (is_single()) {

      if ( !empty($categories)) {
        echo '<li>';
        the_category(', ');
        echo '</li>';
      }

      if (is_single()) {
        echo '<li>' . get_the_title() . '</li>';
      }

    } elseif (is_category()) {
      // echo '<li>';
      // echo get_category_parents( get_query_var('cat'), true, '</li><li>', true );
      // echo '</li>';

      echo '<li>';
      single_cat_title();
      echo '</li>';

    } elseif (is_post_type_archive()) {
      echo '<li>';
      post_type_archive_title();
      echo '</li>';

    } elseif (is_page() && (!is_front_page())) {
      echo '<li>' . get_the_title() . '</li>';

    } elseif (is_tag()) {
      echo '<li>' . __('Tag: ', 'ItalyStrap');
      single_tag_title();
      echo '</li>';

    } elseif (is_day()) {
      echo'<li>'. __('Daily archive: ', 'ItalyStrap');
      the_time('F jS, Y');
      echo'</li>';

    } elseif (is_month()) {
      echo'<li>'. __('Monthly archive: ', 'ItalyStrap');
      the_time('F, Y');
      echo'</li>';

    } elseif (is_year()) {
      echo'<li>' . __('Yearly archive: ', 'ItalyStrap');
      the_time('Y');
      echo'</li>';

    } elseif (is_author()) {
      echo'<li>' . __('Author Archives: ', 'ItalyStrap') . get_the_author() . '</li>';

    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
      echo '<li>' . __('Blog Archives', 'ItalyStrap');
      echo'</li>';

    } elseif (is_search()) {
      echo'<li>' . __('Search Results: ', 'ItalyStrap') . get_search_query();
      echo'</li>';

    }
    echo '</ol></div>';
  }
}
?>