<?php
/**
 * Custom Post Type Ticket
 * Created by creativedev.
 * User: arsalan
 * Date: 28/01/2020
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function empfohlen_get_ticket_capabilities() {

    $caps = array(
        // meta caps (don't assign these to roles)
        // 'create_post'            => 'create_ticket',
        'edit_post'              => 'edit_ticket',
        'read_post'              => 'read_ticket',
        'delete_post'            => 'delete_ticket',
        // primitive/meta caps
        'create_posts'           => 'create_tickets',
        // primitive caps used outside of map_meta_cap()
       'edit_posts'             => 'edit_tickets',
       'publish_posts'          => 'publish_tickets',
        // primitive caps used inside of map_meta_cap()
        'read'                   => 'read',
        'delete_posts'           => 'delete_tickets',
    );
    return apply_filters( 'empfohlen_get_ticket_capabilities', $caps );
}

if( !function_exists( 'empfohlen_ticket_post_type' ) ){
    function empfohlen_ticket_post_type(){
         $labels = array(
		'name'                  => _x( 'Tickets', 'Post Type General Name', 'emp' ),
		'singular_name'         => _x( 'Ticket', 'Post Type Singular Name', 'emp' ),
		'menu_name'             => __( 'Ticket', 'emp' ),
		'name_admin_bar'        => __( 'Ticket', 'emp' ),
		'archives'              => __( 'Ticket Archives', 'emp' ),
		'attributes'            => __( 'Ticket Attributes', 'emp' ),
		'parent_item_colon'     => __( 'Parent Ticket:', 'emp' ),
		'all_items'             => __( 'All Tickets', 'emp' ),
		'add_new_item'          => __( 'Add New Ticket', 'emp' ),
		'add_new'               => __( 'Add New Ticket', 'emp' ),
		'new_item'              => __( 'New Ticket', 'emp' ),
		'edit_item'             => __( 'Edit Ticket', 'emp' ),
		'update_item'           => __( 'Update Ticket', 'emp' ),
		'view_item'             => __( 'View Ticket', 'emp' ),
		'view_items'            => __( 'View Tickets', 'emp' ),
		'search_items'          => __( 'Search Tickets', 'emp' ),
		'not_found'             => __( 'Ticket Not found', 'emp' ),
		'not_found_in_trash'    => __( 'Ticket Not found in Trash', 'emp' ),
		'featured_image'        => __( 'Featured Image', 'emp' ),
		'set_featured_image'    => __( 'Set featured image', 'emp' ),
		'remove_featured_image' => __( 'Remove featured image', 'emp' ),
		'use_featured_image'    => __( 'Use as featured image', 'emp' ),
		'insert_into_item'      => __( 'Insert into item', 'emp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emp' ),
		'items_list'            => __( 'tickets list', 'emp' ),
		'items_list_navigation' => __( 'tickets list navigation', 'emp' ),
		'filter_items_list'     => __( 'Filter tickets list', 'emp' ),
	);
	 
	 $args = array(
            'label'                 => __( 'Ticket', 'emp' ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_in_menu' => 'empfohlen-setting',
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'capabilities'    => empfohlen_get_ticket_capabilities(),
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 14,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
        );


	register_post_type( 'ticket', $args );

    }
}
add_action( 'init', 'empfohlen_ticket_post_type' );




add_action('admin_menu', 'ticket_admin_menu'); 
function ticket_admin_menu() { 
    add_submenu_page(
    		'empfohlen', 
    		'Tickets', 'EMP Tickets', 
    		'manage_options', 
    		'edit.php?post_type=ticket'); 
}





function add_ticket_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_ticket' ); 
    $admins->add_cap( 'read_ticket' ); 
    $admins->add_cap( 'delete_ticket' ); 
    $admins->add_cap( 'create_tickets' ); 
    $admins->add_cap( 'edit_tickets' ); 
    $admins->add_cap( 'publish_tickets' ); 
    $admins->add_cap( 'delete_tickets' ); 
    $admins->add_cap( 'publish_tickets' ); 

}
add_action( 'admin_init', 'add_ticket_caps');






