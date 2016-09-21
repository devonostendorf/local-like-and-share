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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/local-like-and-share-admin.min.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );

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

	/**
	 * Determine whether Local Like And Share has a translation for this site's current language.
	 *
	 * @since	1.0.2
	 */	
	public function translation_check() {
	
		// Skip translation check if core update is in progress (or was just completed)
		// NOTE: The "about" page is where funny business with get_locale() occurs such that inaccurate errors
		//		are generated if this translation check is NOT skipped.  Displaying the nag on the "update-core"
		//		page is just ugly and annoying!
		$current_screen = get_current_screen();
		if ( ( "update-core" !== $current_screen->id ) && ( "about" !== $current_screen->id ) ) {

			// Get the current language locale
			$language = get_locale();
		
			// Check if the nag screen has been disabled for this language (or if current language is US English)
			if ( ( 'en_US' !== $language ) && ( false === get_option( 'local_like_and_share_language_detector_' . $language, false ) ) ) {
		
				// Nag screen, for current language, has NOT been dismissed 
				$plugin_i18n = new Local_Like_And_Share_i18n();
				if ( $plugin_i18n->is_loaded() ) {

					// BUT, a translation file, for current language, DOES exist
					// Disable nag screen for current language
					update_option( 'local_like_and_share_language_detector_' . $language, true, true );
					return;
				}
				else {
		
					// Display nag screen until admin dismisses it OR translation, for current language, is installed
					$this->display_translation_nag_screen( $language );
				}					
			}	
		}
	}
	
	/**
	 * Display the translation nag screen, soliciting translation help.
	 *
	 * @since	1.0.2
	 * @param	string	$language	The site's current language.
	 */
	private function display_translation_nag_screen( $language ) {

		// Add script, to handle nag dismissal, to page footer
		add_action( 'admin_footer', array( $this, 'add_translation_nag_screen_dismissal_script' ) );
		
		// We need the translation data from core to display human readable locale names
		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		$translations = wp_get_available_translations();
		$plugin = get_plugin_data( dirname( plugin_dir_path( __FILE__ ) ) . '/local-like-and-share.php' );
		include( plugin_dir_path( __FILE__ ) . 'partials/local-like-and-share-admin-view-translation-nag.php' );
		
	}

	/**
	 * Add JavaScript, to handle translation nag screen dismissal, to page footer.
	 *
	 * @since	1.0.2
	 */
	public function add_translation_nag_screen_dismissal_script() {
		
		include( plugin_dir_path( __FILE__ ) . 'js/local-like-and-share-admin-translation-nag.js' );
		
	}
	
	/**
	 * Disable translation nag screen for current language.
	 *
	 * @since	1.0.2
	 */	
	public function translation_nag_screen_ajax_handler() {

		// Disable nag screen for current language
	 	update_option( 'local_like_and_share_language_detector_' . get_locale(), true );
	 	wp_die();
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

		global $wpdb;
		
		// Physically delete previously soft-deleted likes, if any exist
		$num_likes_deleted = $wpdb->delete( 
			$wpdb->prefix.'local_like_and_share_user_like' 
			,array( 
				'to_delete' => 1
			)
		);
			
		// Physically delete previously soft-deleted shares, if any exist
		$num_shares_deleted = $wpdb->delete( 
			$wpdb->prefix.'local_like_and_share_user_share' 
			,array( 
				'to_delete' => 1
			)
		);		

		// Get View Stats innards contents	  
		$time_period = '24-hours';
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$div_all_stats_contents = $view_stats_innards['markup'];
		
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
		
		// Get current time period
		$time_period = $_POST['time_period'];

		// Get View Stats innards contents	  
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$all_stats_contents = $view_stats_innards['markup'];

		// Determine whether to render reset counts buttons and, if so, whether to enable/disable each
		$reset_like_btn_disabled = '';
		$reset_share_btn_disabled = '';
		if ( 'all-time' == $time_period ) {
			if ( 0 == $view_stats_innards['like_counts_row_count'] ) {
				$reset_like_btn_disabled = 'disabled';
			}
			if ( 0 == $view_stats_innards['share_counts_row_count'] ) {
				$reset_share_btn_disabled = 'disabled';
			}
			$show_del_buttons  = 'display: inline-block';
		}
		else {
			$del_button = '';
			$show_del_buttons  = 'display: none';
		}
		
		wp_send_json( 
			array( 
				'allStatsContents' => $all_stats_contents
				,'resetLikeBtnDisabled' => ( strlen( $reset_like_btn_disabled ) ) ? 'true' : 'false'
				,'resetShareBtnDisabled' => ( strlen( $reset_share_btn_disabled ) ) ? 'true' : 'false'
				,'showDelButtons' => $show_del_buttons
			) 
		);

	}
	
	/**
	 * Enqueue AJAX script that fires when the "Reset all like counts" button (on Local Like And Share >> View Statistics >> page [All-time tab]) is pressed.
	 *
	 * @since	1.0.1
	 * @param	string	$hook	The current page name.
	 * @return	null	If this is not 'local-like-and-share-view-stats' page
	 */
	public function reset_like_counts_enqueue( $hook ) {

		if ( 'local-like-and-share_page_local-like-and-share-view-stats' != $hook ) {
			
			return;
		}
		
		$llas_reset_like_counts_nonce = wp_create_nonce( 'llas_reset_like_counts' );
		wp_localize_script(
			$this->plugin_name
			,'llas_reset_like_counts_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $llas_reset_like_counts_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when the "Reset all like counts" button (on Local Like And Share >> View Statistics >> page [All-time tab]) is pressed.
	 *
	 * @since	1.0.1
	 */	
	public function reset_like_counts_ajax_handler() {
	
		// Confirm matching nonce
		check_ajax_referer( 'llas_reset_like_counts' );

		global $wpdb;
		
		// Soft-delete all (unflagged) like rows
		$last_update_dttm = date( "Y-m-d H:i:s" );
		$num_likes_flagged_for_delete = $wpdb->update( 
			$wpdb->prefix.'local_like_and_share_user_like' 
			,array( 
				'to_delete' => 1
				,'last_update_dttm' => $last_update_dttm
			)
			,array( 
				'to_delete' => 0
			)    			
		);				

		// Delete like counts from post meta data
		delete_post_meta_by_key( 'local_like_and_share_like_total' );
		
		// Get View Stats innards contents	  
		$time_period = 'all-time';
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$all_stats_contents = $view_stats_innards['markup'];

		// Define reset message and undo reset link
		$action_message = '<p id="id_pUndoLikeCountsReset"><strong>' . esc_html__( 'All like counts have been reset.', 'local-like-and-share' ) . '</strong><a href="#" rel="' . $last_update_dttm . '">&nbsp;' . esc_html__( 'Undo', 'local-like-and-share' ) . '</a></p>';

		wp_send_json( 
			array(
				'actionMessage' => $action_message
				,'allStatsContents' => $all_stats_contents
			)
		);
	
	}
	
	/**
	 * Enqueue AJAX script that fires when the "Reset all share counts" button (on Local Like And Share >> View Statistics >> page [All-time tab]) is pressed.
	 *
	 * @since	1.0.1
	 * @param	string	$hook	The current page name.
	 * @return	null	If this is not 'local-like-and-share-view-stats' page
	 */
	public function reset_share_counts_enqueue( $hook ) {

		if ( 'local-like-and-share_page_local-like-and-share-view-stats' != $hook ) {
			
			return;
		}
		
		$llas_reset_share_counts_nonce = wp_create_nonce( 'llas_reset_share_counts' );
		wp_localize_script(
			$this->plugin_name
			,'llas_reset_share_counts_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $llas_reset_share_counts_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when the "Reset all share counts" button (on Local Like And Share >> View Statistics >> page [All-time tab]) is pressed.
	 *
	 * @since	1.0.1
	 */	
	public function reset_share_counts_ajax_handler() {
	
		// Confirm matching nonce
		check_ajax_referer( 'llas_reset_share_counts' );
				
		global $wpdb;
		
		// Soft-delete all (unflagged) share rows
		$last_update_dttm = date( "Y-m-d H:i:s" );
		$num_shares_flagged_for_delete = $wpdb->update( 
			$wpdb->prefix.'local_like_and_share_user_share' 
			,array( 
				'to_delete' => 1
				,'last_update_dttm' => $last_update_dttm
			)
			,array( 
				'to_delete' => 0
			)    			
		);				

		// Delete share counts from post meta data
		delete_post_meta_by_key( 'local_like_and_share_share_total' );	

		// Get View Stats innards contents	  
		$time_period = 'all-time';
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$all_stats_contents = $view_stats_innards['markup'];

		// Define reset message and undo reset link
		$action_message = '<p id="id_pUndoShareCountsReset"><strong>' . esc_html__( 'All share counts have been reset.', 'local-like-and-share' ) . '</strong><a href="#" rel="' . $last_update_dttm . '">&nbsp;' . esc_html__( 'Undo', 'local-like-and-share' ) . '</a></p>';

		wp_send_json(
			array(
				'actionMessage' => $action_message
				,'allStatsContents' => $all_stats_contents
			)
		);

	}	
	
	/**
	 * Enqueue AJAX script that fires when the "Undo" link (on Local Like And Share >> View Statistics >> page [All-time tab] after all like counts have been reset) is clicked.
	 *
	 * @since	1.0.1
	 * @param	string	$hook	The current page name.
	 * @return	null	If this is not 'local-like-and-share-view-stats' page
	 */
	public function undo_reset_like_counts_enqueue( $hook ) {

		if ( 'local-like-and-share_page_local-like-and-share-view-stats' != $hook ) {
			
			return;
		}
		
		$llas_undo_reset_like_counts_nonce = wp_create_nonce( 'llas_undo_reset_like_counts' );
		wp_localize_script(
			$this->plugin_name
			,'llas_undo_reset_like_counts_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $llas_undo_reset_like_counts_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when the "Undo" link (on Local Like And Share >> View Statistics >> page [All-time tab] after all like counts have been reset) is clicked.
	 *
	 * @since	1.0.1
	 */
	public function undo_reset_like_counts_ajax_handler() {
	
		// Confirm matching nonce
		check_ajax_referer( 'llas_undo_reset_like_counts' );

		global $wpdb;
			
		$undo_last_update_dttm = $_POST['last_update_dttm'];
			
		// Un(soft-)delete all (flagged) like rows
		$num_likes_flagged_for_delete = $wpdb->update( 
			$wpdb->prefix.'local_like_and_share_user_like' 
			,array( 
				'to_delete' => 0
				,'last_update_dttm' => date( "Y-m-d H:i:s" )				
			)
			,array( 
				'to_delete' => 1
				,'last_update_dttm' => $undo_last_update_dttm
			)    			
		);				

		// Refresh post meta data with relevant like counts 
		Local_Like_And_Share_Misc::refresh_likes_and_or_shares( 'likes' );

		// Get View Stats innards contents	  
		$time_period = 'all-time';
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$all_stats_contents = $view_stats_innards['markup'];

		// Define reset undone message
		$action_message = '<p><strong>' . esc_html__( 'Like count reset has been undone.', 'local-like-and-share' ) . '</strong></p>';

		wp_send_json(
			array(
				'actionMessage' => $action_message
				,'allStatsContents' => $all_stats_contents
			)
		);
			
	}

	/**
	 * Enqueue AJAX script that fires when the "Undo" link (on Local Like And Share >> View Statistics >> page [All-time tab] after all share counts have been reset) is clicked.
	 *
	 * @since	1.0.1
	 * @param	string	$hook	The current page name.
	 * @return	null	If this is not 'local-like-and-share-view-stats' page
	 */
	public function undo_reset_share_counts_enqueue( $hook ) {

		if ( 'local-like-and-share_page_local-like-and-share-view-stats' != $hook ) {
			
			return;
		}
		
		$llas_undo_reset_share_counts_nonce = wp_create_nonce( 'llas_undo_reset_share_counts' );
		wp_localize_script(
			$this->plugin_name
			,'llas_undo_reset_share_counts_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $llas_undo_reset_share_counts_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when the "Undo" link (on Local Like And Share >> View Statistics >> page [All-time tab] after all share counts have been reset) is clicked.
	 *
	 * @since	1.0.1
	 */
	public function undo_reset_share_counts_ajax_handler() {
	
		// Confirm matching nonce
		check_ajax_referer( 'llas_undo_reset_share_counts' );

		global $wpdb;
			
		$undo_last_update_dttm = $_POST['last_update_dttm'];
			
		$num_shares_flagged_for_delete = $wpdb->update( 
			$wpdb->prefix.'local_like_and_share_user_share' 
			,array( 
				'to_delete' => 0
				,'last_update_dttm' => date( "Y-m-d H:i:s" )				
			)
			,array( 
				'to_delete' => 1
				,'last_update_dttm' => $undo_last_update_dttm
			)    			
		);				
			
		// Refresh post meta data with relevant share counts 
		Local_Like_And_Share_Misc::refresh_likes_and_or_shares('shares');

		// Get View Stats innards contents	  
		$time_period = 'all-time';
		$view_stats_innards = $this->populate_view_stats_innards( $time_period );
		$all_stats_contents = $view_stats_innards['markup'];

		// Define reset undone message
		$action_message = '<p><strong>' . esc_html__( 'Share count reset has been undone.', 'local-like-and-share' ) . '</strong></p>';
		
		wp_send_json(
			array(
				'actionMessage' => $action_message
				,'allStatsContents' => $all_stats_contents
			)
		);
			
	}
	
	/**
	 * Retrieve like and share counts for selected time period and generate markup to render data for display on View Statistics page
	 *
	 * @since	1.0.1
	 * @param	string	$time_period	The date range to limit data retrieval to.
	 * @return	array	The selected like and share counts and the markup to render this data.
	 */	
	public function populate_view_stats_innards( $time_period ) {
	
		$like_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'like', $time_period );
		$share_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( 'share', $time_period );
		
		// Generate View Stats innards markup	  
		$markup = '';
	 	ob_start();
		include( plugin_dir_path( __FILE__ ) . 'partials/local-like-and-share-admin-view-stats-innards.php' );
		$markup .= ob_get_clean();
		
		return array( 
			'markup' => $markup
			, 'like_counts_row_count' => count( $like_counts_arr ) 
			, 'share_counts_row_count' => count( $share_counts_arr ) 
		);
		
	}
					
}
