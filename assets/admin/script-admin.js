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
		onSelect: function( selectedDate ) {
			$( "#me-pick-date-2" ).datepicker();
		    $( "#me-pick-date-2" ).datepicker("option", "minDate", selectedDate );
		    setTimeout(function(){
	            $( "#me-pick-date-2" ).datepicker('show');
	        }, 16);
		}
	});
});
})(jQuery);