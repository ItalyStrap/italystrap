<?php

declare(strict_types=1);

/**
 * Title: Search
 * Slug: italystrap/hidden-search
 * Inserter: no
 *
 * @todo See the file templates/elements/search.php
 *       In the future try to use View to include the template file here.
 */

$attributes = [
    'label' => \esc_attr_x('Search again with the form below.', 'search form label', 'italystrap'),
    'placeholder' => \esc_attr_x('Search &hellip;', 'placeholder for search form', 'italystrap'),
    'buttonText' => \esc_attr_x('Search', 'search button text', 'italystrap'),
    'buttonPosition' => 'button-inside',
    'buttonUseIcon' => true,
    'fontSize' => 'small'
];

?>
<!-- wp:search <?= (string)\json_encode($attributes) ?> /-->
