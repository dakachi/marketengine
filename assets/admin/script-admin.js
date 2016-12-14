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
		$(this).me_tooltip();
	});
	$('.me-cf-show, .me-cf-edit, .me-cf-remove').tooltip({
		position: {
			my: "center bottom-10",
			at: "center top",
			using: function( position, feedback ) {
				$( this ).css( position );
				$( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		}
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

    $.validator.addMethod("regx", function(value, element) {
    	var regx = /^[a-z0-9\_\-]+$/;

        return value.match(regx);
    }, 'Field name only lowercase letters (a-z, -, _) and numbers are allowed.');

    $('#me-custom-field-form').validate({
	    errorElement: 'i',
	    wrapper: "div",
	    errorClass: 'icon-me-warning me-field-required',
	    rules: {
	    	field_name: {
	    		required: true,
	    		regx: true,
	    	}
	    },
	    highlight: function(element, errorClass) {
	    	$(element).removeClass(errorClass)
	    }
    });

    $('.me-cf-remove').on('click', function(e) {

    	var cfm = confirm('Are you sure you want to delete the selected custom field?');

	    if (cfm == false) {
	    	e.preventDefault();
	    }
    })

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