<?php
// block direct access to plugin PHP files
defined('ABSPATH') or die('No script kitties please, meooooow ;P');

if(!class_exists('ENGTME_Metrics_OWA')){
	
	class ENGTME_Metrics_OWA
	{
		
		/**
		 * name:	__construct() 
		 * desc:	constructor method for the plugin object
		 * scope:	public
		 */
		 public function __construct(){
		 	
			// register our actions
			add_action('wp_footer', array(&$this, 'insert_owa_tracking_code'));
		 
		 }
		
		
		/**
		 * name: 	insert_owa_tracking_code()
		 * desc:	hook our plugin into WP's wp_footer action hook
		 * scope:	public
		 */
		 public function insert_owa_tracking_code(){
		 	
			?>
			
			<!-- Start Open Web Analytics Tracker -->
			<script type="text/javascript">
			//<![CDATA[
			var owa_baseUrl = 'http://sandbox.cyberspace.ninja/wp-sandbox/owa/';
			var owa_cmds = owa_cmds || [];
			owa_cmds.push(['setSiteId', '70c4682d9e053d44cade120593f4e452']);
			owa_cmds.push(['trackPageView']);
			owa_cmds.push(['trackClicks']);
			owa_cmds.push(['trackDomStream']);
			
			(function() {
				var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
				owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
				_owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
				var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
			}());
			//]]>
			
			<?php
		 }	
	}	
}