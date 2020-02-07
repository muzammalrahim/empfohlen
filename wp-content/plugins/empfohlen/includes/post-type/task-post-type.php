<?php
/**
 * Custom Post Type Task
 * Created by creativedev.
 * User: arsalan
 * Date: 28/01/2020
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


function empfohlen_get_task_capabilities() {

    $caps = array(
        // meta caps (don't assign these to roles)
        // 'create_post'            => 'create_task',
        'edit_post'              => 'edit_task',
        'read_post'              => 'read_task',
        'delete_post'            => 'delete_task',
        // primitive/meta caps
        'create_posts'           => 'create_tasks',
        // primitive caps used outside of map_meta_cap()
       'edit_posts'             => 'edit_tasks',
       'publish_posts'          => 'publish_tasks',
        // primitive caps used inside of map_meta_cap()
        'read'                   => 'read',
        'delete_posts'           => 'delete_tasks',
    );
    return apply_filters( 'empfohlen_get_task_capabilities', $caps );
}

if( !function_exists( 'empfohlen_task_post_type' ) ){
    function empfohlen_task_post_type(){
         $labels = array(
		'name'                  => _x( 'Tasks', 'Post Type General Name', 'emp' ),
		'singular_name'         => _x( 'Task', 'Post Type Singular Name', 'emp' ),
		'menu_name'             => __( 'Task', 'emp' ),
		'name_admin_bar'        => __( 'Task', 'emp' ),
		'archives'              => __( 'Task Archives', 'emp' ),
		'attributes'            => __( 'Task Attributes', 'emp' ),
		'parent_item_colon'     => __( 'Parent Task:', 'emp' ),
		'all_items'             => __( 'All Tasks', 'emp' ),
		'add_new_item'          => __( 'Add New Task', 'emp' ),
		'add_new'               => __( 'Add New Task', 'emp' ),
		'new_item'              => __( 'New Task', 'emp' ),
		'edit_item'             => __( 'Edit Task', 'emp' ),
		'update_item'           => __( 'Update Task', 'emp' ),
		'view_item'             => __( 'View Task', 'emp' ),
		'view_items'            => __( 'View Tasks', 'emp' ),
		'search_items'          => __( 'Search Tasks', 'emp' ),
		'not_found'             => __( 'Task Not found', 'emp' ),
		'not_found_in_trash'    => __( 'Task Not found in Trash', 'emp' ),
		'featured_image'        => __( 'Featured Image', 'emp' ),
		'set_featured_image'    => __( 'Set featured image', 'emp' ),
		'remove_featured_image' => __( 'Remove featured image', 'emp' ),
		'use_featured_image'    => __( 'Use as featured image', 'emp' ),
		'insert_into_item'      => __( 'Insert into item', 'emp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emp' ),
		'items_list'            => __( 'tasks list', 'emp' ),
		'items_list_navigation' => __( 'tasks list navigation', 'emp' ),
		'filter_items_list'     => __( 'Filter tasks list', 'emp' ),
	);
	 
	 $args = array(
            'label' => __( 'Task', 'emp' ),
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_in_menu' => 'empfohlen',
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'capabilities'    => empfohlen_get_task_capabilities(),
            'menu_icon' => 'dashicons-businessman',
            'menu_position' => 14,
            'supports'              => array( 'title' ),
        );


	register_post_type( 'task', $args );

    }
}
add_action( 'init', 'empfohlen_task_post_type' );



 
 


function add_task_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_task' ); 
    $admins->add_cap( 'read_task' ); 
    $admins->add_cap( 'delete_task' ); 
    $admins->add_cap( 'create_tasks' ); 
    $admins->add_cap( 'edit_tasks' ); 
    $admins->add_cap( 'publish_tasks' ); 
    $admins->add_cap( 'delete_tasks' ); 
    $admins->add_cap( 'publish_tasks' ); 

}
add_action( 'admin_init', 'add_task_caps');





 
/* Filter the single_template with our custom function*/
add_filter('single_template', 'my_custom_task_template', 99 );
// add_filter('single_task', 'my_custom_task_template');
function my_custom_task_template($single) {
    global $post;
     // echo "<pre> my_custom_task_template post "; print_r( $post ); echo "</pre> ";  
    /* Checks for single template by post type */
    if ( $post->post_type == 'task' ) {
        // if ( file_exists( EMPFOHLEN_DIR . 'public/partials/task.php' ) ) {
            return EMPFOHLEN_DIR . 'public/partials/task/task.php';
        // }
    }
    return $single;
}






///////////////////////////////////////////////////////////////////////////////////

add_action('parse_request', 'emp_submit_task_post', 1);
// add_action('submit_task_port', 'emp_submit_task_post', 1);
// add_action( 'init', 'emp_submit_task_post' );
function emp_submit_task_post(){
  if( isset( $_POST['action'] ) && $_POST['action'] == 'submit_task' ){

    // Verify nonce
    $is_submitted = (isset($_POST['emp_submit_task_nonce']) && wp_verify_nonce($_POST['emp_submit_task_nonce'], 'emp-submit-task-nonce')) ? true : false;
    if($is_submitted){

 


        $allowed_files_type = array(
            'text/plain',           'application/json',             'application/xml',  'application/javascript',
            'image/png',            'image/jpeg',                   'image/jpeg',       'image/gif',                'image/bmp',
            'application/zip',      'application/x-rar-compressed',
            'audio/mpeg',           'video/quicktime',              'video/quicktime',
            'application/pdf',      'image/vnd.adobe.photoshop',
            'application/msword',   'application/vnd.ms-powerpoint', 'application/vnd.ms-excel',
        );




        if ( ! session_id() ) { session_start(); }
        $_SESSION['task_error'] = array();
        $_SESSION['task_success'] = '';
        
        $postData = $_POST;
        $task = get_post( (int) $postData['task_id']);
       
        $current_user = wp_get_current_user();
        $userData = $current_user->data;
        $user_id = (int) $userData->ID;
       
        // check if task exist and not empty 
        if(empty($task)){
            $_SESSION['task_error'][] =  'Task does not exist';
            wp_redirect(esc_url_raw($_SERVER['REQUEST_URI']));
            return false; 
        }

        // check if this task is assign to this user. 
        $task_request_id = (int) get_field('request_id', $task->ID);
        $request = get_post($task_request_id);
        $req_member_id = (int) get_field('member_id', $request->ID);
        
        if ( $user_id !== $req_member_id ){
            $_SESSION['task_error'][] =  'You are not allowed to submit this task';
            wp_redirect(esc_url_raw($_SERVER['REQUEST_URI']));
            return false; 
        }

        // update acf meta data task_content
        if (isset($postData['p_t_content_editor'])) {
            $p_t_content_editor = wp_kses_post($postData['p_t_content_editor']);
            update_post_meta( $task->ID, 'task_content', $p_t_content_editor );
        }

        // update acf meta data task_content
        if (isset($postData['p_t_additional_info_editor'])) {
            $p_t_additional_info_editor = wp_kses_post($postData['p_t_additional_info_editor']);
            update_post_meta( $task->ID, 'task_additional_info', $p_t_additional_info_editor );
        }

        update_post_meta( $task->ID, 'task_status', 'submitted');


        echo "<pre> _FILES "; print_r( $_FILES ); echo "</pre> ";  
        $task_files = $_FILES['task_files'];
        if(!empty($task_files)){

            $upload_dir = wp_get_upload_dir(); 
            $dest_dir = $upload_dir['basedir'].'/userdata/'.$user_id.'/task/'.$task->ID; 

            // echo "<pre> des_dir "; print_r( $dest_dir ); echo "</pre> ";  
            if(!is_dir($dest_dir)) {  mkdir($dest_dir, 0777, true); }
            foreach ($task_files['size'] as $f_key => $fs_value) {
              $file_mime = mime_content_type( $task_files['tmp_name'][$f_key] );  
               echo "<pre> file_mime  "; print_r( $file_mime  ); echo "</pre> ";  
               if( !in_array($file_mime, $allowed_files_type) ){
                    $_SESSION['task_error'][] =  $file_mime.' files not allowed to upload';
                    continue; 
               }

                $tmp_name = $task_files["tmp_name"][$f_key];
                $name = basename($task_files["name"][$f_key]);
                move_uploaded_file($tmp_name, $dest_dir.'/'.$name);



            }
        }
       //  exit; 




        $_SESSION['task_success'] = 'Task succesfully saved';
        wp_redirect(esc_url_raw($_SERVER['REQUEST_URI']));
        exit(); 

       }else{

         if ( ! session_id() ) { session_start(); }
         $_SESSION['task_error'][] = 'Token Expired';
         wp_redirect(esc_url_raw($_SERVER['REQUEST_URI']));
         exit(); 
       }

        
     } // is_submitted
  }// function end 








 
