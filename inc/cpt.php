<?php

// Register Custom Post Type
function custom_post_type() {

    $labels = array(
		'name'                  => _x( 'Sustainability', 'Post Type General Name', 'gant' ),
		'singular_name'         => _x( 'Sustainability', 'Post Type Singular Name', 'gant' ),
		'menu_name'             => __( 'Sustainability', 'gant' ),
		'name_admin_bar'        => __( 'Sustainability', 'gant' ),
		'archives'              => __( 'Sustainability Archive', 'gant' ),
		'attributes'            => __( 'Item Attributes', 'gant' ),
		'parent_item_colon'     => __( 'Parent Challenge:', 'gant' ),
		'all_items'             => __( 'All Items', 'gant' ),
		'add_new_item'          => __( 'Add New Item', 'gant' ),
		'add_new'               => __( 'Add New', 'gant' ),
		'new_item'              => __( 'New Item', 'gant' ),
		'edit_item'             => __( 'Edit Item', 'gant' ),
		'update_item'           => __( 'Update Item', 'gant' ),
		'view_item'             => __( 'View Item', 'gant' ),
		'view_items'            => __( 'View Items', 'gant' ),
		'search_items'          => __( 'Search Item', 'gant' ),
		'not_found'             => __( 'Not found', 'gant' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'gant' ),
		'featured_image'        => __( 'Featured Image', 'gant' ),
		'set_featured_image'    => __( 'Set featured image', 'gant' ),
		'remove_featured_image' => __( 'Remove featured image', 'gant' ),
		'use_featured_image'    => __( 'Use as featured image', 'gant' ),
		'insert_into_item'      => __( 'Insert into item', 'gant' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'gant' ),
		'items_list'            => __( 'Items list', 'gant' ),
		'items_list_navigation' => __( 'Items list navigation', 'gant' ),
		'filter_items_list'     => __( 'Filter items list', 'gant' ),
	);
	$args = array(
		'label'                 => __( 'Sustainability', 'gant' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-lightbulb',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
    register_post_type( 'sustainability', $args );


}
add_action( 'init', 'custom_post_type', 0 );



function reg_cat() {
	register_taxonomy_for_object_type('category','sustainability');
}
add_action('init', 'reg_cat');