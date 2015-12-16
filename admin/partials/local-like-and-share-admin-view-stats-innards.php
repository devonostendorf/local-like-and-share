<?php

/**
 * Contents of View Statistics.
 *
 * This markup generates the innards of the View Statistics page.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/admin/partials
 */
?>
			<h3 class="title"><?php esc_html_e( 'Most Liked', 'local-like-and-share' ); ?></h3>
<?php
if ( count( $like_counts_arr ) ) {

	// At least 1 like found
	echo '<ol id="id_olLikeStats">';
	foreach ( $like_counts_arr as $like_row ) {
		echo '<li>'; 
		echo '<a href="' . esc_url( $like_row['post_url'] ) . '" target="_blank">' . esc_html( $like_row['post_title'] ) . '</a>&nbsp;&nbsp;&nbsp;(' . sprintf( _n( '1 like', '%s likes', $like_row['like_count'], 'local-like-and-share' ), number_format_i18n( $like_row['like_count'] ) ) . ')';
		echo '</li>';
	}
	echo '</ol>';
}
else {

	// No likes found
	esc_html_e( 'No like data found for the selected time period.', 'local-like-and-share' );	
}
?>			
			<h3 class="title"><?php esc_html_e( 'Most Shared', 'local-like-and-share' ); ?></h3>
<?php
if ( count( $share_counts_arr ) ) {
	
	// At least 1 share found
	echo '<ol id="id_olShareStats">';
	foreach ( $share_counts_arr as $share_row ) {
		echo '<li>'; 
		echo '<a href="' . esc_url( $share_row['post_url'] ) . '" target="_blank">' . esc_html( $share_row['post_title'] ) . '</a>&nbsp;&nbsp;&nbsp;(' . sprintf( _n( '1 share', '%s shares', $share_row['share_count'], 'local-like-and-share' ), number_format_i18n( $share_row['share_count'] ) ) . ')';
		echo '</li>';
	}
	echo '</ol>';
}
else {

	// No shares found
	esc_html_e( 'No share data found for the selected time period.', 'local-like-and-share' );	
}
?>
