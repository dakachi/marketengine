/* global me_globals.ajaxurl, wpAjax*/
(function($) {
	$('.me-list-thumbs').meSliderThumbs();
	var magnificInstance = true;
	var magnificItem = 0;
	$('.me-large-fancybox').on('click', function(event) {
		magnificInstance = true;
		$('.me-fancybox').magnificPopup({
		 	type: 'image',
		 	gallery: {
		      enabled: true
		    },
		    disableOn: function() {
		    	return magnificInstance;
		    }
		}).magnificPopup('open', magnificItem);
	});
	$('.me-fancybox').on('click', function(ev) {
		ev.preventDefault();
		var target = ev.currentTarget;
		var medium_img = $(target).attr('medium-img');  
		$('.me-large-fancybox').find('img').attr('src', medium_img);
		magnificItem = $(target).parent('li').index();
		magnificInstance = false;
	});

})(jQuery);
