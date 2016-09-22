<?php

/**
 * Display plugin settings (accessible via Settings >> Local Like And Share on admin menu sidebar).
 *
 * This markup generates the plugin's settings page.
 *
 * @link		https://devonostendorf.com/projects/#local-like-and-share
 * @since		1.0.0
 *
 * @package		Local_Like_And_Share
 * @subpackage	Local_Like_And_Share/admin/views
 */
?> 
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<div id="post-body-content">
			<form method="post" action="options.php">
				<?php settings_fields( 'local_like_and_share_settings_group' ); ?>
				<?php $options = get_option( 'local_like_and_share_settings' ); ?>                              
				<h3 class="title"><?php esc_html_e( 'Common Settings', 'local-like-and-share' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Button(s) position on post:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[button_posn_vert]" id="button_posn_vert_top" value="top" <?php checked( $options['button_posn_vert'], 'top' ); ?> >
								<label for="button_posn_vert_top"><?php esc_html_e( 'Top', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[button_posn_vert]" id="button_posn_vert_bottom" value="bottom" <?php checked( $options['button_posn_vert'], 'bottom' ); ?> >
								<label for="button_posn_vert_bottom"><?php esc_html_e( 'Bottom', 'local-like-and-share' ); ?></label>
							</span>
							<p>
								<span class="block-element">
									<input type="radio" name="local_like_and_share_settings[button_posn_horiz]" id="button_posn_horiz_left" value="left" <?php checked( $options['button_posn_horiz'], 'left' ); ?> >
									<label for="button_posn_horiz_left"><?php esc_html_e( 'Left', 'local-like-and-share' ); ?></label>
									&nbsp;&nbsp;&nbsp;&nbsp;
								</span>
								<span class="block-element">
									<input type="radio" name="local_like_and_share_settings[button_posn_horiz]" id="button_posn_horiz_right" value="right" <?php checked( $options['button_posn_horiz'], 'right' ); ?> >
									<label for="button_posn_horiz_right"><?php esc_html_e( 'Right', 'local-like-and-share' ); ?></label>
								</span>
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="btn_hover_message_background_color"><?php esc_html_e( 'Button hover message background color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[btn_hover_message_background_color]" id="btn_hover_message_background_color" value="<?php echo esc_attr( $options['btn_hover_message_background_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="btn_hover_message_text_color"><?php esc_html_e( 'Button hover message text color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[btn_hover_message_text_color]" id="btn_hover_message_text_color" value="<?php echo esc_attr( $options['btn_hover_message_text_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="count_background_color"><?php esc_html_e( 'Count background color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[count_background_color]" id="count_background_color" value="<?php echo esc_attr( $options['count_background_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="count_outline_color"><?php esc_html_e( 'Count outline color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[count_outline_color]" id="count_outline_color" value="<?php echo esc_attr( $options['count_outline_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="count_text_color"><?php esc_html_e( 'Count text color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[count_text_color]" id="count_text_color" value="<?php echo esc_attr( $options['count_text_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Display abbreviations for large count values:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[abbrev_large_count_vals]" id="abbrev_large_count_vals_yes" value="yes" <?php checked( $options['abbrev_large_count_vals'], 'yes' ); ?> >
								<label for="abbrev_large_count_vals_yes"><?php esc_html_e( 'Yes', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[abbrev_large_count_vals]" id="abbrev_large_count_vals_no" value="no" <?php checked( $options['abbrev_large_count_vals'], 'no' ); ?> >
								<label for="abbrev_large_count_vals_no"><?php esc_html_e( 'No', 'local-like-and-share' ); ?></label>
							</span>
            				<br />
            				<p class="description">
            					<?php esc_html_e( '1001 and above become "1K+", 1000000 and above become "1M+", and 1000000000 and above become "1B+".', 'local-like-and-share' ); ?>
            				</p>
						</td>
					</tr>
            	</table>
				<h3 class="title"><?php esc_html_e( 'Like Settings', 'local-like-and-share' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Show on post index pages:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[like_show_on_post_index]" id="like_show_on_post_index_yes" value="yes" <?php checked( $options['like_show_on_post_index'], 'yes' ); ?> >
								<label for="like_show_on_post_index_yes"><?php esc_html_e( 'Yes', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[like_show_on_post_index]" id="like_show_on_post_index_no" value="no" <?php checked( $options['like_show_on_post_index'], 'no' ); ?> >
								<label for="like_show_on_post_index_no"><?php esc_html_e( 'No', 'local-like-and-share' ); ?></label>
							</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Show on individual post:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[like_show_on_single]" id="like_show_on_single_yes" value="yes" <?php checked( $options['like_show_on_single'], 'yes' ); ?> >
								<label for="like_show_on_single_yes"><?php esc_html_e( 'Yes', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[like_show_on_single]" id="like_show_on_single_no" value="no" <?php checked( $options['like_show_on_single'], 'no' ); ?> >
								<label for="like_show_on_single_no"><?php esc_html_e( 'No', 'local-like-and-share' ); ?></label>
							</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="like_btn_color"><?php esc_html_e( 'Button color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[like_btn_color]" id="like_btn_color" value="<?php echo esc_attr( $options['like_btn_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="like_btn_hover_color"><?php esc_html_e( 'Button hover color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[like_btn_hover_color]" id="like_btn_hover_color" value="<?php echo esc_attr( $options['like_btn_hover_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Button hover message (call to action):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[like_btn_hover_call_to_action]" id="like_btn_hover_call_to_action" value="<?php echo esc_attr( $options['like_btn_hover_call_to_action'] ); ?>">
            				<br />
            			</td>
            		</tr>
					<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Button hover message (successful like):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[like_btn_hover_success_message]" id="like_btn_hover_success_message" value="<?php echo esc_attr( $options['like_btn_hover_success_message'] ); ?>">
            				<br />
            			</td>
            		</tr>
					<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Button hover message (already liked):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[like_btn_hover_info_message_already_liked]" id="like_btn_hover_info_message_already_liked" value="<?php echo esc_attr( $options['like_btn_hover_info_message_already_liked'] ); ?>">
            				<br />
            			</td>
            		</tr>
            		<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Widget message (no likes found):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[widget_info_message_no_likes_found]" id="widget_info_message_no_likes_found" value="<?php echo esc_attr( $options['widget_info_message_no_likes_found'] ); ?>">
            				<br />
            			</td>
            		</tr>
            	</table>
            	<h3 class="title"><?php esc_html_e( 'Share Settings', 'local-like-and-share' ); ?></h3>
            	<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Show on post index pages:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[share_show_on_post_index]" id="share_show_on_post_index_yes" value="yes" <?php checked( $options['share_show_on_post_index'], 'yes' ); ?> >
								<label for="share_show_on_post_index_yes"><?php esc_html_e( 'Yes', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[share_show_on_post_index]" id="share_show_on_post_index_no" value="no" <?php checked( $options['share_show_on_post_index'], 'no' ); ?> >
								<label for="share_show_on_post_index_no"><?php esc_html_e( 'No', 'local-like-and-share' ); ?></label>
							</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Show on individual post?:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[share_show_on_single]" id="share_show_on_single_yes" value="yes" <?php checked( $options['share_show_on_single'], 'yes' ); ?> >
								<label for="share_show_on_single_yes"><?php esc_html_e( 'Yes', 'local-like-and-share' ); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
							</span>
							<span class="block-element">
								<input type="radio" name="local_like_and_share_settings[share_show_on_single]" id="share_show_on_single_no" value="no" <?php checked( $options['share_show_on_single'], 'no' ); ?> >
								<label for="share_show_on_single_no"><?php esc_html_e( 'No', 'local-like-and-share' ); ?></label>
							</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="share_btn_color"><?php esc_html_e( 'Button color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[share_btn_color]" id="share_btn_color" value="<?php echo esc_attr( $options['share_btn_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="share_btn_hover_color"><?php esc_html_e( 'Button hover color:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[share_btn_hover_color]" id="share_btn_hover_color" value="<?php echo esc_attr( $options['share_btn_hover_color'] ); ?>" class="color-picker">
						</td>
					</tr>
					<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Button hover message (call to action):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[share_btn_hover_call_to_action]" id="share_btn_hover_call_to_action" value="<?php echo esc_attr( $options['share_btn_hover_call_to_action'] ); ?>">
            				<br />
            			</td>
            		</tr>
            		<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Widget message (no shares found):', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="75" name="local_like_and_share_settings[widget_info_message_no_shares_found]" id="widget_info_message_no_shares_found" value="<?php echo esc_attr( $options['widget_info_message_no_shares_found'] ); ?>">
            				<br />
            			</td>
            		</tr>
					<tr valign="top">
						<th scope="row">
							<label for="share_eml_subj"><?php esc_html_e( 'Share post email subject:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<input type="text" size="75" name="local_like_and_share_settings[share_eml_subj]" id="share_eml_subj" value="<?php echo esc_attr( $options['share_eml_subj'] ); ?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php esc_html_e( 'Share post email body:', 'local-like-and-share' ); ?>
						</th>
						<td>
							<textarea name="local_like_and_share_settings[share_eml_body]" rows="10" cols="73" id="share_eml_body"><?php echo esc_html( $options['share_eml_body'] ); ?></textarea>
							<br />
						</td>
					</tr>
				</table> 
				<h3 class="title"><?php esc_html_e( 'Admin Menu Settings', 'local-like-and-share' ); ?></h3>
				<table class="form-table">
            		<tr valign="top">
            			<th scope="row">
            				<?php esc_html_e( 'Position in menu:', 'local-like-and-share' ); ?>
            			</th>
            			<td>
            				<input type="text" size="5" name="local_like_and_share_settings[admin_menu_position]" id="admin_menu_position" value="<?php echo esc_attr( $options['admin_menu_position'] ); ?>">
            				<br />
            				<p class="description">
            					<?php esc_html_e( 'If you cannot see the Local Like And Share admin menu, change this to another number of the form "3.xyz".', 'local-like-and-share' ); ?>
            				</p>
            			</td>
            		</tr>
            	</table> 
            	<?php submit_button() ?>
            </form>
        </div> <!-- end post-body-content -->
    </div>
