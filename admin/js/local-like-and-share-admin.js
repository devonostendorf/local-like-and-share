(function( $ ) {
	'use strict';
	
    $(function() {
    
    	// Add Color Picker to all inputs that have 'color-picker' class
        $('.color-picker').wpColorPicker();
    });
     
	$(function() {		
		$("#id_divTimePeriod a").click(function(e){
			var activeTab = $(this).attr("rel");

			// Update button classes based on which time period user has selected		
			$(this).removeClass("button-secondary").addClass("button-primary").siblings().removeClass("button-primary").addClass("button-secondary");

	 		$.post(llas_view_stats_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_view_stats_ajax_obj.nonce,
	 			action: "llas_view_stats",
	 			time_period: activeTab, 
	 		}, function(data) {

  				// Clear out any lingering action message
  				jQuery("#id_divActionMessage").removeClass("updated").removeClass("fade").html('');

  				// Enable/disable reset like counts button, as appropriate
  				if (data.resetLikeBtnDisabled == 'true') {
  					jQuery('#id_btnResetLikeCounts').prop('disabled', true);
  				}
				else {
  					jQuery('#id_btnResetLikeCounts').removeProp('disabled');
				}

  				// Enable/disable reset share counts button, as appropriate
  				if (data.resetShareBtnDisabled == 'true') {
  					jQuery('#id_btnResetShareCounts').prop('disabled', true);
  				}
				else {
  					jQuery('#id_btnResetShareCounts').removeProp('disabled');
				}
				
  				// Make reset counts buttons visible/invisible, as appropriate
  				jQuery("#id_divResetCounts").attr("style", data.showDelButtons);

  				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.allStatsContents);
  				
			});
		});
	});
	
	$(function() {
		$("#id_btnResetLikeCounts").click(function(e){
	 		$.post(llas_reset_like_counts_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_reset_like_counts_ajax_obj.nonce,
	 			action: "llas_reset_like_counts",
	 		}, function(data) {

  				// Display action performed message and undo link
  				jQuery("#id_divActionMessage").addClass("updated").addClass("fade").html(data.actionMessage);
  				
	 			// Disable reset like counts button
  				jQuery('#id_btnResetLikeCounts').prop('disabled', true);
	 			
				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.allStatsContents);
  				
			});
		});
	});

	$(function() {
		$("#id_btnResetShareCounts").click(function(e){
	 		$.post(llas_reset_share_counts_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_reset_share_counts_ajax_obj.nonce,
	 			action: "llas_reset_share_counts",
	 		}, function(data) {

 				// Display action performed message and undo link
   				jQuery("#id_divActionMessage").addClass("updated").addClass("fade").html(data.actionMessage);
  				
	 			// Disable reset share counts button
  				jQuery('#id_btnResetShareCounts').prop('disabled', true);

				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.allStatsContents);
  				
			});
		});
	});
	
	$(function() {
		$('#id_divActionMessage').on('click', '#id_pUndoLikeCountsReset a', function(e){		
			var lastUpdateDttm = $(this).attr("rel");
	 		$.post(llas_undo_reset_like_counts_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_undo_reset_like_counts_ajax_obj.nonce,
	 			action: "llas_undo_reset_like_counts",
	 			last_update_dttm: lastUpdateDttm, 
	 		}, function(data) {
			
 				// Display action performed message
  				jQuery("#id_divActionMessage").addClass("updated").addClass("fade").html(data.actionMessage);
  				
  				// Enable reset like counts button
	 			jQuery('#id_btnResetLikeCounts').removeProp('disabled');

				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.allStatsContents);
  				
			});
		});
	});
	
	$(function() {
		$('#id_divActionMessage').on('click', '#id_pUndoShareCountsReset a', function(e){		
			var lastUpdateDttm = $(this).attr("rel");
	 		$.post(llas_undo_reset_share_counts_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_undo_reset_share_counts_ajax_obj.nonce,
	 			action: "llas_undo_reset_share_counts",
	 			last_update_dttm: lastUpdateDttm, 
	 		}, function(data) {

 				// Display action performed message
  				jQuery("#id_divActionMessage").addClass("updated").addClass("fade").html(data.actionMessage);
  				
  				// Enable reset share counts button
	 			jQuery('#id_btnResetShareCounts').removeProp('disabled');

				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.allStatsContents);
  				
			});
		});
	});	
	
})( jQuery );
