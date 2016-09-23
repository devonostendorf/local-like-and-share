<?php

/**
 * Ensures plugin-specific options and tables are current.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */

/**
 * Ensures plugin-specific options and tables are current.
 *
 * This class handles all updates to plugin-specific options and tables both
 *	during plugin activation and following an upgrade to a new version of the 
 *	plugin.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Updater {
		  	
	/**
	 * This plugin's current custom database version.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var     string	$local_like_and_share_db_version	Current version of this plugin's database.
	 */	
	private $local_like_and_share_db_version;
	
	/**
	 * This plugin's installed custom database version.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var     string	$installed_local_like_and_share_db_version	The version of this plugin last installed.
	 */	
	private $installed_local_like_and_share_db_version;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since	1.0.0
	 * @param	string	$installed_local_like_and_share_db_version	The version of this plugin last installed.
	 */
	public function __construct( $installed_local_like_and_share_db_version ) {

		$this->local_like_and_share_db_version = 3;
		$this->installed_local_like_and_share_db_version = $installed_local_like_and_share_db_version;
		  
	}

	/**
	 * Determine whether to apply updates to plugin's options and custom DB tables.
	 *
	 * @since	1.0.0
	 */
	public function apply_updates_if_needed() {

		if ( $this->installed_local_like_and_share_db_version < $this->local_like_and_share_db_version ) {
				  
			// Need to create/upgrade options and/or tables
			$this->apply_updates();
		}
			  
	}
	
	/**
	 * Update options and/or custom DB tables to current version of Local Like And Share
	 *	settings.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function apply_updates() {
			  
		// NOTE: Set options here, since if it has been determined that an update
		//		needs to be applied (because user's installed DB version is less
		//		than current release's DB version), then we need to be sure they
		//		have all current options in place too!
		
		// Add options		
		
		$local_like_and_share_settings_arr = array(
			'button_posn_vert' => 'bottom'
			,'button_posn_horiz' => 'left'
			,'btn_hover_message_background_color' => 'black'
			,'btn_hover_message_text_color' => 'white'
			,'count_background_color' => '#eef4f9'
			,'count_outline_color' => '#c5d9e8'
			,'count_text_color' => 'black'
			,'abbrev_large_count_vals' => 'no'
			,'like_show_on_post_index' => 'no'
			,'like_show_on_single' => 'yes'
			,'like_btn_color' => 'red'
			,'like_btn_hover_color' => 'pink'
			,'like_btn_hover_call_to_action' => 'Click to like this post.'
			,'like_btn_hover_success_message' => 'Thanks for liking this post!'
			,'like_btn_hover_info_message_already_liked' => "You've already liked this post."
			,'widget_info_message_no_likes_found' => 'Sorry - no like data available.'
			,'share_eml_subj' => 'Check out this post on @@blogname: @@posttitle'
			,'share_eml_body' => "Hi,<br>\n<br>\nI thought you might be interested in this post I saw on @@blogname:<br>\n<br>\n@@permalink<br>\n<br>\nTake care,<br>\n[SENDER NAME]"
			,'share_show_on_post_index' => 'no'
			,'share_show_on_single' => 'yes'
			,'share_btn_color' => 'grey'
			,'share_btn_hover_color' => 'blue'
			,'share_btn_hover_call_to_action' => 'Click to share this post.'
			,'widget_info_message_no_shares_found' => 'Sorry - no share data available.'
			,'admin_menu_position' => '3.390'
		);
		// Cleanly future-proof the addition of settings by
		//		iterating through defaults array and only updating 
		//		'local_like_and_share_settings_arr' values that are new to site
		//		(thus avoiding overwriting any that an admin has chosen to customize)
		$curr_local_like_and_share_settings_arr = get_option( 'local_like_and_share_settings', array() );
		foreach ( $local_like_and_share_settings_arr as $setting_key => $setting_val ) {
			if ( ! array_key_exists( $setting_key, $curr_local_like_and_share_settings_arr) ) {
				$curr_local_like_and_share_settings_arr[ $setting_key ] = $setting_val;
			}				  
		}
		// Use update_option() to handle both first-time activation of plugin
		//		AND subsequent upgrade-related re-activations
		update_option( 'local_like_and_share_settings', $curr_local_like_and_share_settings_arr );
				
		$local_like_and_share_widget_defaults_arr = array(
			'like_title_default' => 'Most Liked'
			,'share_title_default' => 'Most Shared'
			,'time_period_default' => 'All-time'
			,'number_of_posts_to_show_default' => '5'
			,'numbered_result_margin_default' => '0'
		);
		// Replace add_option() call with update_option() as these are strictly
		//		defaults - user updates to the widget settings are not stored back
		//		in here
		update_option( 'local_like_and_share_widget_defaults', $local_like_and_share_widget_defaults_arr );

		// If widget is already defined, add any new settings found in default
		//		array since last activation of plugin
		$curr_widget_local_like_and_share_arr = get_option( 'widget_local-like-and-share');
		if ( $curr_widget_local_like_and_share_arr ) {
				  
			// Widget IS defined
			
			// Find index containing show_like_section so we can (potentially) add new options
			$options_index = false;
			foreach ( $curr_widget_local_like_and_share_arr as $arr_key => $arr_item ) {
				if ( is_array( $arr_item ) ) {
					if ( array_key_exists( 'show_like_section', $arr_item ) ) {						
						$options_index = $arr_key;
						break;
					}
				}
			}

			//	Iterate through widget settings array and only update values that 
			//		are new to site (thus avoiding overwriting any that an admin has
			//		chosen to customize)
			if ( $options_index ) {
				foreach ( $local_like_and_share_widget_defaults_arr as $default_key => $default_val ) {
					$trimmed_key = substr( $default_key, 0, strlen( $default_key ) - 8 ); 
					if ( ! array_key_exists( $trimmed_key, $curr_widget_local_like_and_share_arr[ $options_index ] ) ) {
						$curr_widget_local_like_and_share_arr[ $options_index ][ $trimmed_key ] = $default_val;
					}				  
				}
				update_option( 'widget_local-like-and-share', $curr_widget_local_like_and_share_arr );
			}
		}
		
		// DB version for currently installed version of plugin (if any [could be
		//		initial install]) needs updating - apply all DB updates sequentially
			
		// NOTE: In order for this all to work going forward need to:
		//		1) Increment DB version if there are options changes AND/OR table 
		//			structure changes
		//		2) When there are table changes, add them to new 
		//			"like_and_share_db_update_version_" function
		//		3) When there are ONLY options changes, add them above AND create
		//			new, empty "local_like_and_share_db_update_version_" function so that
		//			logic below works in all cases	

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );	// dbDelta function lives in here
		
		$version_iterator = $this->installed_local_like_and_share_db_version + 1;
		while ( $version_iterator <= $this->local_like_and_share_db_version ) {
			$update_method = "local_like_and_share_db_update_version_{$version_iterator}";
			if ( method_exists( $this, $update_method ) ) {
				$this->$update_method();
			}					  
			++$version_iterator;
		}
			
		// Database changes were made, update local_like_and_share_db_version accordingly
		update_option( 'local_like_and_share_db_version', $this->local_like_and_share_db_version );			
    	
	}	
	
	/**
	 * Apply changes to get database schema to version 1.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function local_like_and_share_db_update_version_1() {
			
		global $wpdb;
		
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE {$wpdb->prefix}local_like_and_share_user_like (
			post_id bigint(20) UNSIGNED NOT NULL,
			user_identifier varchar( 60 ) NOT NULL,
			date_liked datetime NOT NULL,
			PRIMARY KEY  (post_id,user_identifier),		
			KEY (date_liked)
		) $charset_collate;";
		dbDelta( $sql );		

		$sql = "CREATE TABLE {$wpdb->prefix}local_like_and_share_user_share (
			post_id bigint(20) UNSIGNED NOT NULL,
			user_identifier varchar( 60 ) NOT NULL,
			date_shared datetime NOT NULL,
			PRIMARY KEY  (post_id,user_identifier,date_shared),		
			KEY (date_shared)
		) $charset_collate;";
		dbDelta( $sql );			
			  
	}
	
	/**
	 * Apply changes to get database schema to version 2.
	 *
	 * @since	1.0.1
	 * @access	private
	 */
	private function local_like_and_share_db_update_version_2() {
			
		global $wpdb;
		
		$charset_collate = $wpdb->get_charset_collate();
		
		$sql = "CREATE TABLE {$wpdb->prefix}local_like_and_share_user_like (
			post_id bigint(20) UNSIGNED NOT NULL,
			user_identifier varchar( 60 ) NOT NULL,
			date_liked datetime NOT NULL,
			to_delete BOOLEAN NOT NULL DEFAULT 0,
			last_update_dttm TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY  (post_id,user_identifier),		
			KEY date_liked (date_liked)
		) $charset_collate;";
		dbDelta( $sql );		

		$sql = "CREATE TABLE {$wpdb->prefix}local_like_and_share_user_share (
			post_id bigint(20) UNSIGNED NOT NULL,
			user_identifier varchar( 60 ) NOT NULL,
			date_shared datetime NOT NULL,
			to_delete BOOLEAN NOT NULL DEFAULT 0,
			last_update_dttm TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY  (post_id,user_identifier,date_shared),		
			KEY date_shared (date_shared)
		) $charset_collate;";
		dbDelta( $sql );			

	}
	
	/**
	 * Apply changes to get database schema to version 3.
	 * NOTE: There is not actually a schema change here, but rather the need to
	 *		force initial population of the post meta data used beginning in
	 *		v1.0.5.
	 *
	 * @since	1.0.5
	 * @access	private
	 */
	private function local_like_and_share_db_update_version_3() {
		
		// Populate post meta data counts for both Likes and Shares
		Local_Like_And_Share_Misc::refresh_likes_and_or_shares('both');
		
	}
	
}
