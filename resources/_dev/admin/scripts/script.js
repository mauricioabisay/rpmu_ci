jQuery('.rpm-api-search-slug').on('input', function () {
	
	var input = jQuery(this);
	var valueHolder = jQuery( '#' + input.attr('rpm-api-input') );
	var list = jQuery( '#' + input.attr('rpm-api-list') );
	var resultId = input.attr('rpm-api-result-id');
	var resultHuman = input.attr('rpm-api-result-human');

	list.children().unbind();
	list.html('');
	
	jQuery.ajax({
		type: "GET",
		url: jQuery(this).attr('rpm-api'),
		data: {
			'string': jQuery(this).val()
		},
		success: function(data) {
			list.css('display', 'block');
			data.forEach(function (e) {
				var aux = jQuery('<li>' + e[resultHuman] + '</li>');
				list.append(aux);
				aux.bind('click', function() {
					input.val(e[resultHuman]);
					valueHolder.val(e[resultId]);
					list.css('display', 'none');
				});
			});
		},
		dataType: 'json'
	});
});

var removeCloudElement = function() {
	var me = jQuery(this);
	me.parent().append(jQuery('<input type="hidden" name="' + me.attr('rpm-delete') +'" value="'+ me.attr('rpm-input') +'" >'));
	me.remove();
	jQuery( '#' + me.attr('rpm-input') ).remove();
};

var removeNewCloudElement = function () {
	jQuery(this).remove();
};

jQuery('.rpm-api-search-slug-cloud').on('input', function () {
	var input = jQuery(this);
	var list = jQuery( '#' + input.attr('rpm-api-list') );
	var resultId = input.attr('rpm-api-result-id');
	var resultHuman = input.attr('rpm-api-result-human');
	var cloud = jQuery( '#' + input.attr('rpm-api-cloud') );

	list.children().unbind();
	list.html('');
	
	var currentValue = jQuery(this).val();
	var currentData = '';
	jQuery("input[name='" + input.attr('rpm-api-input') + "[]']").each(function(index, value) {
		currentData += value.value + ',';
	});

	jQuery.ajax({
		type: "GET",
		url: jQuery(this).attr('rpm-api'),
		data: {
			'string': currentValue,
			'current': currentData
		},
		success: function(data) {
			list.css('display', 'block');
			if ( data .length <= 0 ) {
				if ( input.attr('rpm-api-create') === undefined || input.attr('rpm-api-create') === false ) {
					var aux = jQuery('<li>No se han encontrado coincidencias, click para finalizar búsqueda.</li>');
					list.append(aux);
					aux.bind('click', function() {
						list.css('display', 'none');
						input.val('');
					}); 
				} else {
					var currentValueAsSlug = slugify(currentValue);
					var flagSlug = false;
					jQuery("input[name='" + input.attr('rpm-api-input') + "[]']").each(function(index, value) {
						if ( !flagSlug && value.value === currentValueAsSlug ) {
							flagSlug = true;
						}
					});
					if ( flagSlug ) {
						var aux = jQuery('<li>Registro pre-existente, click para finalizar búsqueda.</li>');
						list.append(aux);
						aux.bind('click', function() {
							list.css('display', 'none');
							input.val('');
						});
					} else {
						var aux = jQuery('<li>Click para agregar nuevo registro, <b>' + input.val() + '</b></li>');
						list.append(aux);
						if ( input.attr('rpm-api-create-function') === undefined ) {
							aux.bind('click', function() {
								list.css('display', 'none');
								var cloudItem = jQuery('<button class="btn btn-primary rpm-badge" type="button"><span>' + input.val() + '</span>' + '<input type="hidden" name="' + input.attr('rpm-api-create-input') +'[]" value="' + input.val() + '">' + '</button>');
								cloud.append(cloudItem);
								cloudItem.bind('click', removeNewCloudElement);
								input.val('');
							});
						} else {
							aux.bind( 'click', createFunctions[input.attr('rpm-api-create-function')] );
						}
					}
					
				}
			} else {
				data.forEach(function (e) {
					var aux = jQuery('<li>'+e[resultHuman]+'</li>');
					list.append(aux);
					aux.bind('click', function() {
						list.css('display', 'none');
						input.val('');
						var cloudItem = jQuery('<button class="btn btn-primary rpm-badge" type="button" rpm-input="' + e[resultId] + '" rpm-delete="' + input.attr('rpm-api-input') + '_delete[]"><span>' + e[resultHuman] + '</span></button>');
						var cloudInput = jQuery('<input type="hidden" name="' + input.attr('rpm-api-input') +'[]" id="' + e[resultId] + '" value="' + e[resultId] + '">');
						cloud.append(cloudItem);
						cloud.append(cloudInput);
						cloudItem.bind('click', removeCloudElement);
					});
				});
			}
		},
		error: function(error) {
			console.error(error);
		},
		dataType: 'json'
	});
});

jQuery('.rpm-api-cloud').children('.rpm-badge').bind('click', removeCloudElement);

var removeListElement = function() {
	var item = jQuery(this).parents('.rpm-dynamic-list-item');
	item.css('display', 'none');
	item.children('.delete').val(1);
};

var addListElement = function() {
	var item = jQuery(this).parents('.rpm-dynamic-list-item');
	var itemContainer = item.parent();
	var clon = item.clone(true);

	clon.find('input[type=text]').val('');
	clon.find('input[type=radio]').prop('checked', false);
	clon.find('input[type=checkbox]').prop('checked', false);
	clon.find('textarea').val('');
	clon.find('.delete').val(-1);
	clon.find('.id').val(-1);

	clon.find('.rpm-citation-link').css('display', 'none');
	clon.find('.rpm-citation-file').css('display', 'none');

	itemContainer.append(clon);

	jQuery(this).unbind();
	jQuery(this).val('-');
	jQuery(this).bind('click', removeListElement)
};

jQuery('.plus').bind('click', addListElement);
jQuery('.minus').bind('click', removeListElement);

jQuery('.single-file').change(function () {
	if ( this.files && this.files[0] ) {
		var reader = new FileReader();
		var thumb = jQuery(this).parent().find('.thumb');
		var img = jQuery(this).parent().find('.thumb-featured-image');
		reader.onload = function(e) {
			thumb.css('background', 'url(' + e.target.result + ')' );
			img.attr('src', e.target.result);
		};
		reader.readAsDataURL(this.files[0]);
	}
});

var addFile = function () {
	if ( this.files && this.files[0] ) {
		var reader = new FileReader();
		var prefix = jQuery(this).attr('rpm-prefix');

		var gallery = jQuery(this).parents('.rpm-multi-file-container').find('.multi-file-gallery');

		var newInput = jQuery('<input type="file" class="form-control-file multi-file" name="gallery[]" ariadescribedby="gallery-help" rpm-prefix="gallery" multiple>');
		newInput.change(addFile);
		jQuery(this).parent().append(newInput);
		jQuery(this).css('display', 'none');

		reader.onload = function(e) {
			gallery.append(
				'<div class="col-3 rpm-multi-file-thumb">'+
				'<div class="rpm-multi-file-thumb-delete">X</div>'+
				'<img src="' + e.target.result + '">'+
				'<input type="hidden" class="delete" name="'+prefix+'_delete[]" value="-1">'+
				'</div>'
			);
			jQuery('.rpm-multi-file-thumb-delete').click(removeFile);
		};
		reader.readAsDataURL(this.files[0]);	
	}
};

var removeFile = function () {
	jQuery(this).parent().css('display', 'none');
	jQuery(this).parent().find('.delete').val(1);
};

jQuery('.multi-file').change(addFile);
jQuery('.rpm-multi-file-thumb-delete').click(removeFile);

var linkOrFile = function() {
	var me = jQuery(this);
	var parent = me.parents('.rpm-dynamic-list-item');
	switch( me.val() ) {
		case 'link': {
			parent.find('.rpm-citation-link').css('display', 'inline-block');
			parent.find('.rpm-citation-file').css('display', 'none');
			console.log('hidde file');
			break;
		}
		case 'file': {
			parent.find('.rpm-citation-file').css('display', 'inline-block');
			parent.find('.rpm-citation-link').css('display', 'none');
			console.log('hidde link');
			break;
		}
	}
};

jQuery('select[name="citation_type[]"]').change(linkOrFile);