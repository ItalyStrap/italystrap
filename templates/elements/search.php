<?php

declare(strict_types=1);

namespace ItalyStrap;

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
