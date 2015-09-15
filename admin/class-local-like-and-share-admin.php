<?php

/**
 * The admin-specific functionality of the plugin.
 *					
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueues the admin-specific
 *	JavaScript.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/admin
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Admin {
		  	
	/**
	 * The ID of this plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var     string	$plugin_name	The ID of this plugin.
	 */
	private $plugin_name;
									
	/**
	 * The version of this plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var		string	$version	The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since	1.0.0
	 * @param	string	$plugin_name	The name of this plugin.
	 * @param	string	$version	The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Local_Like_And_Share_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Local_Like_And_Share_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'wp-color-picker' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Local_Like_And_Share_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Local_Like_And_Share_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/local-like-and-share-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );

	}
	
	/**
	 * Call Local Like And Share Updater class in case options or tables need updating.
	 *
	 * @since	1.0.0
	 */	
	public function update_check() {
	
		// Get current installed plugin DB version
		$installed_local_like_and_share_db_version = intval( get_option( 'local_like_and_share_db_version', 0 ) );
		
		// Check for updates and apply, if needed
		$local_like_and_share_updater = new Local_Like_And_Share_Updater( $installed_local_like_and_share_db_version );
		$local_like_and_share_updater->apply_updates_if_needed();
						
	}

	
	// Functions related to adding Local Like And Share submenu to Settings menu
	
	/**
	 * Add Local Like And Share menu item to Settings menu.
	 *
	 * @since	1.0.0
	 */	
	public function add_local_like_and_share_options_page() {
	
		add_options_page(
			__( 'Local Like And Share Settings', 'local-like-and-share' )
			,'Local Like And Share'
			,'manage_options'
			,'local-like-and-share-slug'
			,array( $this, 'render_local_like_and_share_options_page' )
		);
		
	}
	
	/**
	 * Register set of options configurable via Settings >> Local Like And Share on admin menu sidebar.
	 *
	 * @since	1.0.0
	 */	
	public function register_local_like_and_share_settings() {
     
		register_setting(
			'local_like_and_share_settings_group'
			,'local_like_and_share_settings'
		);
      
    }
   
	/**
	 * Render Local Like And Share options page.
	 *
	 * @since	1.0.0
	 */	
	public function render_local_like_and_share_options_page() {

		$local_like_and_share_options_pg = '';
    	ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/local-like-and-share-admin-display-options.php' );
		$local_like_and_share_options_pg .= ob_get_clean();
		print $local_like_and_share_options_pg;	
		
	}

	
	// Functions related to adding Local Like And Share top level menu to the admin menu sidebar
	
	/**
	 * Add Local Like And Share top level menu to the admin menu sidebar.
	 *
	 * @since	1.0.0
	 */	
	public function add_local_like_and_share_admin_menu() {
			
		// Admin can override default admin menu position of this menu
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		// NOTE: This will not have a selectable page associated with it (due to non-existent 'menu_only_no_selectable_item' capability)
		add_menu_page(
			'menu_only_no_selectable_item'
			,'Local Like And Share'
			,'menu_only_no_selectable_item'
			,'local-like-and-share-menu'
			,null
			,''
			,$local_like_and_share_options_arr['admin_menu_position']
		);

		add_submenu_page(
			'local-like-and-share-menu'
			,__( 'View Statistics', 'local-like-and-share' )
			,__( 'View Statistics', 'local-like-and-share' )
			,'edit_others_posts'	// admin and editor roles have this capability
			,'local-like-and-share-view-stats'
			,array( $this, 'render_view_stats_page' )
		);
		
	}
	
	/**
	 * Render View Local Like And Share Stats page.
	 *
	 * @since	1.0.0
	 */	
	public function render_view_stats_page() {
			  	
		$like_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'like', '24-hours' );
		$share_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'share', '24-hours' );

		// Get View Stats innards contents	  
		$div_all_stats_contents = '';
    	ob_start();
		include( plugin_dir_path( __FILE__ ) . 'partials/local-like-and-share-admin-view-stats-innards.php' );
		$div_all_stats_contents .= ob_get_clean();

		// Render page	  
		$local_like_and_share_view_stats_pg = '';
    	ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/local-like-and-share-admin-view-stats.php' );
		$local_like_and_share_view_stats_pg .= ob_get_clean();
		print $local_like_and_share_view_stats_pg;
		  
	}
		
	/**
	 * Enqueue AJAX script that fires when a time period button (on Local Like And Share >> View Statistics page) is pressed.
	 *
	 * @since	1.0.0
	 * @param	string	$hook	The current page name.
	 * @return	null	If this is not 'local-like-and-share-view-stats' page
	 */
	public function view_stats_enqueue( $hook ) {

		if ( 'local-like-and-share_page_local-like-and-share-view-stats' != $hook ) {
			
			return;
		}
		
		$llas_view_stats_nonce = wp_create_nonce( 'llas_view_stats' );
		wp_localize_script(
			$this->plugin_name
			,'llas_view_stats_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $llas_view_stats_nonce
			)
		);  

	}
		
	/**
	 * Handle AJAX event sent when a time period button (on Local Like And Share >> View Statistics page) is pressed.
	 *
	 * @since	1.0.0
	 */	
	public function change_stats_time_period_ajax_handler() {
	
		// Confirm matching nonce
		check_ajax_referer( 'llas_view_stats' );
		
		// Get current post ID
		$time_period = $_POST['time_period'];
		
		$like_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'like', $time_period );
		$share_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'share', $time_period );
		
		// Get View Stats innards contents	  
		$div_string = '';
    	ob_start();
		include( plugin_dir_path( __FILE__ ) . 'partials/local-like-and-share-admin-view-stats-innards.php' );
		$div_string .= ob_get_clean();
		
		wp_send_json( array( 'div_message' => $div_string ) );

	}
			
}
