(function($){
$(document).ready(function() {
	/*$('.me-nav > li').on('click', function(ev) {
		var target = ev.currentTarget;
		$(target).parent('.me-nav').children('li').removeClass('active');
		$(target).addClass('active');
		var pos = $(target).index();
		var parent = $(target).parent('.me-nav');
		$(parent).next().children('div').hide()
		$(parent).next().children('div').eq(pos).show();
	});
	*/
	$('.me-scroll-language').mCustomScrollbar({
		setHeight:340
	});
	$( "#me-pick-date-1" ).datepicker({
		dateFormat : 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			var date = new Date(selectedDate);
		    $( "#me-pick-date-2" ).datepicker( { minDate : date, dateFormat : 'yy-mm-dd' } );
		}
	});

	//=== Custom Field
	//
	$('.me-cf-show').on('click', function(event) {
		event.preventDefault();
		var target = event.currentTarget;
		$('.me-cf-item').not($(target).parents('.me-cf-item')).removeClass('active');
		$(target).parents('.me-cf-item').toggleClass('active');
	});

	$('.me-cf-show, .me-cf-edit, .me-cf-remove').each(function(index, el) {
		var _this = this;
		$(this).tooltip({
			position: {
				my: "center bottom-10",
				at: "center top",
				of: _this,
				using: function( position, feedback ) {
					$( "<div>" )
					.addClass( "arrow" )
					.appendTo( this );
					$( _this ).append( this );
				}
			}
		});
	});

	$('#me-cf-by-category').sortable({
		revert: true,
		placeholder: "me-sortable-highlight"
    });

    $('#me-choose-field-type').on('change', function(event) {
    	var target = event.currentTarget;
    	var field_type = $(target).val();

    	var data = {
    		action: 'me_cf_load_input_type',
    		field_type: field_type,
    	};

    	$.post( me_globals.ajaxurl, data, function(res) {
			$('.me-field-type-options').html(res.options);
		});
    });

    $.validator.addMethod("regx", function(value, element, params) {
		var regx = params.value;

        return value.match(regx);
    }, 'Field name only lowercase letters (a-z, -, _) and numbers are allowed.');
    $.validator.addMethod("meMax", function(value, element) {
    	if($('#field_maximum_value').val() != '') {
    		return parseFloat(value) < parseFloat($('#field_maximum_value').val());
    	}
    	return true;
    }, 'Please enter a value less than maximum value.');
    $.validator.addMethod("meMin", function(value, element) {
    	if($('#field_minimum_value').val() != '') {
    		return parseFloat(value) > parseFloat($('#field_minimum_value').val());
    	}
    	return true;
    }, 'Please enter a value greater than minimum value.');


    $('#me-custom-field-form').validate({
	    errorElement: 'i',
	    wrapper: "div",
	    errorClass: 'icon-me-warning me-field-required',
	    rules: {
	    	field_name: {
	    		required: true,
	    		regx: {
	    			name: 'field_name',
	    			value: /^[a-z0-9\_\-]+$/,
	    		},
	    		remote: {
			        url: me_globals.ajaxurl,
			        type: "POST",
			        cache: false,
			        dataType: "json",
			        data: {
			    		action: 'check_field_name',
			    		field_name: function() {
			    			return $('#me-cf-field-name').val();
			    		},
			    		current_field_id: function() {
			    			return $('#me-cf-current-field-id').val();
			    		},
			    	},
			    	dataFilter: function(res) {
			    		if($('#me-cf-current-field-id').val() == -1 && $('#me-cf-field-name').data('old-field-name') == $('#me-cf-field-name').val()) {
			    			return true;
			    		}
			    		res = JSON.parse(res);
			    		$.validator.messages.remote = res.message;
			    		return res.unique;
			    	},
			    },
	    	},
	    	field_title: {
	    		required: true,
	    		normalizer: function( value ) {
			        return $.trim( value );
			    },
	    	},
	    	field_minimum_value: {
	    		meMax: true,
	    	},
	    	field_maximum_value: {
	    		meMin: true,
	    	},
	    	field_options: {
	    		required: true,
	    		normalizer: function( value ) {
			        return $.trim( value );
			    },
	    	}
	    }
    });

    $('.me-cf-remove').on('click', function(e) {
    	var count = $(this).data('count');
    	var cfm;

    	if(typeof count == 'undefined' || count == 1) {
    		cfm = confirm('Are you sure you want to delete the selected custom field?')
    	} else {
    		cfm = confirm('Are you sure you want to remove the selected field from this category?')
    	}

	    if (cfm == false) {
	    	e.preventDefault();
	    }
    });

    // $('#me-choose-field-type').trigger('change');

    // $('#me-choose-field-type').on('change', function(event) {
    // 	var target = event.currentTarget;
    // 	var field_type = $(target).val();
    // 	var options = '';
    // 	switch(field_type) {
    // 		case 'text':
    // 		case 'textarea':
    // 			options += 	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Placeholder <small>(optional)</small></label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="text" name="field_placeholder">';
				// options +=	'</span>';
				// options	+=	'</div>';
    // 			break;

    // 		case 'number':
    // 			options += 	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Placeholder <small>(optional)</small></label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="text">';
				// options +=	'</span>';
				// options +=	'</div>';
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Minimum value <small>(optional)</small></label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="number">';
				// options +=	'</span>';
				// options +=	'</div>';
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Maximum value <small>(optional)</small></label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="number">';
				// options +=	'</span>';
				// options +=	'</div>';
    // 			break;
    // 		case 'date':
    // 			break;

    // 		case 'checkbox':
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Options</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>';
				// options +=	'</span>';
				// options +=	'</div>';
    // 			break;

    // 		case 'radio':
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Options</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>';
				// options +=	'</span>';
				// options +=	'</div>';
    // 			break;

    // 		case 'single-select':
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Option none</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="text">';
				// options +=	'</span>';
				// options +=	'</div>';
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Options</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>';
				// options +=	'</span>';
				// options +=	'</div>';
    // 			break;

    // 		case 'multi-select':
    // 			options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Option none</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<input class="me-input-field" type="text">';
				// options +=	'</span>';
				// options +=	'</div>';
				// options +=	'<div class="me-group-field">';
				// options +=	'<label class="me-title">Options</label>';
				// options +=	'<span class="me-field-control">';
				// options +=	'<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>';
				// options +=	'</span>';
				// options +=	'</div>';
    // 			break;

    // 		default:
    // 			break;
    // 	}

    // 	$('.me-field-type-options').html(options);

    // });
});
})(jQuery);