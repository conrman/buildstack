/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

 (function($) {

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
var Roots = {
	// All pages
	common: {
		init: function() {

			$('body').css('opacity', '1');
			Roots.common.offCanvasNav();
			Roots.common.smoothScroll();
			Roots.common.scrollToTop();
			Roots.common.fancybox();
			// Roots.common.modal();
			// Roots.common.tooltip();

			// Moves the .info-wrapper above/below .logo
			Roots.common.infoWrapper()
			$(window).resize(function() { Roots.common.infoWrapper() });

		},
		/******************************************************************
		Off-Canvas/Mobile Menu
		******************************************************************/
		offCanvasNav: function() {
			$("#app-header .main-nav > ul").clone().appendTo("#off-canvas-nav");
		},
		/******************************************************************
		Smooth Scroll
		******************************************************************/
		smoothScroll: function() {

			$('a[href*=#]').click(function() {
				if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') || location.hostname === this.hostname) {
					var target = $(this.hash);
					target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
					if (target.length) {
						$('html,body').animate({
							scrollTop: target.offset().top
						}, 1200);
						return false;
					}
				}
			});

		},
		/******************************************************************
		Scroll to Top
		******************************************************************/
		scrollToTop: function() {

			$(window).bind("scroll", function() {
				if ($(this).scrollTop() > 350) {
					$(".scroll-top").addClass('active');
				} else {
					$(".scroll-top").stop().removeClass('active');
				}
			});
		},
		/******************************************************************
		Modals
		******************************************************************/
		modal: function() {

			$('.modal-image').magnificPopup({
				type: 'image',
			});

			$('.modal-gallery').magnificPopup({
				type: 'image',
				delegate: 'a',
				gallery: {
					enabled: true
				},
			});

			$('.inline-modal').magnificPopup({
				type:'inline',
				midClick: true,
			});
		},
		/******************************************************************
		Tooltip
		******************************************************************/
		tooltip: function() {

			$('.tooltip').tipr({
				'speed': 300,
				'mode': 'top'
			});

		},
		/******************************************************************
		Fancybox
		******************************************************************/
		fancybox: function() {
			$('.fancybox').fancybox();
		},
		/******************************************************************
		Info Wrapper
		******************************************************************/
		infoWrapper: function() {
			var ww = $(window).width();
			var infoWrapper = $('.info-wrapper');
			var original = $('.main-nav');
			var target = '.app-header';

			if (ww < 925) {
				infoWrapper.prependTo(target);
			} else {
				infoWrapper.prependTo(original);
			}
		}
	},
	// Home page
	home: {
		init: function() {
			Roots.home.main_slider();

			$('.contact-badge-1').click(function() { window.location = '/location'; });
			$('.contact-badge-3').click(function() { window.location = '/contact'; });
		},
		/******************************************************************
		Main Slider
		******************************************************************/
		main_slider: function() {

			$("#home-slider").slick({
				cssEase: 'linear',
				touchMove: false,
				autoplay: true,
				autoplaySpeed: 0,
				accessibility: false,
				draggable: false,
				speed: 25000
			});
		}
	},
	floor_plans: {
		init: function() {
			Roots.floor_plans.nav_bedroom();
			Roots.floor_plans.nav_unit();

			var src = swap_src = "";
			$('.bed-select > img').mouseover(function() {
				src = $(this).attr('src');
				swap_src= $(this).data('swap');

				if (!$(this).parent().hasClass('active')) {
					$(this).attr('src', swap_src).data('swap', src);
				}
			});
			$('.bed-select > img').mouseout(function() {
				if (!$(this).parent().hasClass('active')) {
					$(this).attr('src', src).data('swap', swap_src);
				}
			});

		},
		nav_bedroom: function() {
			$('.bedroom-units > [data-beds="two bedroom"]').hide();
			$('.bed-select').click(function() {
				var src = swap_src = "";
				src = $('.bed-select.active').children('img').attr('src');
				swap_src = $('.bed-select.active').children('img').data('swap');

				if (!$(this).hasClass('active')) {
					$('.bed-select.active').children('img').attr('src', swap_src);
					$('.bed-select.active').children('img').data('swap', src);
				}

				$('.bed-select').removeClass('active');
				var beds = $(this).addClass('active').data('beds');
				$('.bedroom-units > .bed-unit').hide();
				$('.bedroom-units > [data-beds="' + beds + '"]').show();
			});
		},
		nav_unit: function() {
			$('.bed-unit').click(function() {
				$('.bed-unit').removeClass('active');
				var floorplan = $(this).addClass('active').data('floorplan');
				$('.floorplan-unit').hide();
				$('.floorplan-unit[data-floorplan="' + floorplan + '"]').show();
			});
		}
	},
	gallery: { 
		init: function() {
			// Roots.gallery.grid_gallery();
		},
		grid_gallery: function() {

		}
	},
	location: {
		init: function() {
			$('.map-nav-link').click(function() {
				$('.map-nav-link').removeClass('active');
				$(this).addClass('active');
			});
		}
	},
	contact: {
		init: function() {
			$('.contact-form`').matchHeight();
		}
	}
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
	fire: function(func, funcname, args) {
		var namespace = Roots;
		funcname = (funcname === undefined) ? 'init' : funcname;
		if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
			namespace[func][funcname](args);
		}
	},
	loadEvents: function() {
		UTIL.fire('common');

		$.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
			UTIL.fire(classnm);
		});
	}
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
