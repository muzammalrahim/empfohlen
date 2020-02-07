<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.creativetech-solutions.com
 * @since      1.0.0
 *
 * @package    Onlinechat
 * @subpackage Onlinechat/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Onlinechat
 * @subpackage Onlinechat/includes
 * @author     Hamid Raza <hamid.creativetech>
 */
class Onlinechat_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$create_chat_room_table = "
            CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}chat_room` (
              `id` int(22) NOT NULL auto_increment,
              `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `status` int(1) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB   DEFAULT CHARSET=utf8;
    	";
		dbDelta( $create_chat_room_table );

		$create_members_table = "
            CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}conversation_members` (
              `id` int(22) NOT NULL auto_increment,
              `room_id` int(22) NOT NULL,             
              `user_id` int(22) NOT NULL,
              `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `status` int(1) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB   DEFAULT CHARSET=utf8;
    	";
		dbDelta( $create_members_table );

		$create_conversations_table = "
            CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}conversations` (
              `id` int(22) NOT NULL auto_increment,
              `room_id` int(22) NOT NULL,             
              `sender` int(22) NOT NULL,             
              `receiver` int(22) NOT NULL,             
              `notifications` int(22) NOT NULL,             
              `message` text NOT NULL,
              `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `status` int(1) NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB   DEFAULT CHARSET=utf8;
    	";
		dbDelta( $create_conversations_table );
	}
}
