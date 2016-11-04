<?php

/**
 * A collection of miscellaneous functions that need to be accessible to 
 *	multiple classes.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */

/**
 * A collection of miscellaneous functions.
 *
 * Defines functions to handle:
 *		1) Format count value shown in like or share count bubble and (optionally) 
 *			in corresponding widget
 *		2) Refresh like and/or share counts for a specific time period
 *		3) Reload like or share counts, for a specific time period, into postmeta table
 *		4) Retrieve like or share count array from custom table
 *		5) Retrieve like or share count array from postmeta table
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Misc {
	
 	/**
	 * Format count value shown in like or share count bubble and (optionally) 
	 *	in corresponding widget.
	 *
	 * @since	1.0.5
	 * @param	int				$count_value	Count value to format.
	 * @return	string	Formatted count value.
	 */
	public static function format_count_display( $count_value ) {

		$local_like_and_share_options_arr = get_option( 'local_like_and_share_settings' );
				
		if ( ( 'no' == $local_like_and_share_options_arr['abbrev_large_count_vals'] ) || ( $count_value <= 1000 ) ) {
			return $count_value;
		}
   	
		switch ( true ) {
			
			// At least 1 billion
			case ( $count_value >= 1000000000 ):
				return floor( $count_value / 1000000000 ) . 'B+';

			// At least 1 million
   	   		case ( $count_value >= 1000000 ):
   	   			return floor( $count_value / 1000000 ) . 'M+';
   	   			
			// Greater than 1 thousand   	   			
   	   		case ( $count_value > 1000 ):
   	   			return floor( $count_value / 1000 ) . 'K+';
   	   	}

   	}
	
 	/**
	 * Refresh like and/or share counts for a specific time period.
	 *
	 * @since	1.0.5
	 * @param	string			$type	Type(s) of data ('like' or 'share' or 'both') to retrieve.
	 * @param	string Optional	$time_period	Time period to restrict data retrieval to (or null [none]).
	 */
	public static function refresh_likes_and_or_shares( $likes_shares_or_both, $time_period = null ) {

		if ( null == $time_period ) {
			
			// Get widget time period
			$time_period = 'all-time';
		
			$curr_widget_local_like_and_share_arr = get_option( 'widget_local-like-and-share');
			if ( $curr_widget_local_like_and_share_arr ) {
				  
				// Widget IS defined

				// Find time_period in widget array 
				foreach ( $curr_widget_local_like_and_share_arr as $arr_key => $arr_item ) {
					if ( is_array( $arr_item ) ) {
						if ( array_key_exists( 'time_period', $arr_item ) ) {							
					
							// Widget exists with admin's selected time period
							$time_period = $arr_item['time_period'];
							break;
						}
					}
				}

			}		
		}

		if ( ( 'both' == $likes_shares_or_both ) || ( 'likes' == $likes_shares_or_both ) ) {
			$posts_processed_for_likes = Local_Like_And_Share_Misc::reload_like_or_share_post_meta_data( 'like', $time_period );
		}
		
		if ( ( 'both' == $likes_shares_or_both ) || ( 'shares' == $likes_shares_or_both ) ) {
			$posts_processed_for_shares = Local_Like_And_Share_Misc::reload_like_or_share_post_meta_data( 'share', $time_period );
		}
		
	}
	
 	/**
	 * Reload like or share counts, for a specific time period, into postmeta table.
	 *
	 * @since	1.0.5
	 * @param	string			$type	Type of data ('like' or 'share') to retrieve.
	 * @param	string			$time_period	Time period to restrict data retrieval to.
	 * @return	int	The number of posts found, for specified type, for specified time period.
	 */
	public static function reload_like_or_share_post_meta_data( $type, $time_period ) {
		
		delete_post_meta_by_key( 'local_like_and_share_' . $type . '_total' );	

		$counts_arr = Local_Like_And_Share_Misc::retrieve_like_or_share_count_array( $type, $time_period );
		
		foreach ( $counts_arr as $count_row ) {	
			update_post_meta( $count_row['post_id'], 'local_like_and_share_' . $type . '_total', $count_row[ $type . '_count' ] );			
		}
		
		return count( $counts_arr ); 
		
	}

 	/**
	 * Retrieve like or share count array from custom table.
	 *
	 * @since	1.0.0
	 * @param	string			$type	Type of data ('like' or 'share') to retrieve.
	 * @param	string			$time_period	Time period to restrict data retrieval to.
	 * @param	int	Optional	$row_limit	Row limit (or null [none]) to restrict data retrieval to.
	 * @return	array	The like or share data, retrieved for specified time period.
	 */
	public static function retrieve_like_or_share_count_array( $type, $time_period, $row_limit = null ) {

		global $wpdb;

		// Define table and column variables, for use in generic SQL statement, based on $type parameter
		if ( 'like' == $type ) {
			$count_column = 'like_count';
			$date_column = 'date_liked';
			$table_name = $wpdb->prefix.'local_like_and_share_user_like';
		}
		elseif ( 'share' == $type ) {
			$count_column = 'share_count';
			$date_column = 'date_shared';
			$table_name = $wpdb->prefix.'local_like_and_share_user_share';
		}
		else {
			return array();
		}
				
		// Build appropriate WHERE clause based on specific time period selected
		switch ( $time_period ) {
			case '24-hours':
			
				// Calculate 24 hours ago				
				$date_range_start_date = date( "Y-m-d H:i:s"
					,mktime( date( "H" ) - 24
						,date( "i" )
						,date( "s" )
						,date( "m" )
						,date( "d" )
						,date( "Y" )
					) 
				);
				break;
			
			case '7-days':

				// Calculate 7 days ago				
				$date_range_start_date = date( "Y-m-d H:i:s"
					,mktime( date( "H" )
						,date( "i" )
						,date( "s" )
						,date( "m" )
						,date( "d" ) - 7
						,date( "Y" )
					) 
				);
				break;
			
			case '30-days':
			
				// Calculate 30 days ago				
				$date_range_start_date = date( "Y-m-d H:i:s"
					,mktime( date( "H" )
						,date( "i" )
						,date( "s" )
						,date( "m" )
						,date( "d" ) - 30
						,date( "Y" )
					) 
				);
				break;
			
			default:
			
				// No time period specified so ALL (non-flagged for deletion) rows should be selected
				$date_range_start_date = '';
			
		}
		
		// Only select rows that are NOT flagged for deletion
		$where_clause = 'WHERE to_delete = 0';
		if ( ! empty( $date_range_start_date ) ) {		
			$where_clause .= " AND " . $date_column . " BETWEEN '" . $date_range_start_date . "' AND '" . date("Y-m-d 23:59:59") . "'";
		}
		
		if ( $row_limit ) {
			$limit_clause = 'LIMIT ' . $row_limit;
		}
		else {
			$limit_clause = '';
		}

		// Get Like or Share data
		$like_or_share_counts_arr = $wpdb->get_results(
			"
   			SELECT COUNT(user_identifier) AS $count_column
   				,post_id 
   			FROM $table_name
   			$where_clause
   			GROUP BY post_id
   			ORDER BY $count_column DESC
   				,post_id
   			$limit_clause
   			"
   			,ARRAY_A
   		);
   	
   		// Get post title, permalink for each
   		foreach ( $like_or_share_counts_arr as $row_key => $row_val ) {
   			$post_object = get_post( $row_val['post_id'] );
   			$like_or_share_counts_arr[ $row_key ]['post_title'] = $post_object->post_title;
   			$like_or_share_counts_arr[ $row_key ]['post_url'] = get_permalink( $row_val['post_id'] );   			
    	}
    	
    	return $like_or_share_counts_arr;

	}

 	/**
	 * Retrieve like or share count array from postmeta table.
	 *
	 * @since	1.0.5
	 * @param	string			$type	Type of data ('like' or 'share') to retrieve.
	 * @param	int	Optional	$row_limit	Row limit (or null [none]) to restrict data retrieval to.
	 * @return	array	The like or share data, retrieved for specified time period.
	 */
	public static function retrieve_like_or_share_count_array_postmeta( $type, $row_limit = null ) {

		global $wpdb;

		$table_name = $wpdb->prefix.'postmeta';

		// Define table and column variables, for use in generic SQL statement, based on $type parameter
		if ( 'like' == $type ) {
			$count_column = 'like_count';
			$where_clause = "WHERE meta_key = 'local_like_and_share_like_total'";
		}
		elseif ( 'share' == $type ) {
			$count_column = 'share_count';
			$where_clause = "WHERE meta_key = 'local_like_and_share_share_total'";
		}
		else {
			return array();
		}
								
		if ( $row_limit ) {
			$limit_clause = 'LIMIT ' . $row_limit;
		}
		else {
			$limit_clause = '';
		}
			
		// Get Like or Share data
		$like_or_share_counts_arr = $wpdb->get_results(
			"
   			SELECT meta_value AS $count_column
   				,post_id 
   			FROM $table_name
   			$where_clause
   			ORDER BY CAST($count_column AS UNSIGNED) DESC
   				,post_id
   			$limit_clause
   			"
   			,ARRAY_A
   		);
   	
   		// Get post title, permalink for each
   		foreach ( $like_or_share_counts_arr as $row_key => $row_val ) {
   			$post_object = get_post( $row_val['post_id'] );
   			$like_or_share_counts_arr[ $row_key ]['post_title'] = $post_object->post_title;
   			$like_or_share_counts_arr[ $row_key ]['post_url'] = get_permalink( $row_val['post_id'] );   			
    	}
    	
    	return $like_or_share_counts_arr;
		
	}
	
}
