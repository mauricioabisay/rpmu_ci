var validEmail = /^[a-z0-9.-_]*[@]+[a-z]+[0-9-_]*[.]+[a-z.-_]+/;
var validString = /^[a-zA-Z]+[ á-úÁ-Úä-üÄ-Üà-ùÀ-ÙñÑ]*/;
var validInteger = /^[0-9]+$/;

var createFunctions = { 
	newResearcher: function() {
		jQuery('#new-researcher').css('display', 'block');
	},
	newParticipant: function() {
		jQuery('#new-participant').css('display', 'block');
	}
};
var saveResearcher = function() {
	var id = jQuery('#new-researcher-id').val();
	var name = jQuery('#new-researcher-name').val();
	var email = jQuery('#new-researcher-email').val();
	var faculty = jQuery('#new-researcher-faculty').val();
	
	jQuery('#new-researcher-id').removeClass('is-invalid');
	jQuery('#new-researcher-name').removeClass('is-invalid');
	jQuery('#new-researcher-email').removeClass('is-invalid');

	if (
		validInteger.test(id)
		&& validEmail.test(email) 
		&& validString.test(name)
	) {
		jQuery.ajax({
			type: "GET",
			url: url,
			data: {
				'string': id
			},
			success: function(data) {
				if ( !data.exists ) {
					var cloudItem = jQuery('<button class="btn btn-primary rpm-badge" type="button"><span>' + name + '</span>' + '<input type="hidden" name="new_researcher_id[]" value="' + id + '">' + '<input type="hidden" name="new_researcher_name[]" value="' + name + '">' + '<input type="hidden" name="new_researcher_email[]" value="' + email + '">' + '<input type="hidden" name="new_researcher_faculty[]" value="' + faculty + '">' + '</button>');
					jQuery('#researchers-cloud').append(cloudItem);
					cloudItem.bind('click', removeNewCloudElement);

					jQuery('#new-researcher-id').val('');
					jQuery('#new-researcher-name').val('');
					jQuery('#new-researcher-email').val('');

					jQuery('#new-researcher').css('display', 'none');
				} else {
					jQuery('#new-researcher-id').addClass('is-invalid');
					jQuery('#check-researcher-id-exists').css('display', 'block');
					jQuery('#check-researcher-id-input').css('display', 'none');
				}
			},
			error: function(error) {
				jQuery('#new-researcher-id').addClass('is-invalid');
				jQuery('#check-researcher-id-exists').css('display', 'block');
				jQuery('#check-researcher-id-input').css('display', 'none');
			},
			dataType: 'json'
		});
	} else {
		if ( !validInteger.test(id) ) {
			jQuery('#new-researcher-id').addClass('is-invalid');
			jQuery('#check-researcher-id-input').css('display', 'block');
			jQuery('#check-researcher-id-exists').css('display', 'none');
		}
		if ( !validEmail.test(email) ) {
			jQuery('#new-researcher-email').addClass('is-invalid');
		}
		if ( !validString.test(name) ) {
			jQuery('#new-researcher-name').addClass('is-invalid');
		}
	}
};
var saveParticipant = function() {
	var id = jQuery('#new-participant-id').val();
	var name = jQuery('#new-participant-name').val();
	var degree = jQuery('#new-participant-degree').val();

	jQuery('#new-participant-id').removeClass('is-invalid');
	jQuery('#new-participant-name').removeClass('is-invalid');

	if (
		validInteger.test(id)
		|| validString.test(name)
		) {
			jQuery.ajax({
				type: "GET",
				url: url,
				data: {
					'string': id
				},
				success: function(data) {
					if ( !data.exists ) {
						var cloudItem = jQuery('<button class="btn btn-primary rpm-badge" type="button"><span>' + name + '</span>' + '<input type="hidden" name="new_participant_id[]" value="' + id + '">' + '<input type="hidden" name="new_participant_name[]" value="' + name + '">' + '<input type="hidden" name="new_participant_degree[]" value="' + degree + '">' + '</button>');
						jQuery('#participants-cloud').append(cloudItem);
						cloudItem.bind('click', removeNewCloudElement);

						jQuery('#new-participant-id').val('');
						jQuery('#new-participant-name').val('');

						jQuery('#new-participant').css('display', 'none');
					} else {
						jQuery('#new-participant-id').addClass('is-invalid');
						jQuery('#check-participant-id-exists').css('display', 'block');
						jQuery('#check-participant-id-input').css('display', 'none');
					}
				},
				error: function(error) {
					jQuery('#new-participant-id').addClass('is-invalid');
					jQuery('#check-participant-id-exists').css('display', 'block');
					jQuery('#check-participant-id-input').css('display', 'none');
				},
				dataType: 'json'
			});
	} else {
		if ( !validInteger.test(id) ) {
			jQuery('#new-participant-id').addClass('is-invalid');
			jQuery('#check-participant-id-input').css('display', 'block');
			jQuery('#check-participant-id-exists').css('display', 'none');
		}
		if ( !validString.test(name) ) {
			jQuery('#new-participant-name').addClass('is-invalid');
		}
	}
};