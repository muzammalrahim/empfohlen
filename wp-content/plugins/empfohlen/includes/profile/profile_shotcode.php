<?php if ( ! defined( 'ABSPATH' ) ) exit; 
//Exit if accessed directly 

 
// usage: $result = get_empfohlen_form_profile();
function get_empfohlen_form_profile($redirect=false) {
  if (is_user_logged_in()){  
    require_once EMPFOHLEN_DIR . 'public/partials/profile/profile.php';
  } 
}
// print form #1
/* usage: <?php the_empfohlen_form_profile(); ?> */
function the_empfohlen_form_profile($redirect=false) {
  echo get_empfohlen_form_profile($redirect);
}
// shortcode for form #1
// usage: [empfohlen_form_profile] in post/page content
add_shortcode('empfohlen_form_profile','empfohlen_form_profile_shortcode');
function empfohlen_form_profile_shortcode ($atts,$content=false) {
  $atts = shortcode_atts(array(), $atts);
  return get_empfohlen_form_profile($atts);
}
  





add_action( 'init', 'emp_profile_save' );
function emp_profile_save(){
  if( isset( $_POST['action'] ) && $_POST['action'] == 'edit_profile' ){
  	// echo "  emp_profile_save "; exit; 


  	// global $error;
  	// echo "<pre> _POST "; print_r( $_POST ); echo "</pre> ";  

 		// Verify nonce
    if( !isset( $data_params['emp_profile_nonce'] ) || !wp_verify_nonce( $data_params['emp_profile_nonce'], 'emp-1register-nonce' ) ){ 
          $error['emp_profile'][] =  'Ooops, something went wrong, please try again later';
          // exit; 
    }


  	 // WordPress environment
		 // require( dirname(__FILE__) . '/../../../wp-load.php' );

  	$current_user = wp_get_current_user();
  	$userData = $current_user->data;
  	$user_id = $userData->ID;
  	$postData = $_POST;
  	 // echo "<pre> userData "; print_r( $userData ); echo "</pre> ";  
  	 //exit; 

  	


  	if(!empty( $postData['emp_user_first'] )){
  		$userData->display_name = $postData['emp_user_first'];
  	}

  	if(!empty( $postData['emp_user_last'] )){
  		$userData->user_nicename = $postData['emp_user_first'];
  	}

  	if(!empty( $postData['emp_user_email'] )){
  		$userData->user_email = $postData['emp_user_email'];
  	}

  	// $userData->save();
  	 // echo "<pre>  userData "; print_r( $userData ); echo "</pre> ";  // exit; 
   	 $user_data = wp_update_user( $userData  );


  	// user meta data.

  	//
  	if(isset( $postData['emp_user_address'] )){
  		update_user_meta( $user_id, 'address', $postData['emp_user_address'] );
  	}


  	if(isset( $postData['tax_skill'] )){
  		update_user_meta( $user_id, 'tax_skill', $postData['tax_skill'] );
  	}


  	if(isset( $postData['emp_user_birthday'] )){
  		update_user_meta( $user_id, 'birthday', $postData['emp_user_birthday'] );
  	}


// 


  	$profilepicture = $_FILES['profilepicture'];
  	 // echo "<pre>  profilepicture "; print_r( $profilepicture ); echo "</pre> ";  exit; 
  	if(!empty($profilepicture)  && empty($profilepicture['error'])  ){

  				require_once(ABSPATH . 'wp-load.php');
					$wordpress_upload_dir = wp_upload_dir();

					
					$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];

					 // echo "<pre> profilepicture "; print_r( $profilepicture ); echo "</pre> ";  
					 // echo "<pre> _FILES "; print_r( $_FILES ); echo "</pre> "; 
					 // exit; 

					$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );


					$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
					// looks like everything is OK
					if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
					 
								$upload_id = wp_insert_attachment( array(
									'guid'           => $new_file_path, 
									'post_mime_type' => $new_file_mime,
									'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
									'post_content'   => '',
									'post_status'    => 'inherit'
								), $new_file_path );
							 
								// wp_generate_attachment_metadata() won't work if you do not include this file
								require_once( ABSPATH . 'wp-admin/includes/image.php' );
							 
								// Generate and save the attachment metas into the database
								wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
							 	

							 	update_user_meta( $user_id, 'profile_image',  $wordpress_upload_dir['url'] . '/' . basename( $new_file_path )  );
								// Show the uploaded file in browser
								// wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
					 
					}

  	}

		

 


  	 //exit; 

  }
}
 
// function emp_reg_new_user() {
  
//    // echo "<pre> emp_reg_new_user  _POST = "; print_r( $_POST['data'] ); echo "</pre> ";  
//    // echo "<pre>  default_role "; print_r( $default_role ); echo "</pre> ";  

//     $data_params = array();
//     parse_str($_POST['data'], $data_params);
//     // echo "<pre> data_params "; print_r(  $data_params ); echo "</pre> ";   
    
//     $return['status']   =  'initial';
//     $return['message']  =  '';

//      // echo "<pre>  emp_register_nonce = "; print_r( $data_params['emp_register_nonce'] ); echo "</pre> ";  

//     // Verify nonce
//     if( !isset( $data_params['emp_register_nonce'] ) || !wp_verify_nonce( $data_params['emp_register_nonce'], 'emp-register-nonce' ) ){
//           $return['status'] =  'error';
//           $return['message'] =  'Ooops, something went wrong, please try again later';
//           wp_send_json($return); 
//     }

//     // Post values
//     $username       = $data_params['emp_user_login'];
//     $first_name     = $data_params['emp_user_first'];
//     $last_name      = $data_params['emp_user_last'];
//     $email          = $data_params['emp_user_email'];
//     $password       = $data_params['emp_user_pass'];
//     $password_c     = $data_params['emp_user_pass_confirm'];
//     $birthday       = $data_params['emp_user_birthday'];
//     $address        = $data_params['emp_user_address'];
//     $skills         = $data_params['tax_skill'];
 

//     if ( empty($username) || empty($email)  || empty($password) || empty($password_c) )  {
//        $return['status']    =  'v_error'; 
//        $return['message']   =  'please enter all required field'; 

//         // echo "<pre> username "; print_r( $username ); echo "</pre> ";  
//         // echo "<pre> email "; print_r( $email ); echo "</pre> ";  
//         // echo "<pre> passwor "; print_r( $password ); echo "</pre> ";  
//         // echo "<pre> password_c "; print_r( $password_c ); echo "</pre> ";   

//        wp_send_json( $return); 
//     }

//     if( $password !== $password_c  ){
//        $return['status'] =  'v_error'; 
//        $return['message'] =  'password do not match'; 
//        wp_send_json( $return ); 
//     }


//     $userdata = array(
//         'user_login' => $username,
//         'user_pass'  => $password,
//         'user_email' => $email,
//         'first_name' => $first_name,
//         'nickname'   => $last_name,
//         'role'       =>  get_option('default_role', 'member'),
//     );


 
//     $user_id = wp_insert_user( $userdata ) ;
 
//     // Return
//     if( !is_wp_error($user_id) ) {
//         // echo '1';
//         $return['status'] =  'success';
//         $return['message'] =  'User succesfully created';
//         $return['user_id'] =  $user_id;
//         wp_send_json($return); 
//     } else {
//         $return['status'] =  'error';
//         $return['message'] =  $user_id->get_error_message();
//         wp_send_json( $return); 
//     }
//   die();
// }
 
// add_action('wp_ajax_emp_emp_profile_save', 'emp_profile_save');
// add_action('wp_ajax_nopriv_emp_register_user', 'emp_profile_save');

//  