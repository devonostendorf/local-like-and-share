<?php

/**
 * Fired during plugin activation
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Activator {

	/**
	 * Create plugin's options and custom DB tables.
	 *
	 * @since	1.0.0
	 */
	public static function activate() {
		  
		// Get current installed plugin DB version
		$installed_local_like_and_share_db_version = intval( get_option( 'local_like_and_share_db_version', 0 ) );
		
		// Check for updates and apply, if needed
		$local_like_and_share_updater = new Local_Like_And_Share_Updater( $installed_local_like_and_share_db_version );
		$local_like_and_share_updater->apply_updates_if_needed();
				
	}
	
}
