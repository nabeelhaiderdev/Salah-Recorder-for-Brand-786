jQuery(document).ready(function (jQuery) {

	jQuery(".user-selection-button").on("click", function () {
		if (jQuery(this).data('clickid') == 'login') {
			jQuery("#login").css('display', 'block');
			jQuery("#register").css('display', 'none');
		} else if (jQuery(this).data('clickid') == 'register') {
			jQuery("#login").css('display', 'none');
			jQuery("#register").css('display', 'block');
		}
	});


});
