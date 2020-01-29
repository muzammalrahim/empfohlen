<?php
/**
 * Custom Post Type Project
 * Created by creativedev.
 * User: arsalan
 * Date: 28/01/2020
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function empfohlen_get_project_capabilities() {

    $caps = array(
        // meta caps (don't assign these to roles)
        // 'create_post'            => 'create_project',
        'edit_post'              => 'edit_project',
        'read_post'              => 'read_project',
        'delete_post'            => 'delete_project',
        // primitive/meta caps
        'create_posts'           => 'create_projects',
        // primitive caps used outside of map_meta_cap()
       'edit_posts'             => 'edit_projects',
       'publish_posts'          => 'publish_projects',
        // primitive caps used inside of map_meta_cap()
        'read'                   => 'read',
        'delete_posts'           => 'delete_projects',
    );
    return apply_filters( 'empfohlen_get_project_capabilities', $caps );
}

if( !function_exists( 'empfohlen_project_post_type' ) ){
    function empfohlen_project_post_type(){
         $labels = array(
		'name'                  => _x( 'Projects', 'Post Type General Name', 'emp' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'emp' ),
		'menu_name'             => __( 'Project', 'emp' ),
		'name_admin_bar'        => __( 'Project', 'emp' ),
		'archives'              => __( 'Project Archives', 'emp' ),
		'attributes'            => __( 'Project Attributes', 'emp' ),
		'parent_item_colon'     => __( 'Parent Project:', 'emp' ),
		'all_items'             => __( 'All Projects', 'emp' ),
		'add_new_item'          => __( 'Add New Project', 'emp' ),
		'add_new'               => __( 'Add New Project', 'emp' ),
		'new_item'              => __( 'New Project', 'emp' ),
		'edit_item'             => __( 'Edit Project', 'emp' ),
		'update_item'           => __( 'Update Project', 'emp' ),
		'view_item'             => __( 'View Project', 'emp' ),
		'view_items'            => __( 'View Projects', 'emp' ),
		'search_items'          => __( 'Search Projects', 'emp' ),
		'not_found'             => __( 'Project Not found', 'emp' ),
		'not_found_in_trash'    => __( 'Project Not found in Trash', 'emp' ),
		'featured_image'        => __( 'Featured Image', 'emp' ),
		'set_featured_image'    => __( 'Set featured image', 'emp' ),
		'remove_featured_image' => __( 'Remove featured image', 'emp' ),
		'use_featured_image'    => __( 'Use as featured image', 'emp' ),
		'insert_into_item'      => __( 'Insert into item', 'emp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emp' ),
		'items_list'            => __( 'projects list', 'emp' ),
		'items_list_navigation' => __( 'projects list navigation', 'emp' ),
		'filter_items_list'     => __( 'Filter projects list', 'emp' ),
	);
	 
	 $args = array(
            'label'                 => __( 'Project', 'emp' ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_in_menu' => 'empfohlen-setting',
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'capabilities'    => empfohlen_get_project_capabilities(),
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 14,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
        );


	register_post_type( 'project', $args );

    }
}
add_action( 'init', 'empfohlen_project_post_type' );




add_action('admin_menu', 'my_admin_menu'); 
function my_admin_menu() { 
    add_submenu_page(
    		'empfohlen', 
    		'Projects', 'EMP Projects', 
    		'manage_options', 
    		'edit.php?post_type=project'); 
}





function add_project_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_project' ); 
    $admins->add_cap( 'read_project' ); 
    $admins->add_cap( 'delete_project' ); 
    $admins->add_cap( 'create_projects' ); 
    $admins->add_cap( 'edit_projects' ); 
    $admins->add_cap( 'publish_projects' ); 
    $admins->add_cap( 'delete_projects' ); 
    $admins->add_cap( 'publish_projects' ); 

}
add_action( 'admin_init', 'add_project_caps');






