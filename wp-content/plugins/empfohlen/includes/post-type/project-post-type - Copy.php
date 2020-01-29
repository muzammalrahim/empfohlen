<?php 


// Register Custom Post Type
function project_post_type() {

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
		'description'           => __( 'Project Task', 'emp' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'project', $args );

}
add_action( 'init', 'project_post_type', 0 );