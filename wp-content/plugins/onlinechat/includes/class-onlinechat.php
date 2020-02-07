<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.creativetech-solutions.com
 * @since      1.0.0
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Onlinechat
 * @subpackage Onlinechat/includes
 * @author     Hamid Raza <hamid.creativetech>
 */
class Onlinechat {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Onlinechat_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;



	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ONLINECHAT_VERSION' ) ) {
			$this->version = ONLINECHAT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'onlinechat';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Onlinechat_Loader. Orchestrates the hooks of the plugin.
	 * - Onlinechat_i18n. Defines internationalization functionality.
	 * - Onlinechat_Admin. Defines all hooks for the admin area.
	 * - Onlinechat_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-onlinechat-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-onlinechat-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'pusher_vendor/vendor/autoload.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-onlinechat-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-onlinechat-public.php';



		$this->loader = new Onlinechat_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Onlinechat_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Onlinechat_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Onlinechat_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('wp_ajax_users_datatables', $plugin_admin,'userslist_server_side_callback');
		$this->loader->add_action('wp_ajax_nopriv_users_datatables', $plugin_admin,'userslist_server_side_callback');
		$this->loader->add_action('wp_ajax_online_users', $plugin_admin,'online_userslist_server_side_callback');
		$this->loader->add_action('wp_ajax_nopriv_online_users', $plugin_admin,'online_userslist_server_side_callback');
		$this->loader->add_action('wp_ajax_users_messages', $plugin_admin,'users_messages_callback');
		$this->loader->add_action('wp_ajax_nopriv_users_messages', $plugin_admin,'users_messages_callback');
		$this->loader->add_action('wp_ajax_get_users_messages', $plugin_admin,'get_users_messages_callback');
		$this->loader->add_action('wp_ajax_nopriv_get_users_messages', $plugin_admin,'get_users_messages_callback');

		$this->loader->add_action('wp_ajax_users_notifications', $plugin_admin,'update_notifications_callback');
		$this->loader->add_action('wp_ajax_nopriv_users_notifications', $plugin_admin,'update_notifications_callback');

		$this->loader->add_action('admin_menu', $plugin_admin,'admin_chat_menu');
		$this->loader->add_action('init', $plugin_admin,'register_chat_shortcodes');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Onlinechat_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter('wp_authenticate_user',$plugin_public, 'myplugin_auth_login',10,2);
		//$this->loader->add_filter( 'clear_auth_cookie', 'action_clear_auth_cookie', 999, 0 );


		$this->loader->add_filter( 'wp_logout',$plugin_public, 'action_wp_logout', -1, 1 );
		//$this->loader->add_filter( 'wp_authenticate_user',$plugin_public, 'intercetta_login', 10, 1 );

		$this->loader->add_action('init', $plugin_public,'register_chat_shortcodes');


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Onlinechat_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
		//Update user online status
add_action('init', 'gearside_users_status_init');
add_action('admin_init', 'gearside_users_status_init');
function gearside_users_status_init(){
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.
	$user = wp_get_current_user(); //Get the current user's data

	//Update the user if they are not on the list, or if they have not been online in the last 900 seconds (15 minutes)
	if ( !isset($logged_in_users[$user->ID]['last']) || $logged_in_users[$user->ID]['last'] <= time()-900 ){
		$logged_in_users[$user->ID] = array(
			'id' => $user->ID,
			'username' => $user->user_login,
			'last' => time(),
		);
		set_transient('users_status', $logged_in_users, 900); //Set this transient to expire 15 minutes after it is created.
	}
}

//Check if a user has been online in the last 15 minutes
function gearside_is_user_online($id){
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.

	return isset($logged_in_users[$id]['last']) && $logged_in_users[$id]['last'] > time()-900; //Return boolean if the user has been online in the last 900 seconds (15 minutes).
}

//Check when a user was last online.
function gearside_user_last_online($id){
	$logged_in_users = get_transient('users_status'); //Get the active users from the transient.

	//Determine if the user has ever been logged in (and return their last active date if so).
	if ( isset($logged_in_users[$id]['last']) ){
		return $logged_in_users[$id]['last'];
	} else {
		return false;
	}
}
	}

}
