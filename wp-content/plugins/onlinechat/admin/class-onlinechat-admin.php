<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.creativetech-solutions.com
 * @since      1.0.0
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/admin
 * @author     Hamid Raza <hamid.creativetech>
 */
class Onlinechat_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		if( is_admin() ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/setting.php';
		}
		$options = array(
			'cluster' => 'ap2',
			'useTLS' => true
		);
		$this->pushers = new Pusher\Pusher(
			'873fa5b09013497c369d',
			'85946c5c59d2d6c4ab98',
			'939606',
			$options
		);


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Onlinechat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Onlinechat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name.'-stylebot', '//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/onlinechat-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-style', plugin_dir_url( __FILE__ ) . 'css/onlinechat-admin-style.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-style-font',  'https://use.fontawesome.com/releases/v5.5.0/css/all.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-style-box', 'https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
 	 */
//	public function enqueue_styles(){
//		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/onlinechat-admin-style.css', array(), $this->version, 'all' );
//	}
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Onlinechat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Onlinechat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'bootstrapjs', '//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'dataTables', 'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'bootstrap',  'https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'pusher',  'https://js.pusher.com/5.0/pusher.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'chatbox',  'https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js', array( 'jquery' ), $this->version, false );




		// following formm user listing page
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/onlinechat-admin.js', array( 'jquery' ), $this->version, false );

	}



	//display users list  page

	function userslist_server_side_callback() {

		header("Content-Type: application/json");
		$request= $_GET;

		$columns = array(
			0 => 'user_nicename',
			1 => 'user_email',
			2 => 'status'
		);
		if ($request['order'][0]['column'] == 0) {
			$orderby = $columns[$request['order'][0]['column']];
			$order   = $request['order'][0]['dir'];
		} elseif ($request['order'][0]['column'] == 1) {
			$orderby = $columns[$request['order'][0]['column']];
			$order   = $request['order'][0]['dir'];
		}else{
			$orderby = $columns[0] ;
			$order   = 'asc';
		}
		if(!empty($request['search']['value']) && isset($request['search']['value'])){
			$searchkey = sanitize_text_field($request['search']['value']);
		}else{
			$searchkey = '';
		}
		$args = array (
			//'role'       => 'reporter',
			'search'     => '*' . $searchkey . '*',
			'search_columns' => array(
				'user_login',
				'user_nicename',
				'user_email',
				'user_url',
			),
			'orderby' => $orderby,
            'offset' => $request['start'],
            'order'   => $order,
//			'meta_query' => array(
//				'relation' => 'OR',
//				array(
//					'key'     => 'first_name',
//					'value'   => $searchkey,
//					'compare' => 'LIKE'
//				),
//				array(
//					'key'     => 'last_name',
//					'value'   => $searchkey,
//					'compare' => 'LIKE'
//				),
//			)
		);
		$wp_user_query = new WP_User_Query( $args );
		$users = $wp_user_query->get_results();
		$totalData = count($users);
		if ($users) {
			foreach ( $users as $user ) {
				$nestedData = array();
				$nestedData[] = $user->display_name;
				$nestedData[] = $user->user_email;
				$nestedData[] = '<buttton class="offline_button">OFFLINE</buttton>';// ONLINE <buttton class="online_button">ONLINE</buttton>
				$data[] = $nestedData;
			}
			$json_data = array(
				"draw" => intval($request['draw']),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => $data
			);
			echo json_encode($json_data);
		} else {
			$json_data = array(
				"draw" => intval($request['draw']),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => array()
			);
			echo json_encode($json_data);
		}
		wp_die();
	}
	// chat messages page display users list
	function online_userslist_server_side_callback() {
		global $wpdb;
		header("Content-Type: application/json");
		$request= $_GET;
		$columns = array(
			0 => 'user_nicename',
			//1 => 'user_email',
			2 => 'status'
		);
		if ($request['order'][0]['column'] == 0) {
			$orderby = $columns[$request['order'][0]['column']];
			$order   = $request['order'][0]['dir'];
		} elseif ($request['order'][0]['column'] == 1) {
			$orderby = $columns[$request['order'][0]['column']];
			$order   = $request['order'][0]['dir'];
		}else{
			$orderby = $columns[0] ;
			$order   = 'asc';
		}

		if(!empty($request['search']['value']) && isset($request['search']['value'])){
			$searchkey = sanitize_text_field($request['search']['value']);
		}else{
			$searchkey = '';
		}
		$args = array (
			//'role'       => 'reporter',
			'search'     => '*' . $searchkey . '*',
			'search_columns' => array(
				'user_login',
				'user_nicename',
				'user_email',
				'user_url',
			),
			'orderby' => $orderby,
			'offset' => $request['start'],
			'order'   => $order,
//			'meta_query' => array(
//				'relation' => 'OR',
//				array(
//					'key'     => 'first_name',
//					'value'   => $searchkey,
//					'compare' => 'LIKE'
//				),
//				array(
//					'key'     => 'last_name',
//					'value'   => $searchkey,
//					'compare' => 'LIKE'
//				),
//			)
		);
		$wp_user_query = new WP_User_Query( $args );
		$users = $wp_user_query->get_results();

		$totalData = count($users);
		$current_user_login_user = wp_get_current_user();
		$current_user_login_user = ( isset( $current_user_login_user->ID ) ? (int) $current_user_login_user->ID : 0 );
		if ($users) {

			foreach ( $users as $user ) {
				$lastseen = get_user_meta($user->ID,  $key= 'last_login',  $single = true ) ;
				$lastseen =  $lastseen ? human_time_diff($lastseen) : '';
				if($user->ID == $current_user_login_user)continue;
				$result = $wpdb->get_results("SELECT r1.room_id FROM {$wpdb->prefix}conversation_members r1 JOIN {$wpdb->prefix}conversation_members r2 
						  ON r1.room_id = r2.room_id WHERE r1.user_id = $user->ID AND r2.user_id = $current_user_login_user");
				if($result[0] && !empty($result[0])){
					$room =  $result[0]->room_id;
				}else{
					$wpdb->insert($wpdb->prefix.'chat_room',array('status'=> 1));
					$room = $wpdb->insert_id;
					$wpdb->insert($wpdb->prefix.'conversation_members',
						array(
							'room_id' => $room,
							'status'  => 1,
							'user_id' => $current_user_login_user,
						)
					);
					$wpdb->insert($wpdb->prefix.'conversation_members',
						array(
							'room_id' => $room,
							'status' => 1,
							'user_id'=> $user->ID,
						)
					);
				}
				$notifications = $wpdb->get_results("SELECT count(notifications) as total FROM {$wpdb->prefix}conversations WHERE room_id = $room AND receiver = $current_user_login_user AND notifications = 1");
				$totalNoti = $notifications ? $notifications[0]->total : 0;
				$NotiClass = $totalNoti < 1  ? 'hidden' : '';
				$nestedData = array(); // default status will be inactive and changed when user will open message
				$nestedData[] = '<li class="displayusers" data-status="active"><div class="d-flex bd-highlight"> 
											<div class="img_cont">
                                    			<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                                    				<span class="online_icon offline" data-id="'. $user->ID .'" data-c="'.$room.'"></span>
                                			</div>
                                			<div class="user_info">
                                    			<span class="user_name">'.$user->display_name.' </span><p class="is_typing"></p>
                                    			<p class="last_status">Last Seen '. $lastseen .' ago</p>
                                			</div>
                                			<div class="counter">                                    			 
                                    			<p class="counter_messages '.$NotiClass.'">'. $totalNoti .'</p>
                                			</div>
                            			</div>
                            		</li>';
				$nestedData[] = $user->display_name;
				$data[] = $nestedData;
			}
			$json_data = array(
				"draw" => intval($request['draw']),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => $data
			);
			echo json_encode($json_data);
		} else {
			$json_data = array(
				"draw" => intval($request['draw']),
				"recordsTotal" => intval($totalData),
				"recordsFiltered" => intval($totalData),
				"data" => array()
			);
			echo json_encode($json_data);
		}
		wp_die();
	}

	// Updates users Notifications
     function update_notifications_callback(){
		 global $wpdb;
		 $user = wp_get_current_user();
		 $receiver = ( isset( $user->ID ) ? (int) $user->ID : 0 );
		 $room = (int) $_POST['room_id'];
		 $status = $_POST['status'];
		 $user_id = $_POST['user_id'];
		 $data  = array(
				 'room'    => $room,
				 'status'    => $status,
				 'events' =>  'status',
				 'sender' =>  $user_id,
		 );
		 $this->pushers->trigger('my-channel'.$room, 'my-event', $data);
		 $notifications = $wpdb->get_results("SELECT count(notifications) as total FROM {$wpdb->prefix}conversations WHERE room_id = $room AND receiver = $receiver AND notifications = 1");
		 $totalNoti = $notifications ? $notifications[0]->total : 0;
		 if($totalNoti > 0){
			 if(isset($room) && !empty($room)) {
				 $wpdb->update($wpdb->prefix.'conversations', array('notifications'=>'0'), array('room_id' => $room,'receiver' => $receiver));
				 $data = array('room'=>$room);
				 $results = json_encode($data);
				 echo $results;
				 wp_die();
			 }
		 }

	 }
	// Send / receive and save user chat
	function users_messages_callback(){
		global $wpdb;
		$user = wp_get_current_user();
		$sender = ( isset( $user->ID ) ? (int) $user->ID : 0 );
		$receiver = $_POST['to'];
		$room = (int) $_POST['room_id'];
		if(isset($_POST['message']) && !empty($_POST['message']) &&!empty($room)) {
		 	$wpdb->insert(
				$wpdb->prefix.'conversations',
				array(
					'room_id'     => $room,
					'sender'    => (int) $sender,
					'receiver' => (int) $receiver,
					'notifications'   => 1,
					'message'   => $_POST['message'],
					'status'      => 0
				)
		 	);
			$data  = array(
				'room'     => $room,
				'message' => $_POST['message'],
				'sender'  => $sender,
				'events'  => 'message',
			);
        	$this->pushers->trigger('my-channel'.$room, 'my-event', $data);
		}
	}

	function get_users_messages_callback(){ // Get Users chat

		global $wpdb;
		$user = wp_get_current_user();
		$sender = ( isset( $user->ID ) ? (int) $user->ID : 0 );
		$room_id = (int) $_POST['room'];
		$OffSet = (int) $_POST['OffSet'];
		if($room_id) {
			$result = $wpdb->get_results("SELECT *  FROM {$wpdb->prefix}conversations WHERE room_id = $room_id ORDER BY id DESC  limit 15  OFFSET $OffSet");
			$messages = $wpdb->get_results("SELECT count(id) AS total  FROM {$wpdb->prefix}conversations WHERE room_id = $room_id");
			if ($result) {
				$data['sender'] = $sender;
				$data['data'] = $result;
				$data['total'] = $messages[0]->total;
				$results = json_encode($data);
				echo $results;
				die();// must use to return data to ajax functions
			} else {
				$data['chat_room'] = (int)$room_id;
				$data['total'] = $messages[0]->total;
				$results = json_encode($data);
				echo $results;
				die();// must use to return data to ajax functions
			}
		}
	}



		// Online Chate menus
	function admin_chat_menu(){
		add_menu_page('Live Chat setting', 'Live Chat', 'manage_options', 'live_chat', array($this,'setting_page'));
		add_submenu_page(
			'live_chat',
			'Users List', //page title
			'Users List', //menu title
			'manage_options', //capability,
			'userslist',//menu slug
			array($this,'userslist') //callback function
		);
		add_submenu_page(
			'live_chat',
			'Messages', //page title
			'Messages', //menu title
			'manage_options', //capability,
			'messages',//menu slug
			array($this,'messages') //callback function
		);
	}

	function setting_page()
	{
		include_once 'setting.php';
	}
	function userslist()
	{
		include_once 'partials/users/userslist.php'; // later will use for all users listing
	}
	function messages()
	{
		include_once 'partials/users/messages.php'; // live chat messages
	}


	//Short Code for users and omline users listing started

	public function register_chat_shortcodes() {
		add_shortcode( 'users_list', array( $this, 'users_list_datatable') );
		add_shortcode( 'online_users_list_short_code', array( $this, 'online_users_lists') );
	}


	function online_users_lists() {
		users_datatables_scripts(); ?>
			<table id="onlineusers" class="">
				<thead style="display: none;">
				<tr>
					<th>User Name </th>
					<th>Status</th>
				</tr>
				</thead>
			</table>
		<?php
	}
	function users_list_datatable() {
		users_datatables_scripts();
		ob_start(); ?>

		<div class="wrap">
			<h1 class="wp-heading-inline">  Users </h1>
			<hr class="wp-header-end">
			<table id="userslist" class="table table-striped table-hover">
				<thead>
				<tr>
					<th>User Name </th>
					<th>Email</th>
					<th>Status</th>
				</tr>
				</thead>
			</table>
			<br class="clear">
		</div>

		<?php
		return ob_get_clean();
	}

}
