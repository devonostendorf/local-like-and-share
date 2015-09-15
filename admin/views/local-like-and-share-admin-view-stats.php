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
		<div id="post-body-content">
      		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>     
			<br />
			<div id="id_divTimePeriod">            
            	<a href="#" class="button-primary" rel="24-hours"><?php _e( 'Last 24 hours', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="7-days"><?php _e( 'Last 7 days', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="30-days"><?php _e( 'Last 30 days', 'local-like-and-share' ); ?></a>
            	<a href="#" class="button-secondary" rel="all-time"><?php _e( 'All-time', 'local-like-and-share' ); ?></a>
        	</div>    
        	<div id="id_divAllStats">
<?php
echo $div_all_stats_contents;
?>
      		</div>
      	</div>
    </div>
