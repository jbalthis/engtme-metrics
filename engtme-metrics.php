<?php
/**
 * Plugin Name: ENG-TME Metrics
 * Plugin URI: http://github.com/jbalthis/engtme-metrics/doc/
 * 
 * Description: WordPress plugin to gather metrics on various aspects of use of Cisco's internal ENG-TME WebApp.
 * Version: 0.1
 * 
 * Author: Jason Balthis
 * Author URI: http://github.com/jbalthis
 * 
 * License: GPL2
 * Copyright 2014 Jason Balthis (email:jabalthi@cyberspace.ninja)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// block direct access to plugin PHP files
defined('ABSPATH') or die('No script kitties please, meooooow ;P');

if(!class_exists('ENGTME_Metrics')){
	
	class ENGTME_Metrics
	{
		
		/**
		 * name:	__construct() 
		 * desc:	constructor method for the plugin object
		 * scope:	public
		 */
		 public function __construct(){
				
			// Initialize Settings
			require_once(sprintf("%s/engtme-metrics-settings.php", dirname(__FILE__)));
			$ENGTME_Metrics_Settings = new ENGTME_Metrics_Settings();
			
			// Initialize OWA
			require_once(sprintf("%s/engtme-metrics-owa.php", dirname(__FILE__)));
			$ENGTME_Metrics_OWA = new ENGTME_Metrics_OWA();
			
			// Register custom post types
			require_once(sprintf("%s/post-types/engtme-metrics-post-type-template.php", dirname(__FILE__)));
			$Post_Type_Template = new Post_Type_Template();
			
			
			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		 }

		
		/**
		 * name:	activate()
		 * desc:	activation method for the plugin object
		 * scope:	public
		 * attr:	static
		 */	
		 public static function activate(){
		 	
			$engtme_metrics_db_version = '1.0';
			
			// create table to store metrics data
			call_user_func(function(){
   				global $wpdb;

   				$table_name = $wpdb->prefix . 'engtme_metrics';
				
				$charset_collate = $wpdb->get_charset_collate();
				
				$sql = "CREATE TABLE $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  ip INTEGER UNSIGNED NOT NULL,
				  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				  ua varchar(200) NOT NULL DEFAULT '-',
				  request varchar(200) NOT NULL DEFAULT '/',
				  referrer varchar(200) NOT NULL DEFAULT '-',
				  is_unique BOOLEAN NOT NULL DEFAULT TRUE,
				  UNIQUE KEY id (id)
				) $charset_collate;";
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql ); 
				
				add_option( 'engtme_metrics_db_version', $engtme_metrics_db_version );
				
			}) or die('Could not create table for plugin data');
			
			
			// install sample data
			call_user_func(function(){
				global $wpdb;
								
				$table_name = $wpdb->prefix . 'engtme_metrics';
				
				$wpdb->insert( 
					$table_name, 
					array( 
						'time' => current_time( 'mysql' ),
						'ip' => $_SERVER['REMOTE_ADDR'],
						'ua' => $_SERVER['HTTP_USER_AGENT'],
						'referrer' => $_SERVER['HTTP_REFERER'],
					)
				);
			}) or die('Could not insert sample data into table');

			
		 }
		 
	
		
		/**
		 * name:	deactivate()
		 * desc:	method to handle tasks to run when plugin is deactivated
		 * scope:	public
		 * attr:	static
		 */
		public static function deactivate(){
					
				
			// delete database upon plugin uninstallation
			call_user_func(function(){
			     global $wpdb;
				 
			     $table_name = $wpdb->prefix . 'engtme_metrics';
				 
			     $sql = "DROP TABLE IF EXISTS $table_name;";
			     $wpdb->query($sql);
				 
			     delete_option('engtme_metrics_db_version');
			}) or die('Could not remove plugin table from db');

			
		}
		
		
		// Add the settings link to the plugins page
		function plugin_settings_link($links){
		
			$settings_link = '<a href="options-general.php?page=engtme_metrics">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
		
	} // end class
	
} // if(!class_exists)

if(class_exists('ENGTME_Metrics')){
	
	
	// register installation/uninstallation hooks with the WP application	
	register_activation_hook(__FILE__, array('ENGTME_Metrics', 'activate'));
	register_deactivation_hook(__FILE__, array('ENGTME_Metrics', 'deactivate'));
	
	
	
	// instantiate the plugin class
	$engtme_metrics = new ENGTME_Metrics();
	
	
} // if(class_exists)





