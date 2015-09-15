(function( $ ) {
	'use strict';
	
    $(function() {
    
    	// Add Color Picker to all inputs that have 'color-picker' class
        $('.color-picker').wpColorPicker();
    });
     
	$(function() {
		
		// Update button classes based on what user has selected		
		$("#id_divTimePeriod a").click(function(e){
			var activeTab = $(this).attr("rel");
			$(this).removeClass("button-secondary").addClass("button-primary").siblings().removeClass("button-primary").addClass("button-secondary");

	 		$.post(llas_view_stats_ajax_obj.ajax_url, {
	 			_ajax_nonce: llas_view_stats_ajax_obj.nonce,
	 			action: "llas_view_stats",
	 			time_period: activeTab, 
	 		}, function(data) {

				// Refresh div with contents updated based on selected time period			
  				jQuery("#id_divAllStats").html(data.div_message);
			});
		});
	});
})( jQuery );
