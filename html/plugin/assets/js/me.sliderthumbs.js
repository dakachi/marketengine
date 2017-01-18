

;(function($) {
	var slider = {};

	var defaults = {
		//GENERAL
		slideSelector: '',
		itemWidth: 0,

		// CONTROLS
		controls: false,
		nextSelector: null,
		prevSelector: null,
		itemSliders: 1,


	}
	$.fn.meSliderThumbs = function(options) {

		if(this.length == 0) return this;

		// set a reference to our slider element
		var el = this;
		slider.el = this;
		// merge user-supplied options with the defaults
		slider.settings = $.extend({}, defaults, options);
		// store the original children
		slider.children = el.children(slider.settings.slideSelector);
		
		slider.settings.itemWidth = slider.children.outerHeight(true);
		slider.parent = el.parent();
		if(slider.children.length <= 5) return this;
		el.children(':first-child').addClass('me-first')
		el.children().eq(4).addClass('me-last');
		slider.indexfirst = 0;
		slider.indexlast = slider.children.eq(-1).index();
		var init = function() {
			slider.settings.controls = true;
			// store the current state of the slider (if currently animating, working is true)
			slider.working = false;
			slider.currentsliderrange = 0;
			slider.settings.nextSelector = 'me-next';
			slider.settings.prevSelector = 'me-prev me-deactive';

			var btnSliderNext = document.createElement('a');
			btnSliderNext.className = slider.settings.nextSelector;
			slider.parent.append(btnSliderNext);
			slider.controlsnext = $(btnSliderNext);

			var btnSliderPrev = document.createElement('a');
			btnSliderPrev.className = slider.settings.prevSelector;
			slider.parent.append(btnSliderPrev);
			slider.controlsprev = $(btnSliderPrev);

			// bind click actions to the controls
			slider.controlsnext.bind('click', clickNextBind);
			slider.controlsprev.bind('click', clickPrevBind);
		}

		/**
		 * Click next binding
		 */
		var clickNextBind = function(e){
			el.goToNextSlide();
			e.preventDefault();
			slider.working = false;
		}

		/**
		 * Click prev binding
		 */
		var clickPrevBind = function(e){
			el.goToPrevSlide();
			e.preventDefault();
			slider.working = false;
		}

		/**
		 * Performs slide transition to the specified slide
		 */
		el.goToSlide = function(direction) {
			var _this = this;
			slider.me_first =  slider.el.children('.me-first').index();
			slider.me_last =  slider.el.children('.me-last').index();
			if(slider.working) return;
			slider.working = true;

			if(direction == 'next') {
				if(slider.me_last == slider.indexlast) return;
				slider.currentsliderrange = slider.currentsliderrange - slider.settings.itemWidth * slider.settings.itemSliders;
				var sliderRange = slider.currentsliderrange;
				slider.me_first = slider.me_first + slider.settings.itemSliders;
				slider.me_last = slider.me_last + slider.settings.itemSliders;
				slider.el.children().removeClass('me-first');
				slider.el.children().removeClass('me-last');
				slider.el.css({'top': sliderRange +'px'});
				slider.el.children().eq(slider.me_first).addClass('me-first');
				slider.el.children().eq(slider.me_last).addClass('me-last');
				slider.controlsprev.removeClass('me-deactive');
				if(slider.me_last == slider.indexlast) slider.controlsnext.addClass('me-deactive');
			} else {
				if(slider.me_first == slider.indexfirst) return;
				slider.currentsliderrange = slider.currentsliderrange + slider.settings.itemWidth * slider.settings.itemSliders;
				var sliderRange = slider.currentsliderrange;
				slider.me_first = slider.me_first - slider.settings.itemSliders;
				slider.me_last = slider.me_last - slider.settings.itemSliders;
				slider.el.children().removeClass('me-first');
				slider.el.children().removeClass('me-last');
				slider.el.css({'top': sliderRange +'px'});
				slider.el.children().eq(slider.me_first).addClass('me-first');
				slider.el.children().eq(slider.me_last).addClass('me-last');
				slider.controlsnext.removeClass('me-deactive');
				if(slider.me_first == slider.indexfirst) slider.controlsprev.addClass('me-deactive');
			}

		}

		/**
		 * Transitions to the next slide in the show
		 */
		el.goToNextSlide = function() {
			el.goToSlide('next');
		}

		/**
		 * Transitions to the prev slide in the show
		 */
		el.goToPrevSlide = function() {
			el.goToSlide('prev');
		}

		init();
	}
})(jQuery);