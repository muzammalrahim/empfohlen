<?php
/**
 * Custom Post Type Request
 * Created by creativedev.
 * User: arsalan
 * Date: 28/01/2020
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function empfohlen_get_request_capabilities() {

    $caps = array(
        // meta caps (don't assign these to roles)
        // 'create_post'            => 'create_request',
        'edit_post'              => 'edit_request',
        'read_post'              => 'read_request',
        'delete_post'            => 'delete_request',
        // primitive/meta caps
        'create_posts'           => 'create_requests',
        // primitive caps used outside of map_meta_cap()
       'edit_posts'             => 'edit_requests',
       'publish_posts'          => 'publish_requests',
        // primitive caps used inside of map_meta_cap()
        'read'                   => 'read',
        'delete_posts'           => 'delete_requests',
    );
    return apply_filters( 'empfohlen_get_request_capabilities', $caps );
}

if( !function_exists( 'empfohlen_request_post_type' ) ){
    function empfohlen_request_post_type(){
         $labels = array(
		'name'                  => _x( 'Requests', 'Post Type General Name', 'emp' ),
		'singular_name'         => _x( 'Request', 'Post Type Singular Name', 'emp' ),
		'menu_name'             => __( 'Request', 'emp' ),
		'name_admin_bar'        => __( 'Request', 'emp' ),
		'archives'              => __( 'Request Archives', 'emp' ),
		'attributes'            => __( 'Request Attributes', 'emp' ),
		'parent_item_colon'     => __( 'Parent Request:', 'emp' ),
		'all_items'             => __( 'All Requests', 'emp' ),
		'add_new_item'          => __( 'Add New Request', 'emp' ),
		'add_new'               => __( 'Add New Request', 'emp' ),
		'new_item'              => __( 'New Request', 'emp' ),
		'edit_item'             => __( 'Edit Request', 'emp' ),
		'update_item'           => __( 'Update Request', 'emp' ),
		'view_item'             => __( 'View Request', 'emp' ),
		'view_items'            => __( 'View Requests', 'emp' ),
		'search_items'          => __( 'Search Requests', 'emp' ),
		'not_found'             => __( 'Request Not found', 'emp' ),
		'not_found_in_trash'    => __( 'Request Not found in Trash', 'emp' ),
		'featured_image'        => __( 'Featured Image', 'emp' ),
		'set_featured_image'    => __( 'Set featured image', 'emp' ),
		'remove_featured_image' => __( 'Remove featured image', 'emp' ),
		'use_featured_image'    => __( 'Use as featured image', 'emp' ),
		'insert_into_item'      => __( 'Insert into item', 'emp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emp' ),
		'items_list'            => __( 'requests list', 'emp' ),
		'items_list_navigation' => __( 'requests list navigation', 'emp' ),
		'filter_items_list'     => __( 'Filter requests list', 'emp' ),
	);
	 
	 $args = array(
            'label' => __( 'Request', 'emp' ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_in_menu' => 'empfohlen',
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'capabilities'    => empfohlen_get_request_capabilities(),
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 14,
            'supports'              => array( 'title' ),
        );


	register_post_type( 'request', $args );

    }
}
add_action( 'init', 'empfohlen_request_post_type' );




// add_action('admin_menu', 'admin_menu_request'); 
// function admin_menu_request() { 
//     add_submenu_page(
//     		'empfohlen', 
//     		'Requests', 'EMP Requests', 
//     		'manage_options', 
//     		'edit.php?post_type=request'); 
// }


 


function add_request_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_request' ); 
    $admins->add_cap( 'read_request' ); 
    $admins->add_cap( 'delete_request' ); 
    $admins->add_cap( 'create_requests' ); 
    $admins->add_cap( 'edit_requests' ); 
    $admins->add_cap( 'publish_requests' ); 
    $admins->add_cap( 'delete_requests' ); 
    $admins->add_cap( 'publish_requests' ); 

}
add_action( 'admin_init', 'add_request_caps');






