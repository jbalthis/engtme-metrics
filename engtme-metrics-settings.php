<?php
// block direct access to plugin PHP files
defined('ABSPATH') or die('No script kitties please, meooooow ;P');

if(!class_exists('ENGTME_Metrics')){
	
	class ENGTME_Metrics_Settings
	{
		
		/**
		 * name:	__construct() 
		 * desc:	constructor method for the plugin object
		 * scope:	public
		 */
		 public function __construct(){
		 	
			// register our actions
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'admin_menu'));
			
		 }
		
		
		/**
		 * name: 	admin_init()
		 * desc:	hook our plugin into WP's admin_init action hook
		 * scope:	public
		 */
		 public function admin_init(){
		 	
			// register our plugin's settings
			register_setting('engtme_metrics-group', 'setting_a');
			register_setting('engtme_metrics-group', 'setting_b');
			
			
			// add settings section
			add_settings_section(
				'engtme_metrics_settings-section'
			);
			
			
		 }
		
	}
	
	
	
	
}
