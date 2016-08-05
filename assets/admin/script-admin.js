(function($){
$(document).ready(function() {
	$('.me-tabs > li').on('click', function(ev) {
		var target = ev.currentTarget;
		$(target).parent('.me-tabs').children('li').removeClass('active');
		$(target).addClass('active');
		var pos = $(target).index();
		var parent = $(target).parent('.me-tabs');
		$(parent).next().children('div').hide()
		$(parent).next().children('div').eq(pos).show();
	});
	$('.me-scroll-language').mCustomScrollbar({
		setHeight:340
	});
});
})(jQuery);