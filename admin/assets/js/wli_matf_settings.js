jQuery(document).ready(function()
{
	var parent = jQuery('body');
	
	if (jQuery('body').hasClass('settings_page_multi-account-tweet-feeds-menu')){
		parent = jQuery('.matf_wrap');
	}
	
	jQuery(document).ready(function($) {
		parent.find('.matweetfeeds-color-picker').wpColorPicker();
	});

	jQuery(document).on('widget-added', function(e, widget){
		widget.find('.matweetfeeds-color-picker').wpColorPicker();
	});

	jQuery(document).on('widget-updated', function(e, widget){
		widget.find('.matweetfeeds-color-picker').wpColorPicker();
	});
});