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
 *		1) Retrieve Like or Share count array
 *
 * @since		1.0.0
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 * @author		Devon Ostendorf <devon@devonostendorf.com>
 */
class Local_Like_And_Share_Misc {
	
 	/**
	 * Retrieve Like or Share count array.
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
			
				// No WHERE clause so ALL rows should be selected
				$date_range_start_date = '';
			
		}
		
		if ( ! empty( $date_range_start_date ) ) {		
			$where_clause = "WHERE " . $date_column . " BETWEEN '" . $date_range_start_date . "' AND '" . date("Y-m-d 23:59:59") . "'";
		}
		else {
		
			// All-time selected, no WHERE clause needed
			$where_clause = '';
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
	
}
