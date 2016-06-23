/* global me_globals.ajaxurl, wpAjax*/
(function($) {
	$('.me-list-thumbs').meSliderThumbs();
	var magnificInstance = true;
	var magnificItem = 0;
	
	$('.me-fancybox').on('click', function(ev) {
		ev.preventDefault();
		var target = ev.currentTarget;
		var medium_img = $(target).attr('medium-img');  
		$('.me-large-fancybox').find('img').attr('src', medium_img);
		magnificItem = $(target).parent('li').index();
		magnificInstance = false;
	});
})(jQuery);
