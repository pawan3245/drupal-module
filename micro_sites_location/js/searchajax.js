(function($) {
	Drupal.behaviors.resetButton = {attach:function(context, settings) {
											$('#resetform').remove();
											var resetbuttonHtml = '<input type="button" value="RESET FILTER" id="resetform" name="resetformbutton" class="form-submit ajax-processed" onclick="rsetformvalue();">';
											$('#rides-filter-option-form  #edit-submit').after(resetbuttonHtml);
										}
									};
	
	$.fn.scrollpage = function() {
			$('#location_domain').val('');
			 $('html, body').animate({
					scrollTop: jQuery("#microsites_ridestop").offset().top
				}, 1000);
	};
	
	
	
	
})(jQuery);


function rsetformvalue (){
	//rides-filter-option-form
	
	jQuery('#rides-filter-option-form')[0].reset();
		//console.log('pawan');
}
