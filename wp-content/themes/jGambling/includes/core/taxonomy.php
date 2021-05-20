<?php
// Deposit methods
function custom_taxonomy_deposit_method() {

	$labels = array(
		'name'                       => __( 'Deposit methods', 'jgambling' ),
		'singular_name'              => __( 'Deposit methods', 'jgambling' ),
		'menu_name'                  => __( 'Deposit methods', 'jgambling' ),
		'all_items'                  => __( 'All method', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,


	);

	if ( get_option( "_page_dm" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'deposit', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_deposit_method', 0 );

// Currency
function custom_taxonomy_currency() {

	$labels = array(
		'name'                       => __( 'Currency', 'jgambling' ),
		'singular_name'              => __( 'Currency', 'jgambling' ),
		'menu_name'                  => __( 'Currency', 'jgambling' ),
		'all_items'                  => __( 'All Currency', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_cyr" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'currency', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_currency', 0 );

// Withdrawal methods
function custom_taxonomy_cashout() {

	$labels = array(
		'name'                       => __( 'Withdrawal methods', 'jgambling' ),
		'singular_name'              => __( 'Withdrawal methods', 'jgambling' ),
		'menu_name'                  => __( 'Withdrawal methods', 'jgambling' ),
		'all_items'                  => __( 'All methods', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_cashout" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'cashout', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_cashout', 0 );


// Soft
function custom_taxonomy_soft() {

	$labels = array(
		'name'                       => __( 'Software', 'jgambling' ),
		'singular_name'              => __( 'Software', 'jgambling' ),
		'menu_name'                  => __( 'Software', 'jgambling' ),
		'all_items'                  => __( 'All soft', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_soft" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'soft', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_soft', 0 );


// R C
function custom_taxonomy_restricted() {

	$labels = array(
		'name'                       => __( 'Restricted country', 'jgambling' ),
		'singular_name'              => __( 'Restricted country', 'jgambling' ),
		'menu_name'                  => __( 'Restricted country', 'jgambling' ),
		'all_items'                  => __( 'All country', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_restricted" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'restricted', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_restricted', 0 );


// Licenses
function custom_taxonomy_license() {

	$labels = array(
		'name'                       => __( 'Casino license', 'jgambling' ),
		'singular_name'              => __( 'Casino license', 'jgambling' ),
		'menu_name'                  => __( 'Casino license', 'jgambling' ),
		'all_items'                  => __( 'All license', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_license" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'license', array( 'casino','page' ), $args );

}

add_action( 'init', 'custom_taxonomy_license', 0 );


// Soft for slots
function custom_taxonomy_soft_slots() {

	$labels = array(
		'name'                       => __( 'Soft', 'jgambling' ),
		'singular_name'              => __( 'Soft', 'jgambling' ),
		'menu_name'                  => __( 'Soft', 'jgambling' ),
		'all_items'                  => __( 'All soft', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_software" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'software', array( 'slots' ), $args );

}

add_action( 'init', 'custom_taxonomy_soft_slots', 0 );


// Bonus type
function custom_taxonomy_bonus_type() {

	$labels = array(
		'name'                       => __( 'Bonus type', 'jgambling' ),
		'singular_name'              => __( 'Bonus type', 'jgambling' ),
		'menu_name'                  => __( 'Bonus type', 'jgambling' ),
		'all_items'                  => __( 'All type', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	if ( get_option( "_page_type" ) ) {
		$args['publicly_queryable'] = false;
	}
	register_taxonomy( 'type', array( 'bonus' ), $args );

}

add_action( 'init', 'custom_taxonomy_bonus_type', 0 );

// Casino type
function custom_taxonomy_casino_type() {

	$labels = array(
		'name'                       => __( 'Casino type', 'jgambling' ),
		'singular_name'              => __( 'Casino type', 'jgambling' ),
		'menu_name'                  => __( 'Casino type', 'jgambling' ),
		'all_items'                  => __( 'All type', 'jgambling' ),
		'parent_item'                => __( 'Parent Item', 'jgambling' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jgambling' ),
		'new_item_name'              => __( 'New Item Name', 'jgambling' ),
		'add_new_item'               => __( 'Add New Item', 'jgambling' ),
		'edit_item'                  => __( 'Edit Item', 'jgambling' ),
		'update_item'                => __( 'Update Item', 'jgambling' ),
		'view_item'                  => __( 'View Item', 'jgambling' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jgambling' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jgambling' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jgambling' ),
		'popular_items'              => __( 'Popular Items', 'jgambling' ),
		'search_items'               => __( 'Search Items', 'jgambling' ),
		'not_found'                  => __( 'Not Found', 'jgambling' ),
		'no_terms'                   => __( 'No items', 'jgambling' ),
		'items_list'                 => __( 'Items list', 'jgambling' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jgambling' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);

	register_taxonomy( 'casino_type', array( 'casino' ), $args );

}

add_action( 'init', 'custom_taxonomy_casino_type', 0 );