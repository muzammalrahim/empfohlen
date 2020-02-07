<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.creativetech-solutions.com
 * @since             1.0.0
 * @package           Onlinechat
 *
 * @wordpress-plugin
 * Plugin Name:       Online Chat
 * Plugin URI:        http://www.creativetech-solutions.com
 * Description:       Online Chat between users.
 * Version:           1.0.0
 * Author:            Hamid Raza
 * Author URI:        http://www.creativetech-solutions.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       onlinechat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ONLINECHAT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-onlinechat-activator.php
 */
function activate_onlinechat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onlinechat-activator.php';
	Onlinechat_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-onlinechat-deactivator.php
 */
function deactivate_onlinechat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-onlinechat-deactivator.php';
	Onlinechat_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_onlinechat' );
register_deactivation_hook( __FILE__, 'deactivate_onlinechat' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-onlinechat.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_onlinechat() {

	$plugin = new Onlinechat();
	$plugin->run();

}
run_onlinechat();
