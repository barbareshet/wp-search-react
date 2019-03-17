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


function regsiter_api(){

	register_rest_route( 'wprs/v1', '/options', array(
		'methods' => 'GET',
		'callback' => 'wprs_get_options',
	) );
}
add_action( 'rest_api_init', 'regsiter_api', 10 );

function wprs_get_options(){
	return __FILE__;
}
//Load Settings only if on the admin side



function wprs_register_settings(){

		register_setting('wprs_settings_group', 'wprs_settings');

}
$wprs_options = get_option('wprs_settings');
if ( is_admin() ) {
	add_action( 'admin_init', 'wprs_register_settings' );
}
if ( is_admin()){
	require_once ( plugin_dir_path(__FILE__) . '/inc/wprs-settings.php' );

}
function wprs_add_settings_link( $links ) {
	$settings_link = '<a href="'.admin_url('options-general.php?').'page=wprs-options">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wprs_add_settings_link' );