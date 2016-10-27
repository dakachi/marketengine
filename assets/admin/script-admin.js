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

	
});
})(jQuery);