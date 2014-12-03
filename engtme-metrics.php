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
 * Copyright 2012 Jason Balthis (email:jabalthi@cyberspace.ninja)
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
		 	
			// hook plugin into admin actions
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'admin_menu'));
			
		 }

		
		/**
		 * name:	activate()
		 * desc:	activation method for the plugin object
		 * scope:	public
		 * attr:	static
		 */	
		 public static function activate(){
		 	
			// do nothing
			
		 }
	
		
		/**
		 * name:	deactivate()
		 * desc:	deactivation method for the plugin object
		 * scope:	public
		 * attr:	static
		 */
		public static function deactivate(){
			
			// do nothing
			
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





