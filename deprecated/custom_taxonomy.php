<?php
// function create_my_taxonomies() {

// register_taxonomy('NOMETASSONOMIA', 'page', array(
													// 'hierarchical' => false, 
													// 'label' => 'NOMETASSONOMIA',
													// 'query_var' => true,
													// 'rewrite' => true
													// ));
// }

// add_action('init', 'create_my_taxonomies', 0);

//if ( ! function_exists( 'custom_taxonomy' ) ) {

// Register Custom Taxonomy
//function custom_taxonomy() {
//
//	$labels = array(
//		'name'                       => _x( 'Taxonomies', 'Taxonomy General Name', 'text_domain' ),
//		'singular_name'              => _x( 'Taxonomy', 'Taxonomy Singular Name', 'text_domain' ),
//		'menu_name'                  => __( 'Taxonomy', 'text_domain' ),
//		'all_items'                  => __( 'All Items', 'text_domain' ),
//		'parent_item'                => __( 'Parent Item', 'text_domain' ),
//		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
//		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
//		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
//		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
//		'update_item'                => __( 'Update Item', 'text_domain' ),
//		'view_item'                  => __( 'View Item', 'text_domain' ),
//		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
//		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
//		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
//		'popular_items'              => __( 'Popular Items', 'text_domain' ),
//		'search_items'               => __( 'Search Items', 'text_domain' ),
//		'not_found'                  => __( 'Not Found', 'text_domain' ),
//	);
//	$args = array(
//		'labels'                     => $labels,
//		'hierarchical'               => false,
//		'public'                     => true,
//		'show_ui'                    => true,
//		'show_admin_column'          => true,
//		'show_in_nav_menus'          => true,
//		'show_tagcloud'              => true,
//	);
//	register_taxonomy( 'taxonomy', array( 'prodotti', 'post' ), $args );
//
//}

// Hook into the 'init' action
// add_action( 'init', 'custom_taxonomy', 0 );

//}