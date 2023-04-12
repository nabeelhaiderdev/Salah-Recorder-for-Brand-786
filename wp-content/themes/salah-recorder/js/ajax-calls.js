jQuery(document).ready(function (jQuery) {

	// Resource Ajax Function -> Start
	jQuery(document).on('click', '.salah-click-element-button', function () {
		let this_element_status = '';
		let board = '';

		this_element_status = parseInt(jQuery(this).attr('data-toggle'));
		console.log(this_element_status);
		this_element_position = jQuery(this).data('position');

		jQuery('.lds-roller').show();

		jQuery.ajax({
			url: localVars.ajax_url,
			type: 'post',
			dataType: 'json',
			data: {
				action: 'salah_ajax_function',
				items: [this_element_status, this_element_position],
			},
			success: function (response) {
				console.log(response);
				if (response['new_current_status'] == true) {
					response_toggle = 1;
				} else {
					response_toggle = 0;
				}
				jQuery(".salah-click-element-button[data-position='" + response['element_position'] + "']").attr('data-toggle', response_toggle);
				console.log(response['new_current_status']);
				// jQuery(".salah-click-element-button[data-position='" + response['element_position'] + "']").attr('data-toggle', response['element_status']);
				jQuery('.lds-roller').hide();
			},
			error: function (xhr, status, error) {
				console.log("AJAX error: " + error);
			}
		});

	});

});
