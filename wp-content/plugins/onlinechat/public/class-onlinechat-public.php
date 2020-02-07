<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.creativetech-solutions.com
 * @since      1.0.0
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/public
 * @author     Hamid Raza <hamid.creativetech>
 */
class Onlinechat_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	protected  $pushers;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
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
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/onlinechat-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/onlinechat-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'pusher',  'https://js.pusher.com/5.0/pusher.min.js', array( 'jquery' ), $this->version, false );

	}
	public function register_chat_shortcodes() {
		add_shortcode( 'chat_box', array( $this, 'display_chat_box') );
	}
	function display_chat_box(){


		?>

		<div class="fabs">
			<div class="chat">
				<div class="chat_header">
					<div class="chat_option">
						<div class="header_img">
							<img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
						</div>
						<span id="chat_head">Jane Doe</span> <br> <span class="agent">Agent</span> <span class="online">(Online)</span>
						<span id="chat_fullscreen_loader" class="chat_fullscreen_loader"><i class="fullscreen zmdi zmdi-window-maximize"></i></span>
					</div>
				</div>
				<div id="chat_converse" class="chat_conversion chat_converse">
      				<span class="chat_msg_item chat_msg_item_admin">
            			<div class="chat_avatar">
							<img src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg"/>
						</div>
						Hey there! Any question?
					</span>
      				<span class="chat_msg_item chat_msg_item_user">
           					 Hello!
					</span>
					<span class="status">20m ago</span>
				</div>
				<div class="fab_field">
					<a id="fab_camera" class="fab"><i class="zmdi zmdi-camera"></i></a>
					<a id="fab_send" class="fab"><i class="zmdi zmdi-mail-send"></i></a>
					<textarea id="chatSend" name="chat_message" placeholder="Send a message" class="chat_field chat_message"></textarea>
				</div>
			</div>
			<a id="prime" class="fab"><i class="prime zmdi zmdi-comment-outline"></i></a>
		</div>
		<?php
	}

	function myplugin_auth_login ($user, $password) {

		update_user_meta( $user->ID, 'last_login', time() ); //add user last login column

		if($user){
			$users = array(
				'id'=>$user->ID,
				'roles'=>$user->roles,
				);
			if( ! session_id() ) {
				session_start();
				$_SESSION['chat_users'] = $users;
			}
			$data['status'] = 'logged_in';
			$data['users'] = $users;
			$data['chat_users'] = $_SESSION['chat_users'];

		}else{
			$data['message'] = 'logged_out';
		}
		$this->pushers->trigger('userstatus', 'my-event', $data);
		return $user;
	}

	function action_wp_logout( $user ) {
		$user = wp_get_current_user();
		$users = array(
			'id'=>$user->ID,

		);
		$data['status'] = 'logged_out';
		$data['users'] = $users;
		$data['chat_users'] = $_SESSION['chat_users'];
		$this->pushers->trigger('userstatus', 'my-event', $data);
	}
}
