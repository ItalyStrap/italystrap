<?php
/**
 * @link http://mkoerner.de/breadcrumbs-for-wordpress-themes-with-bootstrap-3/
 * Bootstrap breadcrumbs for wordpress modified by Enea Overclokk
 */
function create_breadcrumbs() {

  global $post;
  $categories = get_the_category($post->ID);

  if(!is_home() || !is_front_page()) {

    echo '<div itemscope itemtype="http://schema.org/WebPage"><ol class="breadcrumb" itemprop="breadcrumb">';
    echo '<li><a href="' . home_url() . '">Home</a></li>';

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
      echo'<li>'. __('Archive for ', 'ItalyStrap');
      the_time('F jS, Y');
      echo'</li>';

    } elseif (is_month()) {
      echo'<li>'. __('Archive for ', 'ItalyStrap');
      the_time('F, Y');
      echo'</li>';

    } elseif (is_year()) {
      echo'<li>' . __('Archive for ', 'ItalyStrap');
      the_time('Y');
      echo'</li>';

    } elseif (is_author()) {
      echo'<li>' . __('Author Archives', 'ItalyStrap') . '</li>';

    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
      echo '<li>' . __('Blog Archives', 'ItalyStrap');
      echo'</li>';

    } elseif (is_search()) {
      echo'<li>' . __('Search Results', 'ItalyStrap');
      echo'</li>';

    }
    echo '</ol></div>';
  }
}
?>