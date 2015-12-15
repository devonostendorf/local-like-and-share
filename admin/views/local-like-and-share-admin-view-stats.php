<?php

/**
 * View Statistics (accessible via Local Like And Share >> View Statistics on admin menu sidebar).
 *
 * This markup generates the View Statistics page.
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
			<div id="id_divActionMessage">
			</div>
			<div id="id_divResetCounts" style="display: none">
				<br />
				<input type="button" name="btnResetLikeCounts" id="id_btnResetLikeCounts" class="button delete" value="<?php esc_attr_e( 'Reset all like counts', 'local-like-and-share' ); ?>" />
				<input type="button" name="btnResetShareCounts" id="id_btnResetShareCounts" class="button delete" value="<?php esc_attr_e( 'Reset all share counts', 'local-like-and-share' ); ?>" />
				<br />
				<br />
			</div>
			<br />
			<div id="id_divTimePeriod">            
            	<a href="#" class="button-primary" rel="24-hours"><?php esc_html_e( 'Last 24 hours', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="7-days"><?php esc_html_e( 'Last 7 days', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="30-days"><?php esc_html_e( 'Last 30 days', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="all-time"><?php esc_html_e( 'All-time', 'local-like-and-share' ); ?></a>
        	</div>    
        	<div id="id_divAllStats">
<?php
echo $div_all_stats_contents;
?>
      		</div>
      	</div>
    </div>
