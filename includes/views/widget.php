<?php

/**
 * Public form for the widget.
 *
 * This markup generates the public-facing widget.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */
if ( $instance['show_like_section'] ) {
	echo '<p>';
	if ( ! empty ($instance['like_title'] )) {
		echo $args['before_title'] . $instance['like_title'] . $args['after_title'];
	}	 
	if ( count( $like_counts_arr ) ) {

		// At least 1 like found
		echo '<ol id="id_olLikeStats">';
		foreach ( $like_counts_arr as $like_row ) {
			
			// Use admin-defined margin for numbered results to account for a plethora of theme formats		
			echo '<li style="margin-left: ' . $numbered_result_margin . 'px;">'; 
			echo '<a href="' . $like_row['post_url'] . '">' . $like_row['post_title'] . '</a>';
			if ( $instance['show_like_share_count'] ) {
				echo '&nbsp;&nbsp;&nbsp;(' . sprintf( _n( '1 like', '%s likes', $like_row['like_count'], 'local-like-and-share' ), Local_Like_And_Share_Misc::format_count_display( $like_row['like_count'] ) ) . ')';
			}
			echo '</li>';
		}
		echo '</ol>';		
	}
	else {

		// No likes found
		echo $no_likes_found_message;	
	}
	echo '</p>';
}

if ( $instance['show_share_section'] ) {
	echo '<p>';
	if ( ! empty ($instance['share_title'] )) {
		echo $args['before_title'] . $instance['share_title'] . $args['after_title'];
	}
	if ( count( $share_counts_arr ) ) {
	
		// At least 1 share found
		echo '<ol id="id_olLikeStats">';
		foreach ( $share_counts_arr as $share_row ) {
			
			// Use admin-defined margin for numbered results to account for a plethora of theme formats		
			echo '<li style="margin-left: ' . $numbered_result_margin . 'px;">'; 
			echo '<a href="' . $share_row['post_url'] . '">' . $share_row['post_title'] . '</a>';
			if ( $instance['show_like_share_count'] ) {
				echo '&nbsp;&nbsp;&nbsp;(' . sprintf( _n( '1 share', '%s shares', $share_row['share_count'], 'local-like-and-share' ),  Local_Like_And_Share_Misc::format_count_display( $share_row['share_count'] ) ) . ')';
			}
			echo '</li>';
		}
		echo '</ol>';
	}
	else {

		// No shares found
		echo $no_shares_found_message;	
	}
	echo '</p>';
}
?>			
