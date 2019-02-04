<?php
/*
Plugin Name: wp-search-react
Plugin URI: http://localhost/wp-react/
Description: activate react search on wp sites
Version: 0.1.0
Author: Ido Barnea
Author URI: https://www.barbareshet.com
Text Domain: wprs
Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Enqueueing the script
 */
function wp_react_rest_api_scripts() {
	wp_enqueue_script( 'react-rest-js', plugin_dir_url( __FILE__ ) . 'assets/js/public.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'react-rest-js', 'wp_react_js', array(
		// Adding the post search REST URL
		'rest_search_posts' => rest_url( 'wp/v2/posts?search=%s' )));
}
add_action( 'wp_enqueue_scripts', 'wp_react_rest_api_scripts' );

