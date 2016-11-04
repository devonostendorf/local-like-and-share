<?php

/**
 * Local Like And Share
 *
 * Track liked and shared posts directly on your site.
 *
 * This plugin was built using the exquisite WordPress Plugin Boilerplate 
 * 	(https://github.com/DevinVinson/WordPress-Plugin-Boilerplate) written 
 * 	by Tom McFarlin (http://tommcfarlin.com), Devin Vinson, and friends.
 *	The widget functionality was built based on the equally tremendous WordPress
 *	Widget Boilerplate, also written by Tom McFarlin.
 *
 * @link				https://devonostendorf.com/projects/#local-like-and-share
 * @since				1.0.0
 * @package				Local_Like_And_Share
 *
 * @wordpress-plugin
 * Plugin Name:			Local Like And Share
 * Plugin URI:			https://devonostendorf.com/projects/#local-like-and-share
 * Description:			Track liked and shared posts directly on your site.
 * Version:				1.0.6
 * Author:				Devon Ostendorf <devon@devonostendorf.com>
 * Author URI:			https://devonostendorf.com/
 * License:				GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:			local-like-and-share
 * Domain Path:			/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-local-like-and-share-activator.php
 */
function activate_local_like_and_share() {
		  
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-local-like-and-share-activator.php';
	Local_Like_And_Share_Activator::activate();
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-local-like-and-share-deactivator.php
 */
function deactivate_local_like_and_share() {
		  
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-local-like-and-share-deactivator.php';
	Local_Like_And_Share_Deactivator::deactivate();
	
}

register_activation_hook( __FILE__, 'activate_local_like_and_share' );
register_deactivation_hook( __FILE__, 'deactivate_local_like_and_share' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-local-like-and-share.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_local_like_and_share() {

	$plugin = new Local_Like_And_Share();
	$plugin->run();

}
run_local_like_and_share();
