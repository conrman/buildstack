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

			// svg fallbacks
			svgeezy.init(false, 'png');

			// load to avoid FOUC
			$('body').addClass('loaded');

			Roots.common.offCanvasNav();
			Roots.common.scrollToTop();
			Roots.common.fancybox();
			Roots.common.smoothScroll();
			// Roots.common.modal();


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
		smoothScroll: function(e) {
			$('a[href*=#]').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
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
		modal: function(target, options) {
			$(target).magnificPopup(options);
		},
		/******************************************************************
		Tooltip
		******************************************************************/
		tooltip: function(target, options) {
			$(target).tipr(options);
		},
		/******************************************************************
		Fancybox
		******************************************************************/
		fancybox: function() {
			$('.fancybox').fancybox();
		},
		/******************************************************************
		Isotope
		******************************************************************/
		isotope: function(container, options) {
			var $container = $(container).imagesLoaded( function() {
				$container.isotope(options);
			});
		},
		/******************************************************************
		Slick Slider
		******************************************************************/
		slickSlider: function(target, options) {
			$(target).slick(options);
		},
		/******************************************************************
		Match Height
		******************************************************************/
		matchHeight: function(target) {
			$(target).matchHeight();
		}
	},
	home: {
		init: function() {
			Roots.common.slickSlider("#home-slider", {
				cssEase: 'ease-in-out',
				touchMove: false,
				autoplay: true,
				autoplaySpeed: 2000,
				accessibility: false,
				draggable: false,
				speed: 2500,
				arrows: true,
				centerMode: true,
				variableWidth: true,
			});
		}
	},
	amenities: {
		init: function() {
			
		}
	},
	floor_plans: {
		init: function() {
			Roots.spaces.bedNav();
			Roots.spaces.unitSelect();
		},
		bedNav: function() {
			$('.bed-select').click(function() {
				$('.bed-select').removeClass('active');
				$(this).addClass('active');

				var beds = $(this).data('beds');
				$('.floorplan-excerpt.active').removeClass('active');
				$('.floorplan-excerpt[data-beds="' + beds + '"]').addClass('active');
			});
		},
		unitSelect: function() {
			$('.floorplan-excerpt').click(function() {
				var floorplan = $(this).data('floorplan');
				var $floorplan = $('.floorplan-unit[data-floorplan="' + floorplan + '"]');
				if ($floorplan.hasClass('selected')) {
					$(this).parent().next().remove();
					$floorplan.removeClass('selected');
				} else {
					$(this).parent().next().remove();
					$('.floorplan-unit').removeClass('selected');
					$floorplan.clone().insertAfter($(this).parent()).addClass('selected');
				}
			});
		}
	},
	gallery: { 
		init: function() {
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
		}
	},
	residents: {
		init: function() {
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
