$(document).ready(function() {
	$('.me-nav > li').on('click', function(ev) {
		var target = ev.currentTarget;
		$(target).parent('.me-nav').children('li').removeClass('active');
		$(target).addClass('active');
		var pos = $(target).index();
		var parent = $(target).parent('.me-nav');
		$(parent).next().children('div').hide()
		$(parent).next().children('div').eq(pos).show();
	});
	$('.me-scroll-language').mCustomScrollbar({
		setHeight:340
	});

	$('.me-chosen-select').chosen({
		disable_search: true
	});

	$( "#me-pick-date-1" ).datepicker({ 
		onSelect: function( selectedDate ) {
			$( "#me-pick-date-2" ).datepicker();
		    $( "#me-pick-date-2" ).datepicker("option", "minDate", selectedDate );
		    setTimeout(function(){
	            $( "#me-pick-date-2" ).datepicker('show');
	        }, 16);
		}
	});

	//=== Click continue button
	$('.me-scontinue-btn').on('click', function(event) {
		event.preventDefault();
		var target = event.currentTarget;
		var parent_section = $(target).parents('.me-setup-section');
		var parent_container = $(target).parents('.me-setup-container');
		var data_step = $(parent_container).data('step');
		var data_next = data_step + 1;

		// activity
		$(parent_section).addClass('me-setup-section-loading');
		setTimeout(function() {
			$(parent_section).removeClass('me-setup-section-loading');
			$(parent_container).removeClass('active');
			$('.me-setup-container').eq(data_next).addClass('active');
			$('.me-setup-line-step').eq(data_next).addClass('active');
		}, 3333);
	});

	//=== Click previous button
	$('.me-sprevious-btn').on('click', function(event) {
		event.preventDefault();
		var target = event.currentTarget;
		var parent_container = $(target).parents('.me-setup-container');
		var data_step = $(parent_container).data('step');
		var data_prev = data_step - 1;

		//activity
		$(parent_container).removeClass('active');
		$('.me-setup-container').eq(data_prev).addClass('active');
		$('.me-setup-line-step').eq(data_step).removeClass('active');

	});

	$('.me-setup-add-cat').on('click', function(event) {
		var parent_sfield = $(this).parent();
		$(parent_sfield).append('<input type="text" /> <input type="text" /><small>More categories can be added later in MarketEngine settings</small>')
		$(this).hide();
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
});