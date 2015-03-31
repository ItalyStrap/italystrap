<?php
//https://github.com/320press/wordpress-bootstrap
/*********** update standard wp tag cloud widget so it looks better ************/

add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );

function my_widget_tag_cloud_args( $args ) {
$args['number'] = 20; // show less tags
$args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
$args['smallest'] = 9.75;
$args['unit'] = 'px';
return $args;
}

// filter tag clould output so that it can be styled by CSS
function add_tag_class( $taglinks ) {
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";

    foreach( $tags as $tag ) {
     $tagn[] = preg_replace($regex, "('$1$2 label label-default tag-'.get_tag($2)->slug.'$3')", $tag );
    }

    $taglinks = implode('</a>', $tagn);

    return $taglinks;
}

add_action( 'wp_tag_cloud', 'add_tag_class' );

add_filter( 'wp_tag_cloud','wp_tag_cloud_filter', 10, 2) ;

function wp_tag_cloud_filter( $return, $args )
{
  return '<div id="tag-cloud">' . $return . '</div>';
}