<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueues the public-facing
 *	JavaScript.
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/public
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Public {

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
	 * @param	string	$plugin_name	The name of the plugin.
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
		 
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/local-like-and-share-public.min.css', array(), $this->version, 'all' );

		// Define all configurable styling here (everything else is in .css file) 
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		$btn_hover_message_background_color = $local_like_and_share_options_arr['btn_hover_message_background_color'];
		$btn_hover_message_text_color = $local_like_and_share_options_arr['btn_hover_message_text_color'];

		$count_background_color = $local_like_and_share_options_arr['count_background_color'];
		$count_outline_color = $local_like_and_share_options_arr['count_outline_color'];
		$count_text_color = $local_like_and_share_options_arr['count_text_color'];
	
		$like_button_color = $local_like_and_share_options_arr['like_btn_color'];
		$like_button_hover_color = $local_like_and_share_options_arr['like_btn_hover_color'];

		$share_button_color = $local_like_and_share_options_arr['share_btn_color'];
		$share_button_hover_color = $local_like_and_share_options_arr['share_btn_hover_color'];
		
		if ( 'left' == $local_like_and_share_options_arr['button_posn_horiz'] ) {
		
			// Position button to left of post
			$button_posn = 'float:left;margin:0px 10px 10px 0px';
		} 
		else {
			
			// Position button to right of post
			$button_posn = 'float:right;margin:0px 0px 10px 10px';
		}

		$llas_buttons_style = '
			.llas-like-button-active {
				' . $button_posn . ';			
			}
			.llas-like-button-active i {
				cursor: pointer;
				cursor: hand;
			}
			.llas-like-button-active a,
			.llas-like-button-active a:visited,
			.llas-like-button-active a:focus {
				color: ' . esc_html( $like_button_color ) . ';
			}
			.llas-like-button-active a:hover {
				color: ' . esc_html( $like_button_hover_color ) . ';
			}
			.llas-like-button-inactive {
				' . $button_posn . ';			
			}
			.llas-like-button-inactive a,
			.llas-like-button-inactive a:visited,
			.llas-like-button-inactive a:focus,
			.llas-like-button-inactive a:hover {
				color: ' . esc_html( $like_button_color ) . ';
			}

			.llas-share-button-active {
				' . $button_posn . ';			
			}
			.llas-share-button-active i {
				cursor: pointer;
				cursor: hand;
			}
			.llas-share-button-active a,
			.llas-share-button-active a:visited,
			.llas-share-button-active a:focus {
				color: ' . esc_html( $share_button_color ) . ';
			}
			.llas-share-button-active a:hover {
				color: ' . esc_html( $share_button_hover_color ) . ';
			}

			.llas-callout {
				background-color: ' . esc_html( $count_background_color ) . ';
				color: ' . esc_html( $count_text_color ) . ';
			}
			.llas-callout .llas-notch {
				border-right: 5px solid ' . esc_html( $count_background_color ). ';		
			}
			.llas-border-callout {
				border: 1px solid ' . esc_html( $count_outline_color ) . ';
				padding: 2px 9px;
			}
			.llas-border-callout .llas-border-notch {
				border-right-color: ' . esc_html( $count_outline_color ) . ';
				left: -6px;
			}	
			
			.tipsy-inner { 
				background-color: ' . esc_html( $btn_hover_message_background_color ) . ';
				color: ' . esc_html( $btn_hover_message_text_color ) . ';
				max-width: 200px;
				padding: 5px 8px 4px 8px;
				text-align: center;	
				font-size: 13px;
			}
			.tipsy-arrow-n {
				border-bottom-color: ' . esc_html( $btn_hover_message_background_color ) . ';
			}
		';
		wp_add_inline_style( $this->plugin_name, $llas_buttons_style );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Local_Like_And_Share_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Local_Like_And_Share_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/local-like-and-share-public.min.js', array( 'jquery' ), $this->version, false );

	}

	
	// Functions related to display of like and share buttons and (AJAX) handling of 
	//	users pressing them!
	
	/**
	 * Add the Like and Share buttons to the current post (if configured to do so).
	 *
	 * @since	1.0.0
	 * @param	string	$content	The contents of the current post.
	 * @return	string	The contents of the current post.
	 */
	public function add_like_and_share_buttons_to_content( $content ) {

		global $post;

		// Only show buttons on published posts
		if ( ( 'post' != $post->post_type ) || ( 'publish' != $post->post_status ) ) {
			
			return $content;
		}
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );
			
		if ( is_singular() ) {
			if ( ('no' == $local_like_and_share_options_arr['like_show_on_single'] )
				&& ( 'no' == $local_like_and_share_options_arr['share_show_on_single'] ) ) {
			
				return $content;
			}
			else {

				// IS singular and like and/or share IS selected
				$buttons_html = $this->display_like_and_share_buttons( $local_like_and_share_options_arr['like_show_on_single'], $local_like_and_share_options_arr['share_show_on_single'], $local_like_and_share_options_arr['button_posn_horiz'] );
			}
		}
		else { // IS an index page of some sort
			if ( ( 'no' == $local_like_and_share_options_arr['like_show_on_post_index'] )
				&& ( 'no' == $local_like_and_share_options_arr['share_show_on_post_index'] ) ) {
			
				return $content;
			}
			else {

				// IS an index page and like and/or share IS selected
				$buttons_html = $this->display_like_and_share_buttons( $local_like_and_share_options_arr['like_show_on_post_index'], $local_like_and_share_options_arr['share_show_on_post_index'], $local_like_and_share_options_arr['button_posn_horiz'] );
			}			
		}
					
		// NOTE: Though organizationally this arguably belongs in display_like_and_share_buttons(), passing $content
		//	as a parm to another function might slow things down.
		if ( 'bottom' == $local_like_and_share_options_arr['button_posn_vert'] ) {
			
			// Position button below post
			$content = $content . $buttons_html;
		}
		else {
			
			// Position button above post
			$content = $buttons_html . '<br />' .  $content;
		}			
				
		return $content;
		
	}
	
	/**
	 * Conditionally add Like and/or Share button(s) to HTML string and do some positioning too.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @param	string	$show_like_button	Whether to display Like button ('yes' or 'no').
	 * @param	string	$show_share_button	Whether to display Share button ('yes' or 'no').
	 * @param	string	$horiz_align	The horizontal alignment of the button set ('left' or 'right').
	 * @return	string	The Like and/or Share button(s) HTML.
	 */
	private function display_like_and_share_buttons( $show_like_button, $show_share_button, $horiz_align ) {
		
		$like_button_html = '';
		$share_button_html = '';
		
		if ( 'yes' == $show_like_button ) {					
			$like_button_html = $this->add_like_button_to_content();				
		}
		
		if ( 'yes' == $show_share_button ) {
			$share_button_html = $this->add_share_button_to_content();				
		}	
		
		if ( 'right' == $horiz_align ) {
				
			// Because of "float: right" we need to flip code sequence of buttons to maintain proper display sequence
			$buttons_html = $share_button_html . $like_button_html;
		}
		else {
					
			// "float: left" is fine as-is, sequence-wise
			$buttons_html = $like_button_html . $share_button_html;
		}				
						
		return $buttons_html;
		
	}
	
	/**
	 * Actually generate HTML to render Like button.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @return	string	The Like button HTML.
	 */
	private function add_like_button_to_content() {

		global $post;
		global $wpdb;
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		// Get like total for specific post from post meta data
		$like_total = get_post_meta( get_the_ID(), 'local_like_and_share_like_total', true );
		if ( empty( $like_total ) ) {
			$like_total = 0;
		}
			
		$button_icon = '<i class="icon icon-heart"></i>';
		
		$like_count_span = 
			'<span id="id_spnLikeCount" class="llas-callout llas-border-callout">'
			. Local_Like_And_Share_Misc::format_count_display( $like_total )
    		. '<b class="llas-border-notch llas-notch"></b>'
    		. '<b class="llas-notch"></b>'
			. '</span>'
		;
		
		$user_already_liked = $this->current_user_already_liked_post( $this->get_current_user_identifier(), get_the_ID() );
		if ( $user_already_liked ) {
					  
			// Current user/visitor HAS already liked this post - display inactive button (with tooltip message) and current like count
			$button_link = '<a id="id_dummy" rel="tipsy" title="' . esc_attr( $local_like_and_share_options_arr['like_btn_hover_info_message_already_liked'] ) . '">';

			$like_button = '<div class="llas-like-button-inactive">' 
				. $button_link
				. $button_icon
				. '</a>'
				. $like_count_span 
				. '</div>'
			;

		}
		else {

			// Current user/visitor has NOT yet liked this post
			$button_link = '<a class="like_button" id="id_lnkLikeButton_' . get_the_ID() . '" data-post-id="' . get_the_ID() . '" rel="tipsy" title="' . esc_attr( $local_like_and_share_options_arr['like_btn_hover_call_to_action'] ) . '">';

			$like_button = '<div class="llas-like-button-active" id="id_divLikeButton_' . get_the_ID() . '">' 
				. $button_link
				. $button_icon
				. '</a>'
				. $like_count_span 
				. '</div>'
			;

		}
		
		return $like_button;
		
	}

	/**
	 * Has current user already liked this post?
	 *
	 * @since	1.0.0
	 * @access	private
	 * @param	string	$current_user_id	The current user's identifier.
	 * @param	string	$post_id	The current post ID.
	 * @return	string	Whether the current user has already liked the current post (0 or 1).
	 */
	private function current_user_already_liked_post( $current_user_id, $post_id ) {

		global $wpdb;
	
		// Check to see if $current_user_id has already liked this post
		$user_already_liked = $wpdb->get_var( 
			$wpdb->prepare(
				"SELECT COUNT(user_identifier) FROM " . $wpdb->prefix.'local_like_and_share_user_like' . " WHERE post_id = %s AND user_identifier = %s AND to_delete = 0"
				,$post_id
				,$current_user_id
			)		
		);

		return $user_already_liked;

	}

	/**
	 * Get current user's identifier.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @return	string	The current user's identifier.
	 */
	private function get_current_user_identifier() {

		if ( is_user_logged_in() ) {
				  
			// Current visitor is a signed in user
			$current_user = wp_get_current_user();
			$current_user_id = $current_user->ID;
    	}
    	else {
    			 
    		// Capture visitor's IP address
    		$client_ip  = @$_SERVER['HTTP_CLIENT_IP'];
    		$forwarded_ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    		$remote_ip  = $_SERVER['REMOTE_ADDR'];
    		if ( filter_var( $client_ip, FILTER_VALIDATE_IP ) ) {
    			$current_user_id = $client_ip;
    		}
    		elseif ( filter_var( $forwarded_ip, FILTER_VALIDATE_IP ) ) {
    			$current_user_id = $forwarded_ip;
    		}
    		else {
    			$current_user_id = $remote_ip;
    		}    			  
    	}
    				
		return $current_user_id;

	}
	
	/**
	 * Actually generate HTML to render Share button.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @return	string	The Share button HTML.
	 */
	private function add_share_button_to_content() {
		
		global $post;
		global $wpdb;
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		// Get share total for specific post from post meta data
		$share_total = get_post_meta( get_the_ID(), 'local_like_and_share_share_total', true );
		if ( empty( $share_total ) ) {
			$share_total = 0;
		}
		  		
		$button_icon = '<i class="icon icon-share"></i>';
		
		$share_count_span = 
			'<span id="id_spnShareCount" class="llas-callout llas-border-callout">'
			. Local_Like_And_Share_Misc::format_count_display( $share_total )
    		. '<b class="llas-border-notch llas-notch"></b>'
    		. '<b class="llas-notch"></b>'
			. '</span>'
		;
		
		$current_user_id = $this->get_current_user_identifier();

		
   		// Replace variables in both the share post email subject and body 
   			
   		$post_attribs = get_post( get_the_ID() ); 
   		$post_title = $post_attribs->post_title;
   		$post_permalink = get_permalink( get_the_ID() );

   		$share_email_subject = $local_like_and_share_options_arr['share_eml_subj'];
   		$share_email_subject = str_replace( '@@blogname', get_bloginfo('name'), $share_email_subject );
   		$share_email_subject = str_replace( '@@posttitle', $post_title, $share_email_subject );
   		$share_email_subject = str_replace( ' ', '%20', $share_email_subject );
   			   			
   		$share_email_body = $local_like_and_share_options_arr['share_eml_body'];
   		$share_email_body = str_replace( '@@blogname', get_bloginfo('name'), $share_email_body );
   		$share_email_body = str_replace( '@@posttitle', $post_title, $share_email_body );
   		$share_email_body = str_replace( '@@permalink', $post_permalink, $share_email_body ); 			
   		$share_email_body = str_replace( ' ', '%20', $share_email_body );
     	$share_email_body = str_replace( '<br>', '%0A', $share_email_body );
  			  		
		$button_link = '<a class="share_button" href="mailto:'
			. '?subject='  . esc_attr( $share_email_subject )
			. '&body=' . esc_attr( $share_email_body )
			. '" '
			. 'id="id_lnkShareButton_' . get_the_ID() . '" data-post-id="' . get_the_ID() . '" rel="tipsy" title="' . esc_attr( $local_like_and_share_options_arr['share_btn_hover_call_to_action'] ) . '">';

		$share_button = '<div class="llas-share-button-active" id="id_divShareButton_' . get_the_ID() . '">'
			. $button_link
			. $button_icon
			. '</a>'
			. $share_count_span 
			. '</div>'
		;

		return $share_button;
			
	}			
	
	/**
	 * Enqueue AJAX script that fires when "Like" button (on post) is pressed.
	 *
	 * @since	1.0.0
	 * @param	string	$hook	The current page name.
	 */
	public function like_button_clicked_enqueue( $hook ) {
	
		$like_button_clicked_nonce = wp_create_nonce( 'like_button_clicked' );
		wp_localize_script(
			$this->plugin_name
			,'like_button_clicked_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $like_button_clicked_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when "Like" button (on post) is pressed.
	 *
	 * @since	1.0.0
	 */	
	public function like_button_clicked_ajax_handler() {
			  
		// Confirm matching nonce
		check_ajax_referer( 'like_button_clicked' );
		
		global $wpdb;
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		$post_id = $_POST['post_id'];		
		$button_id = $_POST['btn_id'];
		
		// Button number starts at position 17 in $button_id (due to prefix of 'id_lnkLikeButton_')
		$button_num = substr( $button_id, 17);

		// Get like total for specific post from post meta data
		$like_total = get_post_meta( $post_id, 'local_like_and_share_like_total', true );
		if ( empty( $like_total ) ) {
			$like_total = 0;
		}	
		
 		$button_icon = '<i class="icon icon-heart"></i>';

		// Confirm user has not previously liked this
		$current_user_id = $this->get_current_user_identifier();
		$user_already_liked = $this->current_user_already_liked_post( $current_user_id, $post_id );

		if ( ! $user_already_liked ) {

			// User has NOT yet liked this
		
			// Update post like count
			$like_total += 1;
			$like_count_span = 
				'<span id="id_spnLikeCount" class="llas-callout llas-border-callout">'
				. Local_Like_And_Share_Misc::format_count_display( $like_total )
    			. '<b class="llas-border-notch llas-notch"></b>'
    			. '<b class="llas-notch"></b>'
				. '</span>'
			;

			// Update like count in post meta data
			update_post_meta( $post_id, 'local_like_and_share_like_total', $like_total );
			
			// Insert row into user like table indicating that this user or IP has 
			//		liked this post
			$llas_user_row_inserted = $wpdb->insert( 
				$wpdb->prefix.'local_like_and_share_user_like' 
				,array( 
					'post_id' => $post_id
					,'user_identifier' => $current_user_id
					,'date_liked' => date( "Y-m-d H:i:s" )
					,'to_delete' => 0
					,'last_update_dttm' => date( "Y-m-d H:i:s" )
				) 
			);

   			if ( $llas_user_row_inserted ) {
				$button_link = '<a id="id_dummy" rel="tipsy" title="' . esc_attr( $local_like_and_share_options_arr['like_btn_hover_success_message'] ) . '">';				

				$like_button_html =
					$button_link
					. $button_icon
					. '</a>'
					. $like_count_span 
				;

				$like_button_clicked_msg = $like_button_html;

   			}
			else {

				// Like row insert FAILED
				// Noop - "like_btn_hover_call_to_action" message remains in place
		
				// Manually kill AJAX handler
 				wp_die();
			}
		}
		else {

			// User ALREADY liked this!
			$like_count_span = 
				'<span id="id_spnLikeCount" class="llas-callout llas-border-callout">'
				. Local_Like_And_Share_Misc::format_count_display( $like_total )
    			. '<b class="llas-border-notch llas-notch"></b>'
    			. '<b class="llas-notch"></b>'
				. '</span>'
			;
			
			$button_link = '<a id="id_dummy" rel="tipsy" title="' . esc_attr( $local_like_and_share_options_arr['like_btn_hover_info_message_already_liked'] ) . '">';

			$like_button_html =
				$button_link
				. $button_icon
				. '</a>'
				. $like_count_span 
			;

  			$like_button_clicked_msg = $like_button_html; 
		}

  		wp_send_json( array( 'button_num' => $button_num, 'message' => $like_button_clicked_msg ) );
  		  		
  	}

	/**
	 * Enqueue AJAX script that fires when "Share" button (on post) is pressed.
	 *
	 * @since	1.0.0
	 * @param	string	$hook	The current page name.
	 */
	public function share_button_clicked_enqueue( $hook ) {
	
		$share_button_clicked_nonce = wp_create_nonce( 'share_button_clicked' );
		wp_localize_script(
			$this->plugin_name
			,'share_button_clicked_ajax_obj'
			,array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
				,'nonce' => $share_button_clicked_nonce
			)
		);  

	}
	
	/**
	 * Handle AJAX event sent when "Share" button (on post) is pressed.
	 *
	 * @since	1.0.0
	 */	
	public function share_button_clicked_ajax_handler() {
			  
		// Confirm matching nonce
		check_ajax_referer( 'share_button_clicked' );
		
		global $wpdb;
		
		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );

		$post_id = $_POST['post_id'];
		$current_user_id = $this->get_current_user_identifier();

		// Update share count in post meta data
		$share_total = get_post_meta( $post_id, 'local_like_and_share_share_total', true );
		if ( ! empty( $share_total ) ) {
			$share_total += 1;
		}
		else {
			$share_total = 1;
		}
		update_post_meta( $post_id, 'local_like_and_share_share_total', $share_total );
		
		// Insert row into user like table indicating that this user or IP has 
		//		shared this post						
		$llas_user_row_inserted = $wpdb->insert( 
			$wpdb->prefix.'local_like_and_share_user_share' 
			,array( 
				'post_id' => $post_id
				,'user_identifier' => $current_user_id
				,'date_shared' => date( "Y-m-d H:i:s" )
				,'to_delete' => 0
				,'last_update_dttm' => date( "Y-m-d H:i:s" )
			) 
		);
					
   		if ( $llas_user_row_inserted ) {
			wp_send_json( array( 'message' => 'success' ) );
		}
		
		// Share row insert failed, exit
		wp_die();
		
   }
      
}	
