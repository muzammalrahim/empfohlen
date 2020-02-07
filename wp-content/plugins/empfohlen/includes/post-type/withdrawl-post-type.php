<?php
/**
 * Custom Post Type Withdrawl
 * Created by creativedev.
 * User: arsalan
 * Date: 28/01/2020
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function empfohlen_get_withdrawl_capabilities() {

    $caps = array(
        // meta caps (don't assign these to roles)
        // 'create_post'            => 'create_withdrawl',
        'edit_post'              => 'edit_withdrawl',
        'read_post'              => 'read_withdrawl',
        'delete_post'            => 'delete_withdrawl',
        // primitive/meta caps
        'create_posts'           => 'create_withdrawls',
        // primitive caps used outside of map_meta_cap()
       'edit_posts'             => 'edit_withdrawls',
       'publish_posts'          => 'publish_withdrawls',
        // primitive caps used inside of map_meta_cap()
        'read'                   => 'read',
        'delete_posts'           => 'delete_withdrawls',
    );
    return apply_filters( 'empfohlen_get_withdrawl_capabilities', $caps );
}

if( !function_exists( 'empfohlen_withdrawl_post_type' ) ){
    function empfohlen_withdrawl_post_type(){
         $labels = array(
		'name'                  => _x( 'Withdrawls', 'Post Type General Name', 'emp' ),
		'singular_name'         => _x( 'Withdrawl', 'Post Type Singular Name', 'emp' ),
		'menu_name'             => __( 'Withdrawl', 'emp' ),
		'name_admin_bar'        => __( 'Withdrawl', 'emp' ),
		'archives'              => __( 'Withdrawl Archives', 'emp' ),
		'attributes'            => __( 'Withdrawl Attributes', 'emp' ),
		'parent_item_colon'     => __( 'Parent Withdrawl:', 'emp' ),
		'all_items'             => __( 'All Withdrawls', 'emp' ),
		'add_new_item'          => __( 'Add New Withdrawl', 'emp' ),
		'add_new'               => __( 'Add New Withdrawl', 'emp' ),
		'new_item'              => __( 'New Withdrawl', 'emp' ),
		'edit_item'             => __( 'Edit Withdrawl', 'emp' ),
		'update_item'           => __( 'Update Withdrawl', 'emp' ),
		'view_item'             => __( 'View Withdrawl', 'emp' ),
		'view_items'            => __( 'View Withdrawls', 'emp' ),
		'search_items'          => __( 'Search Withdrawls', 'emp' ),
		'not_found'             => __( 'Withdrawl Not found', 'emp' ),
		'not_found_in_trash'    => __( 'Withdrawl Not found in Trash', 'emp' ),
		'featured_image'        => __( 'Featured Image', 'emp' ),
		'set_featured_image'    => __( 'Set featured image', 'emp' ),
		'remove_featured_image' => __( 'Remove featured image', 'emp' ),
		'use_featured_image'    => __( 'Use as featured image', 'emp' ),
		'insert_into_item'      => __( 'Insert into item', 'emp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emp' ),
		'items_list'            => __( 'withdrawls list', 'emp' ),
		'items_list_navigation' => __( 'withdrawls list navigation', 'emp' ),
		'filter_items_list'     => __( 'Filter withdrawls list', 'emp' ),
	);
	 
	 $args = array(
            'label'                 => __( 'Withdrawl', 'emp' ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_in_menu' => 'empfohlen',
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'capabilities'    => empfohlen_get_withdrawl_capabilities(),
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 14,
            'supports'              => array( 'title', 'comments' ),
        );


	register_post_type( 'withdrawl', $args );

    }
}
add_action( 'init', 'empfohlen_withdrawl_post_type' );




// add_action('admin_menu', 'dmin_menu_withdrawl'); 
// function dmin_menu_withdrawl() { 
//     add_submenu_page(
//     		'empfohlen', 
//     		'Withdrawls', 'EMP Withdrawls', 
//     		'manage_options', 
//     		'edit.php?post_type=withdrawl'); 
// }





function add_withdrawl_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_withdrawl' ); 
    $admins->add_cap( 'read_withdrawl' ); 
    $admins->add_cap( 'delete_withdrawl' ); 
    $admins->add_cap( 'create_withdrawls' ); 
    $admins->add_cap( 'edit_withdrawls' ); 
    $admins->add_cap( 'publish_withdrawls' ); 
    $admins->add_cap( 'delete_withdrawls' ); 
    $admins->add_cap( 'publish_withdrawls' ); 

}
add_action( 'admin_init', 'add_withdrawl_caps');






