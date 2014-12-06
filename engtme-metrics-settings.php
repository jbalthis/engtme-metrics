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
			add_action('admin_menu', array(&$this, 'add_menu'));
		 
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
				'engtme_metrics-section',
				'ENGTME Metrics Settings',
				array(&$this, 'settings_section_engtme_metrics'),
				'engtme_metrics'
			);
			
			// add settings fields
			add_settings_field(
				'engtme_metrics-setting_a',
				'Setting A',
				array(&$this, 'settings_field_input_text'),
				'engtme_metrics',
				'engtme_metrics-section',
				array(
				'field' => 'setting_a'
				)
			);
			
			add_settings_field(
				'engtme_metrics-setting_b',
				'Setting B',
				array(&$this, 'settings_field_input_text'),
				'engtme_metrics',
				'engtme_metrics-section',
				array(
				'field' => 'setting_b'
				)
			);
		 }

		 public function settings_section_engtme_metrics(){
		 	
			// Think of this as help text for the section.
			echo 'These settings do things for the WP Plugin Template.';
		}
		
		
		/**
		 * provides text input for the settings fields
		 */
		public function settings_field_input_text($args){
		
			// Get the field name from the $args array
			$field = $args['field'];
		
			// Get the value of this setting
			$value = get_option($field);
			
			// echo a proper input type="text"
			echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
		}
		
		
		/**
		 * add a menu
		 */
		public function add_menu(){
			
			// Add a page to manage this plugin's settings
			add_options_page(
				'ENGTME Metrics Settings',
				'ENGTME Metrics',
				'manage_options',
				'engtme_metrics',
				array(&$this, 'plugin_settings_page')
			);
			
		}

		
		/**
		 * menu callback
		 */
		public function plugin_settings_page(){
			
			// ensure user has proper permissions
			if(!current_user_can('manage_options')){
				
				wp_die(__('You do not have sufficient permissions to access this page.'));
			
			}
			
			// Render the settings template
			include(sprintf("%s/templates/engtme-metrics-template-settings.php", dirname(__FILE__)));
		}


		
	}
	
	
	
	
}
