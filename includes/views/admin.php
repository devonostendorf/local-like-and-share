<?php

/**
 * Admin form for the widget (accessible on widget config page [Appearance >> Widgets on admin menu]).
 *
 * This markup generates the administration form of the widget.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/includes
 */
?>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_like_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_like_section' ) ); ?>" type="checkbox" value="1" <?php checked( $show_like_section ); ?> />
 		<label for="<?php echo esc_attr( $this->get_field_id( 'show_like_section' ) ); ?>"><?php _e( 'Show like section?', 'local-like-and-share' ); ?>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'like_title' ) ); ?>"><?php _e( 'Like Title:', 'local-like-and-share' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'like_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'like_title' ) ); ?>" type="text" value="<?php echo esc_attr( $like_title ); ?>" />
	</p>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_share_section' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_share_section' ) ); ?>" type="checkbox" value="1" <?php checked( $show_share_section ); ?> />
 		<label for="<?php echo esc_attr( $this->get_field_id( 'show_share_section' ) ); ?>"><?php _e( 'Show share section?', 'local-like-and-share' ); ?>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'share_title' ) ); ?>"><?php _e( 'Share Title:', 'local-like-and-share' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'share_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'share_title' ) ); ?>" type="text" value="<?php echo esc_attr( $share_title ); ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'time_period' ) ); ?>"><?php _e( 'Time Period:', 'local-like-and-share' ); ?></label>
		<select name="<?php echo esc_attr( $this->get_field_name( 'time_period' ) ); ?>">
			<option value="24-hours" <?php selected( $time_period, '24-hours' ); ?> >
				<?php _e( 'Last 24 hours', 'local-like-and-share' );?>
			</option>
			<option value="7-days" <?php selected( $time_period, '7-days' ); ?> >
				<?php _e( 'Last 7 days', 'local-like-and-share' );?>
			</option>
			<option value="30-days" <?php selected( $time_period, '30-days' ); ?> >
				<?php _e( 'Last 30 days', 'local-like-and-share' );?>
			</option>
			<option value="all-time" <?php selected( $time_period, 'all-time' ); ?> >
				<?php _e( 'All-time', 'local-like-and-share' );?>
			</option>
		</select>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts_to_show' ) ); ?>"><?php _e( 'Number of posts to show:', 'local-like-and-share' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts_to_show' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts_to_show' ) ); ?>" type="text" value="<?php echo esc_attr( $number_of_posts_to_show ); ?>" size="3" />
	</p>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_like_share_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_like_share_count' ) ); ?>" type="checkbox" value="1" <?php checked( $show_like_share_count ); ?> />
 		<label for="<?php echo esc_attr( $this->get_field_id( 'show_like_share_count' ) ); ?>"><?php _e( 'Show like/share counts?', 'local-like-and-share' ); ?>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'numbered_result_margin' ) ); ?>"><?php _e( 'Numbered result margin (pixels):', 'local-like-and-share' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'numbered_result_margin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'numbered_result_margin' ) ); ?>" type="text" value="<?php echo esc_attr( $numbered_result_margin ); ?>" size="3" />
	</p>	
