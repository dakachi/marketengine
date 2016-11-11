(function($){
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
	$( "#me-pick-date-1" ).datepicker({
		dateFormat : 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			var date = new Date(selectedDate);
			date.setDate(date.getDate() + 1);
		    $( "#me-pick-date-2" ).datepicker( { minDate : date, dateFormat : 'yy-mm-dd' } );
		}
	});
});
})(jQuery);