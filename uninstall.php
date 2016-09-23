<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
 
// Define set of plugin-specific options
$option_arr = array(
	'local_like_and_share_settings'
	,'local_like_and_share_widget_defaults'
	,'local_like_and_share_db_version'
	,'widget_local-like-and-share'
);

// Define set of plugin-specific custom tables
global $wpdb;
$custom_table_arr = array(
	'local_like_and_share_user_like'
	,'local_like_and_share_user_share'
);

// Delete all post meta data that plugin has created
$post_meta_arr = array(
	'local_like_and_share_like_total'
	,'local_like_and_share_share_total'
);
 
if ( ! is_multisite() ) {
		
	// NOT multisite
					  
	// Delete options
	foreach ( $option_arr as $option_name) {
		delete_option( $option_name );
	}
		
	// Delete language detector
	delete_option( 'local_like_and_share_language_detector_' . get_locale() );

	// Delete custom tables
	foreach ( $custom_table_arr as $custom_table_name) {
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}" . $custom_table_name );			  
	}
	
	// Delete post meta data
	foreach ( $post_meta_arr as $post_meta_name ) {
		delete_post_meta_by_key( $post_meta_name );
	}
	
} 
else {
		  
	// IS multisite
	
	$site_id_arr = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$root_blog_id = get_current_blog_id();

	// Iterate through sites in network
	foreach ( $site_id_arr as $site_id ) {
		switch_to_blog( $site_id );
	
		// Delete options
		foreach ( $option_arr as $option_name) {
			delete_option( $option_name );
		}

		// Delete language detector
		delete_option( 'local_like_and_share_language_detector_' . get_locale() );

		// Delete custom tables
		foreach ( $custom_table_arr as $custom_table_name) {
			$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}" . $custom_table_name );			  
		}

		// Delete post meta data
		foreach ( $post_meta_arr as $post_meta_name ) {
			delete_post_meta_by_key( $post_meta_name );
		}

	}
	switch_to_blog( $root_blog_id );
}
