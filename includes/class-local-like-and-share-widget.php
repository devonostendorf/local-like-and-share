<?php

/**
 * Local Like And Share Widget
 *
 * This plugin was built using the exceptional WordPress Widget Boilerplate 
 *	(https://github.com/tommcfarlin/WordPress-Widget-Boilerplate) written by Tom 
 *	McFarlin (http://tommcfarlin.com).]
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */
 
// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

/**
 * The widget functionality of the plugin.
 *
 * Defines both the admin and public-facing functionality of the Local Like And Share
 * widget.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/admin
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Widget extends WP_Widget {

	/**
	 * Unique identifier for the widget.
	 *
	 * @since	1.0.0
	 * @access	protected
	 * @var		string	Unique identifier for the widget.
	 */
    protected $widget_slug = 'local-like-and-share';

	/**
	 * Initialize the class, specify the classname and description, instantiate
	 *	the widget, load localization files, and include necessary stylesheets
	 *	and JavaScript.
	 *
	 * @since	1.0.0
	 */
	public function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		parent::__construct(
			$this->get_widget_slug()
			,'Local Like And Share'
			,array(
				'classname'  => 'class-'.$this->get_widget_slug()				
				,'description' => __( "Your site's most liked and/or most shared posts.", $this->get_widget_slug() )
			)
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	}

	/**
	 * Return the widget slug.
	 *
	 * @since	1.0.0
	 * @return	string	The widget's slug.
	 */
	public function get_widget_slug() {
   		  
		return $this->widget_slug;
        
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since	1.0.0
	 * @param	array	$args	The array of form elements
	 * @param	array	$instance	The current instance of the widget
	 * @return	string	Outputted widget content.
	 */
	public function widget( $args, $instance ) {
		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset ( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		
		if ( isset ( $cache[ $args['widget_id'] ] ) ) {
			
			return print $cache[ $args['widget_id'] ];
		}
		
		extract( $args, EXTR_SKIP );
		
		
		// Retrieve posts to show, limiting by time period and number of posts to show		

		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );
		$row_limit = $instance['number_of_posts_to_show'];
		
		$like_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array_postmeta( 'like', $row_limit );
		$no_likes_found_message = $local_like_and_share_options_arr['widget_info_message_no_likes_found'];

		$share_counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array_postmeta( 'share', $row_limit );
		$no_shares_found_message = $local_like_and_share_options_arr['widget_info_message_no_shares_found'];
		
		$numbered_result_margin = $instance['numbered_result_margin'];

		$widget_string = $before_widget;

		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;
		$cache[ $args['widget_id'] ] = $widget_string;
		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );
		print $widget_string;

	}
	
	/**
	 * Flush widget's cache.
	 *
	 * @since	1.0.0
	 */
	public function flush_widget_cache() {
			  
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
    	
	}
	
	/**
	 * Processes the widget's values to be saved.
	 *
	 * @since	1.0.0
	 * @param	array	$new_instance	The new instance of values to be generated via the update.
	 * @param	array	$old_instance	The previous instance of values before the update.
	 * @return	array	The values, entered into widget fields by user, to be saved. 
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// Update widget's old values with the new, incoming values
		$instance['show_like_section'] = isset( $new_instance['show_like_section'] ) ? (bool) $new_instance['show_like_section'] : false;
		$instance['like_title'] = strip_tags( $new_instance['like_title'] );
		$instance['show_share_section'] = isset( $new_instance['show_share_section'] ) ? (bool) $new_instance['show_share_section'] : false;
		$instance['share_title'] = strip_tags( $new_instance['share_title'] );
		$instance['time_period'] = strip_tags( $new_instance['time_period'] );
		
		if ( (! isset( $old_instance['time_period'] ) ) || ( $new_instance['time_period'] != $old_instance['time_period'] ) ) {
			
			// Time period is undefined or has changed, so post meta data counts need to be refreshed for selected time period
			$posts_processed = Local_Like_And_Share_Misc::refresh_likes_and_or_shares( 'both', $new_instance['time_period']);
			
		}
		
		$instance['number_of_posts_to_show'] = strip_tags( $new_instance['number_of_posts_to_show'] );
		$instance['show_like_share_count'] = isset( $new_instance['show_like_share_count'] ) ? (bool) $new_instance['show_like_share_count'] : false;
		$instance['numbered_result_margin'] = strip_tags( $new_instance['numbered_result_margin'] );		
		
		$this->flush_widget_cache();
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions[ $this->get_widget_slug() ] ) ) {
			delete_option( $this->get_widget_slug() );
		}
		
		return $instance;

	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @since	1.0.0
	 * @param	array	$instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance );
		
		// Get widget defaults from options
		$like_and_share_widget_defaults_arr = get_option( 'local_like_and_share_widget_defaults' );
		$show_like_section = isset( $instance['show_like_section'] ) ? (bool) $instance['show_like_section'] : false;
		$like_title = isset( $instance['like_title'] ) ? esc_attr( $instance['like_title'] ) : $like_and_share_widget_defaults_arr['like_title_default'];
		$show_share_section = isset( $instance['show_share_section'] ) ? (bool) $instance['show_share_section'] : false;
		$share_title = isset( $instance['share_title'] ) ? esc_attr( $instance['share_title'] ) : $like_and_share_widget_defaults_arr['share_title_default'];
		$time_period = isset( $instance['time_period'] ) ? esc_attr( $instance['time_period'] ) : $like_and_share_widget_defaults_arr['time_period_default'];
		$number_of_posts_to_show = isset( $instance['number_of_posts_to_show'] ) ? esc_attr( $instance['number_of_posts_to_show'] ) : $like_and_share_widget_defaults_arr['number_of_posts_to_show_default'];
		$show_like_share_count = isset( $instance['show_like_share_count'] ) ? (bool) $instance['show_like_share_count'] : false;
		$numbered_result_margin = isset( $instance['numbered_result_margin'] ) ? esc_attr( $instance['numbered_result_margin'] ) : $like_and_share_widget_defaults_arr['numbered_result_margin_default'];
			
		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	}

	/**
	 * Loads the Widget's text domain for localization and translation.
	 *
	 * @since	1.0.0
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'language/' );

	}

} // end class
add_action( 'widgets_init', create_function( '', 'register_widget("Local_Like_And_Share_Widget");' ) );
