<?php
/*
Plugin Name: wp-search-react
Plugin URI: http://localhost/wp-react/
Description: activate react search on wp sites
Version: 1.0.1
Author: Ido Barnea
Author URI: https://www.barbareshet.com
Text Domain: wprs
Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) {
	return;
}
if ( !class_exists('WPRS') ){
	class WPRS{
	public $wprs_options;
	public $plugin;
		public function __construct() {

			add_action( 'plugins_loaded', array( &$this, 'wprs_load_textdomain') );
			add_action( 'wp_enqueue_scripts', array(&$this, 'wp_react_rest_api_scripts') );
			if ( is_admin() ) {
				add_action( 'admin_init', array( &$this, 'wprs_register_settings') );
			}
			$this->wprs_options = get_option('wprs_settings');
			$this->plugin = plugin_basename( __FILE__ );
			add_filter( "plugin_action_links_$this->plugin", array( &$this, 'wprs_add_settings_link') );
		}
		public function wprs_load_textdomain() {
			load_plugin_textdomain( 'wprs', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Enqueueing the script
		 */
		public function wp_react_rest_api_scripts() {
			wp_enqueue_script( 'react-rest-js', plugin_dir_url( __FILE__ ) . 'assets/js/public.min.js', array( 'jquery' ), '', true );
			wp_localize_script( 'react-rest-js', 'wp_react_js', array(
				// Adding the post search REST URL
				'rest_search_posts' => rest_url( 'wp/v2/search?search=%s' )));
		}

		//Load Settings only if on the admin side



		public function wprs_register_settings(){
//
			register_setting('wprs_settings_group', 'wprs_settings');
			require_once ( plugin_dir_path(__FILE__) . '/inc/wprs-settings.php' );
		}
		public function wprs_add_settings_link( $links ) {
			$settings_link = '<a href="'.admin_url('options-general.php?').'page=wprs-options">' . __( 'Settings' ) . '</a>';
			array_push( $links, $settings_link );
			return $links;
		}

	}

	NEW WPRS();
}






