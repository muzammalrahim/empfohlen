 <?php if ( ! defined( 'ABSPATH' ) ) exit; 

class MemberPageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new MemberPageTemplater();
		}

		return self::$instance;

	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data',
			array( $this, 'register_project_templates' )
		);


		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter(
			'template_include',
			array( $this, 'view_project_template')
		);


		// Add your templates to this array.
		$this->templates = array('member-template.php' => 'MemberDashboard',);

	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {
		// Return the search template if we're searching (instead of the template for the first result)
		if ( is_search() ) {
			return $template;
		}

		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] ) ) {
			return $template;
		}

		// Allows filtering of file path
		$filepath = apply_filters( 'page_templater_plugin_dir_path', plugin_dir_path( __FILE__ ) );

		$file =  $filepath . get_post_meta(
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

}
add_action( 'plugins_loaded', array( 'MemberPageTemplater', 'get_instance' ) );









// add_action( 'wp_enqueue_scripts', 'my_scripts' );
// function my_scripts() {
//   wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array('jquery'), '1.0.0', true );
//   wp_localize_script( 'script-name', 'MyAjax', array(
//     'ajaxurl' => admin_url( 'admin-ajax.php' ),
//     'security' => wp_create_nonce( 'my-special-string' )
//   ));
// }
 
add_action( 'wp_ajax_project_submit_request', 'project_submit_request_callback' );
add_action( 'wp_ajax_nopriv_project_submit_request', 'project_submit_request_callback' );
function project_submit_request_callback() {
  // check_ajax_referer( 'my-special-string', 'security' );
  // echo 'It worked!';
  // die();
  // $return['login'] =  is_user_logged_in()?'yes':'no';
  if(is_user_logged_in()){

  	$current_user = wp_get_current_user();
		$userData = $current_user->data;
		$return['userData'] = $userData; 
		$user_role = $current_user->roles; // $userData;
		
		// check if user has role member
		$is_member = false; 
		if(is_array($user_role)){
			$is_member = (in_array('member', $user_role)) ? true : false; 
		}else{
			$is_member = ($user_role == 'member') ? true : false; 
		}

		if(!$is_member){
				$return['status'] =  'error'; 
      	$return['message'] =  'Only members can submit a request '; 
      	wp_send_json( $return ); 
		}

		$project_id = isset($_POST['pid'])?((int)$_POST['pid']):0;
		$project   = get_post( $project_id );

		// if project does not exist 
		if(is_null($project) || empty($project)){ 
			$return['status'] =  'error'; 
      $return['message'] =  'Project with id :'.$project_id.' does not exist'; 
      wp_send_json( $return ); 
		} 

		if( $project->post_type !== 'project' ){
			$return['status'] =  'error'; 
      $return['message'] =  'Project with id :'.$project_id.' does not exist.'; 
      wp_send_json( $return );
		}

		// check if member is allowed to submit request for this project. 
		 $p_members_ids = get_field( "members", $project->ID );
		 $is_member_can_request = false; 
		 if(is_array($p_members_ids)){
			$is_member_can_request = (in_array($userData->ID, $p_members_ids)) ? true : false; 
		 }else{
			$is_member_can_request = ($p_members_ids == $userData->ID) ? true : false; 
		 }

		 if(!$is_member_can_request){
		 	$return['status'] 	=  'error'; 
      $return['message'] 	=  'You are not allowed to submit request on this Project.'; 
      wp_send_json( $return );
		 }

		 // check if user already have request for this post 

		  // WP_Query arguments
			$args = array(
				'post_type'              => array( 'request' ),
				'meta_query'             => array(
					array(
						'key'     => 'select_project_id',
						'value'   => $project->ID,
					),
					array(
						'key'     => 'member_id',
						'value'   => $userData->ID,
					),
				),
			);

			// The Query
			$req_query = new WP_Query( $args );
			$request_exist = $req_query->posts;
			// wp_send_json($request_exist);

			if(!empty($request_exist)){
					$return['status'] =  'error'; 
		      $return['message'] =  'You already submit request to this project'; 
		      wp_send_json( $return ); 
			}


		 // create a request post type. 
		 $request_id = wp_insert_post(array(
		   'post_type' => 'request',
		   'post_title' => 'Request from '.$userData->ID.' for Project: '.$project->ID,
		   'post_status' => 'publish',
		));


		 $request_id_code = 'R'.$request_id.'_U'.$userData->ID;

		if ($request_id) {
		   // insert post meta
		   update_post_meta($request_id, 'select_project_id', $project->ID);
		   update_post_meta($request_id, 'member_id', $userData->ID);
		   update_post_meta($request_id, 'request_status', 'initial');
		   update_post_meta($request_id, 'request_id', $request_id_code);
		}


		ob_start(); 
			$post = $project;
			include(EMPFOHLEN_DIR.'public/partials/member/project_row.php');
			$return['row_html']  = ob_get_clean();
		ob_end_clean();


		 
		 $return['status'] =  'success'; 
		 $return['message'] =  'Your request has been submited succesfully'; 
		 wp_send_json( $return ); 



  }else{

  	 	$return['status'] =  'error'; 
      $return['message'] =  'please login to submit request'; 
      wp_send_json( $return ); 
  }


  wp_send_json( $return ); 
}