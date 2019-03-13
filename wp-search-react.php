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


function wprs_load_textdomain() {
	load_plugin_textdomain( 'wprs', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wprs_load_textdomain' );

/**
 * Enqueueing the script
 */
function wp_react_rest_api_scripts() {
	wp_enqueue_script( 'react-rest-js', plugin_dir_url( __FILE__ ) . 'assets/js/public.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'react-rest-js', 'wp_react_js', array(
		// Adding the post search REST URL
		'rest_search_posts' => rest_url( 'wp/v2/search?search=%s' )));
}
add_action( 'wp_enqueue_scripts', 'wp_react_rest_api_scripts' );

//Load Settings only if on the admin side
if ( is_admin()){
	require_once ( plugin_dir_path(__FILE__) . '/inc/wprs-settings.php' );

}

function wprs_register_settings(){
	if ( is_admin() ){
		register_setting('wprs_settings_group', 'wprs_settings');
	}
}


	add_action('admin_init', 'wprs_register_settings');


function wprs_add_settings_link( $links ) {
	$settings_link = '<a href="'.admin_url('options-general.php?').'page=wprs-options">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wprs_add_settings_link' );