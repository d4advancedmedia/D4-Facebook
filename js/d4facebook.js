jQuery(document).ready(function($) {
	$('.fb-image').each(function() {
		var width = $(this).width();
		var height = $(this).height();
		if (width < height) {
			$(this).addClass('fb-portrait');
		}
	});	
});