jQuery(document).ready(function($) {

	/*$('#terms-service').on('click', function() {
		if($(this).is(':checked')) {
			$('.submit-signup').find('input').removeClass('disable');
		} else {
			$('.submit-signup').find('input').addClass('disable');
		}
	});*/

	/*$('.marketengine-continue-btn, .me-forward-section').on('click', function(ev) {
		ev.preventDefault();
		var target = ev.currentTarget;
		var data_active = $(target).attr('data-active');
		$('.marketengine-post-step').removeClass('active');
		$('#marketengine-post-step-'+data_active).addClass('active');
		$('.me-post-step').removeClass('active');
		for (var i = 1; i <= data_active; i++) {
			$('.me-post-step-'+i).addClass('active');
		}
	});*/

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

	$('.me-related-slider').flexslider({
		slideshow: false,
		animation: "slide",
		animationLoop: false,
		itemWidth: 248,
		itemMargin: 30,
		controlNav: false,
		directionNav: true,
		prevText: '',
		nextText: ''
	});

	/**
	 * Hover category show/hide
	 */
	$('.me-has-category > li').hover(
		function() {
			$('body').addClass('marketengine-categories');
		},
		function() {
			$('body').removeClass('marketengine-categories');
		}
	);

	$('.me-overlay').hover(
		function() {
			$('body').removeClass('marketengine-categories');
		},
		function() {
			
		}
	);

	/**
	 * [description ME tabs]
	 */
	$('.me-tabs > li').on('click', function(ev) {
		var target = ev.currentTarget;
		$(target).parent('.me-tabs').children('li').removeClass('active');
		$(target).addClass('active');
		var pos = $(target).index();
		var parent = $(target).parent('.me-tabs');
		$(parent).next().children('div').hide()
		$(parent).next().children('div').eq(pos).show();
	});

	/**
	 * Show/Hide menu page tablet/mobile
	 */
	$('.me-page-humberger').on('click', function() {
		$('.marketengine-header-bottom').removeClass('me-account-active');
		$('.me-account-humberger').removeClass('active');
		$(this).toggleClass('active');
		$('.marketengine-header-bottom').toggleClass('me-page-active');

	});

	/**
	 * Show/Hide menu account mobile
	 */
	$('.me-account-humberger').on('click', function() {
		$('.marketengine-header-bottom').removeClass('me-page-active');
		$('.me-page-humberger').removeClass('active');
		$(this).toggleClass('active');
		$('.marketengine-header-bottom').toggleClass('me-account-active');
	});

	/**
	 * Contact tabs on mobile
	 */
	$('.me-contact-listing-tabs').on('click', function(ev) {
		$(this).toggleClass('active');
		$('body').toggleClass('me-contact-listing-tabs-active').removeClass('me-contact-user-tabs-active');
		return false;
	});

	$('.me-contact-user-tabs').on('click', function(ev) {
		$(this).toggleClass('active');
		$('body').toggleClass('me-contact-user-tabs-active').removeClass('me-contact-listing-tabs-active');
		return false;
	});



	/**
	 * Scroll messages inbox
	 */
	/*var width_window = $(window).width();
	var height_window = $(window).height();
	var height_header_top = $('#me-header-wrapper').innerHeight();
	var height_contact_header = $('.me-contact-header').innerHeight();
	var height_message_typing = $('.me-message-typing').innerHeight();
	var height_Scrollbar = height_window - height_header_top - height_message_typing - height_contact_header - 3;*/
	
	// if(width_window <= 767) {
	// 	$('.me-contact-messages').mCustomScrollbar({
	// 		setTop:"-1000000px",
	// 		setHeight: height_Scrollbar
	// 	});
	// 	$('.me-contact-user-wrap').mCustomScrollbar({
	// 		setHeight: height_Scrollbar
	// 	});

	// } else {
	// 	$('.me-contact-messages').mCustomScrollbar({
	// 		setTop:"-1000000px",
	// 		setHeight:500
	// 	});

	// 	$('.me-contact-user-wrap').mCustomScrollbar({
	// 		setHeight:536
	// 	});
	// }
	/**
	 * -----------------------------------------------------------------------------------
	 * Order
	 * -----------------------------------------------------------------------------------
	 */
	$( "#me-inquiries-pick-date-1" ).datepicker({
		onSelect: function( selectedDate ) {
			$( "#me-inquiries-pick-date-2" ).datepicker();
		    $( "#me-inquiries-pick-date-2" ).datepicker("option", "minDate", selectedDate );
		    setTimeout(function(){
	            $( "#me-inquiries-pick-date-2" ).datepicker('show');
	        }, 16);
		}
	});

	$( "#me-order-pick-date-1" ).datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			$( "#me-order-pick-date-2" ).datepicker({dateFormat: 'yy-mm-dd'});
		    $( "#me-order-pick-date-2" ).datepicker("option", "minDate", selectedDate );
		    setTimeout(function(){
	            $( "#me-order-pick-date-2" ).datepicker('show');
	        }, 16);
		}
	});

	$('.me-orderlist-filter-tabs span').on('click', function() {
		$(this).parents('.me-tabs-section').toggleClass('me-order-filter-active');
	});

	$('.me-inquiries-filter-tabs span').on('click', function() {
		$(this).parents('.me-tabs-section').toggleClass('me-inquiries-filter-active');
	});

	/**
	 * -----------------------------------------------------------------------------------
	 * Resolution center
	 * -----------------------------------------------------------------------------------
	 */
	$( "#me-pick-date-1" ).datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			$( "#me-pick-date-2" ).datepicker({dateFormat: 'yy-mm-dd'});
		    $( "#me-pick-date-2" ).datepicker("option", "minDate", selectedDate );
		    setTimeout(function(){
	            $( "#me-pick-date-2" ).datepicker('show');
	        }, 16);
		}
	});

	$('.me-switch-tab-filter-1, .me-switch-tab-filter-2').on('click', function() {
		$('.me-resolution').toggleClass('me-rslt-filter');
	});

	$('.me-disputed-case-tabs').on('click', function() {
		$(this).toggleClass('active');
		$('body').toggleClass('me-disputed-case-tabs-active').removeClass('me-disputed-action-tabs-active');
		return false;
	});

	$('.me-disputed-action-tabs').on('click', function() {
		$(this).toggleClass('active');
		$('body').toggleClass('me-disputed-action-tabs-active').removeClass('me-disputed-case-tabs-active');
		return false;
	});

	$('.me-receive-item-field').on('change', function(event) {
		var get_refund_block_id = $(this).data('get-refund-block');
		$('#dispute-get-refund-yes').removeClass('active');
		$('#dispute-get-refund-no').removeClass('active');
		$(document.getElementById(get_refund_block_id)).addClass('active');
	});


	/**
	 * [marketengine_snap_column description]
	 * @return {[type]} [description]
	 */
	/*function marketengine_snap_column() {
		var me_snap_column = $('.marketengine-snap-column').innerWidth();
		// console.log(me_snap_column);
		if(me_snap_column >= 1140) {
			$('body').removeClass('marketengine-snap-column-3');
		}
		if((me_snap_column >= 850) && (me_snap_column < 1140)) {
			$('body').addClass('marketengine-snap-column-3');
			$('body').removeClass('marketengine-snap-column-2');
			$('body').removeClass('marketengine-snap-column-1');
		}
		if((me_snap_column >= 556) && (me_snap_column < 850)) {
			$('body').addClass('marketengine-snap-column-2');
			$('body').removeClass('marketengine-snap-column-3');
			$('body').removeClass('marketengine-snap-column-1');
		}
		if(me_snap_column < 556) {
			$('body').addClass('marketengine-snap-column-1');
			$('body').removeClass('marketengine-snap-column-3');
			$('body').removeClass('marketengine-snap-column-2');
		}
	}*/

	// me_snap_column < 1140px
	// me_snap_column < 870px
	// me_snap_column < 580px
	// marketengine_snap_column();
	// window.addEventListener("resize", marketengine_snap_column);
});

