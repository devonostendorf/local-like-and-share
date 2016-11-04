<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		Local_Like_And_Share_Loader	$loader	Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		string	$plugin_name	The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		string	$version	The current version of the plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'local-like-and-share';
		$this->version = '1.0.6';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Local_Like_And_Share_Loader. Orchestrates the hooks of the plugin.
	 * - Local_Like_And_Share_i18n. Defines internationalization functionality.
	 * - Local_Like_And_Share_Admin. Defines all hooks for the admin area.
	 * - Local_Like_And_Share_Public. Defines all hooks for the public side of the site.
	 * - Local_Like_And_Share_Widget. Defines all widget functionality.
	 * - Local_Like_And_Share_Misc. Defines miscellaneous functions for use by other classes.
	 * - Local_Like_And_Share_Updater. Ensures plugin-specific options and tables are current.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-local-like-and-share-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-local-like-and-share-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-local-like-and-share-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-local-like-and-share-public.php';

		/**
		 * The class responsible for creating widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-local-like-and-share-widget.php';

		/**
		 * The class containing miscellaneous functions that need to be available to other classes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-local-like-and-share-misc.php';

		/**
		 * The class responsible for applying options and/or table updates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-local-like-and-share-updater.php';

		$this->loader = new Local_Like_And_Share_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Local_Like_And_Share_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function set_locale() {

		$plugin_i18n = new Local_Like_And_Share_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Local_Like_And_Share_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	
		// Perform check for options and/or table updates
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'update_check' );		

		// Change time period (on Local Like And Share >> View Statistics page) functionality
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'view_stats_enqueue' );
		$this->loader->add_action( 'wp_ajax_llas_view_stats', $plugin_admin, 'change_stats_time_period_ajax_handler' );
		
		// Reset/Undo reset like and share counts (on Local Like And Share >> View Statistics page) functionality
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'reset_like_counts_enqueue' );
		$this->loader->add_action( 'wp_ajax_llas_reset_like_counts', $plugin_admin, 'reset_like_counts_ajax_handler' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'reset_share_counts_enqueue' );
		$this->loader->add_action( 'wp_ajax_llas_reset_share_counts', $plugin_admin, 'reset_share_counts_ajax_handler' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'undo_reset_like_counts_enqueue' );
		$this->loader->add_action( 'wp_ajax_llas_undo_reset_like_counts', $plugin_admin, 'undo_reset_like_counts_ajax_handler' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'undo_reset_share_counts_enqueue' );
		$this->loader->add_action( 'wp_ajax_llas_undo_reset_share_counts', $plugin_admin, 'undo_reset_share_counts_ajax_handler' );
		
		// Add submenu to Settings menu 
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_local_like_and_share_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_local_like_and_share_settings' );

		// Add Local Like And Share top level menu to the admin menu sidebar
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_local_like_and_share_admin_menu' );

		// Language-specific translation check functionality
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'translation_check' );
		$this->loader->add_action( 'wp_ajax_language_nag_dismiss', $plugin_admin, 'translation_nag_screen_ajax_handler' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function define_public_hooks() {

		$plugin_public = new Local_Like_And_Share_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Display Like and Share buttons on posts
		$this->loader->add_filter( 'the_content', $plugin_public, 'add_like_and_share_buttons_to_content' );

		// Like button functionality
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'like_button_clicked_enqueue' );
		$this->loader->add_action( 'wp_ajax_like_button_clicked', $plugin_public, 'like_button_clicked_ajax_handler' );
		$this->loader->add_action( 'wp_ajax_nopriv_like_button_clicked', $plugin_public, 'like_button_clicked_ajax_handler' );

		// Share button functionality
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'share_button_clicked_enqueue' );
		$this->loader->add_action( 'wp_ajax_share_button_clicked', $plugin_public, 'share_button_clicked_ajax_handler' );
		$this->loader->add_action( 'wp_ajax_nopriv_share_button_clicked', $plugin_public, 'share_button_clicked_ajax_handler' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since	1.0.0
	 */
	public function run() {
			  
		$this->loader->run();
		
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since	1.0.0
	 * @return	string	The name of the plugin.
	 */
	public function get_plugin_name() {
			  
		return $this->plugin_name;
		
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since	1.0.0
	 * @return	Local_Like_And_Share_Loader	Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
			  
		return $this->loader;
		
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since	1.0.0
	 * @return	string	The version number of the plugin.
	 */
	public function get_version() {
			  
		return $this->version;
		
	}

}
