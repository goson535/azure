<?php
function create_casino() {
	$casino_slug = get_option( '_casino_slug' );
	$labels      = array(
		'name'                  => __( 'Casino', 'jgambling' ),
		'singular_name'         => __( 'Casino', 'jgambling' ),
		'menu_name'             => __( 'Casino', 'jgambling' ),
		'name_admin_bar'        => __( 'Casino', 'jgambling' ),
		'archives'              => __( 'Casino Archive', 'jgambling' ),
		'attributes'            => __( 'Attributes', 'jgambling' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jgambling' ),
		'all_items'             => __( 'All casino', 'jgambling' ),
		'add_new_item'          => __( 'Add casino', 'jgambling' ),
		'add_new'               => __( 'Add casino', 'jgambling' ),
		'new_item'              => __( 'Add casino', 'jgambling' ),
		'edit_item'             => __( 'Edit casino', 'jgambling' ),
		'update_item'           => __( 'Update casino', 'jgambling' ),
		'view_item'             => __( 'View casino', 'jgambling' ),
		'view_items'            => __( 'View casino', 'jgambling' ),
		'search_items'          => __( 'Find', 'jgambling' ),
		'not_found'             => __( 'Nothing found', 'jgambling' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jgambling' ),
		'featured_image'        => __( 'Thumbnail', 'jgambling' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jgambling' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jgambling' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jgambling' ),
		'insert_into_item'      => __( 'Paste', 'jgambling' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jgambling' ),
		'items_list'            => __( 'Items list', 'jgambling' ),
		'items_list_navigation' => __( 'Items list navigation', 'jgambling' ),
		'filter_items_list'     => __( 'Filter items list', 'jgambling' ),
	);
	$args        = array(
		'label'               => __( 'Casino', 'jgambling' ),
		'description'         => __( 'Casino', 'jgambling' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-sos',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	if ( $casino_slug ) {
		$args['rewrite'] = array( 'slug' => $casino_slug );
	}
	register_post_type( 'casino', $args );

}

add_action( 'init', 'create_casino', 0 );

//Slots

function create_slots() {


	$slot_slug = get_option( '_slot_slug' );
	$labels    = array(
		'name'                  => __( 'Slots', 'jgambling' ),
		'singular_name'         => __( 'Slots', 'jgambling' ),
		'menu_name'             => __( 'Slots', 'jgambling' ),
		'name_admin_bar'        => __( 'Slots', 'jgambling' ),
		'archives'              => __( 'Slots Archive', 'jgambling' ),
		'attributes'            => __( 'Attributes', 'jgambling' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jgambling' ),
		'all_items'             => __( 'All slots', 'jgambling' ),
		'add_new_item'          => __( 'Add slot', 'jgambling' ),
		'add_new'               => __( 'Add slot', 'jgambling' ),
		'new_item'              => __( 'Add slot', 'jgambling' ),
		'edit_item'             => __( 'Edit slots', 'jgambling' ),
		'update_item'           => __( 'Update slots', 'jgambling' ),
		'view_item'             => __( 'View slot', 'jgambling' ),
		'view_items'            => __( 'View slot', 'jgambling' ),
		'search_items'          => __( 'Find', 'jgambling' ),
		'not_found'             => __( 'Nothing found', 'jgambling' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jgambling' ),
		'featured_image'        => __( 'Thumbnail', 'jgambling' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jgambling' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jgambling' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jgambling' ),
		'insert_into_item'      => __( 'Paste', 'jgambling' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jgambling' ),
		'items_list'            => __( 'Items list', 'jgambling' ),
		'items_list_navigation' => __( 'Items list navigation', 'jgambling' ),
		'filter_items_list'     => __( 'Filter items list', 'jgambling' ),
	);
	$args      = array(
		'label'               => __( 'Slots', 'jgambling' ),
		'description'         => __( 'Slots', 'jgambling' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-star-filled',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',

	);
	if ( $slot_slug ) {
		$args['rewrite'] = array( 'slug' => $slot_slug );
	}
	register_post_type( 'slots', $args );

}

add_action( 'init', 'create_slots', 0 );

//Bonuses

function create_bonus() {

	$bonus_slug = get_option( '_bonus_slug' );
	$labels = array(
		'name'                  => __( 'Bonuses', 'jgambling' ),
		'singular_name'         => __( 'Bonuses', 'jgambling' ),
		'menu_name'             => __( 'Bonuses', 'jgambling' ),
		'name_admin_bar'        => __( 'Bonuses', 'jgambling' ),
		'archives'              => __( 'Bonuses Archive', 'jgambling' ),
		'attributes'            => __( 'Attributes', 'jgambling' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jgambling' ),
		'all_items'             => __( 'All Bonuses', 'jgambling' ),
		'add_new_item'          => __( 'Add bonus', 'jgambling' ),
		'add_new'               => __( 'Add bonus', 'jgambling' ),
		'new_item'              => __( 'Add bonus', 'jgambling' ),
		'edit_item'             => __( 'Edit bonus', 'jgambling' ),
		'update_item'           => __( 'Update bonus', 'jgambling' ),
		'view_item'             => __( 'View bonus', 'jgambling' ),
		'view_items'            => __( 'View bonus', 'jgambling' ),
		'search_items'          => __( 'Find', 'jgambling' ),
		'not_found'             => __( 'Nothing found', 'jgambling' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jgambling' ),
		'featured_image'        => __( 'Thumbnail', 'jgambling' ),
		'set_featured_image'    => __( 'Use as Thumbnail', 'jgambling' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jgambling' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jgambling' ),
		'insert_into_item'      => __( 'Paste', 'jgambling' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jgambling' ),
		'items_list'            => __( 'Items list', 'jgambling' ),
		'items_list_navigation' => __( 'Items list navigation', 'jgambling' ),
		'filter_items_list'     => __( 'Filter items list', 'jgambling' ),
	);
	$args   = array(
		'label'               => __( 'Bonuses', 'jgambling' ),
		'description'         => __( 'Bonuses', 'jgambling' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-awards',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	if ( $bonus_slug ) {
		$args['rewrite'] = array( 'slug' => $bonus_slug );
	}
	register_post_type( 'bonus', $args );

}

add_action( 'init', 'create_bonus', 0 );
