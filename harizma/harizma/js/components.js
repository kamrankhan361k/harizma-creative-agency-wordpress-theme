(function ($) {

'use strict';

/*!==========================================================================
 * ==========================================================================
 * ==========================================================================
 *
 * Harizma – Modern Creative Agency WordPress Theme
 *
 * [Table of Contents]
 *
 * 1. Ajax Load More
 * 2. Ajax Render Portfolio Items
 * 3. Article Project
 * 4. Aside Counters
 * 5. Burger
 * 6. Counter
 * 7. Form
 * 8. Gmap
 * 9. Grid
 * 10. Header
 * 11. Lazy Load
 * 12. Menu Overlay
 * 13. Parallax
 * 14. Preloader
 * 15. Scroll Down
 * 16. Lock Scroll
 * 17. Create OS Scene
 * 18. Scroll Up
 * 19. Section Blog
 * 20. Section Intro
 * 21. Section Latest Projects
 * 22. Section Portfolio
 * 23. Section Services
 * 24. Section Testimonials
 * 25. Section Services Tabs
 * 26. Slider Gallery
 * 27. Slider Intro Content
 * 28. Slider Images
 * 29. Slider Intro Backgrounds
 * 30. Slider Project Backgrounds
 * 31. Slider Projects
 * 32. Slider Project Content
 * 33. Slider Services
 * 34. Slider Testimonials
 * 35. Tabs
 * 36. Load Swiper
 * 37. Elementor
 *
 * ==========================================================================
 * ==========================================================================
 * ==========================================================================
 */

var $document = $(document);

/**
 * Default Theme Options
 * Used to prevent errors if there is
 * no data provided from backend
 */

if (typeof window.theme === 'undefined') {
	window.theme = {
		colors: {
			accentPrimary: '#1869ff',
		},
		fonts: ['Open Sans', 'Montserrat'],
		contactForm7: {
			customModals: true
		}
	}
}

/**
 * ScrollMagic Setup
 */
window.SMController = new ScrollMagic.Controller();
window.SMSceneTriggerHook = 0.85;
window.SMSceneReverse = false;

/**
 * Theme Fonts
 */

Preloader();

$document.ready(function () {

	new AsideCounters($document);
	new Burger();
	new SectionBlog($document);
	new ScrollUp();
	new Form();
	new MenuOverlay();
	new Parallax($document);

});

/*!========================================================================
	1. Ajax Load More
	======================================================================!*/
function ajaxLoadMore($scope, dataVars, request, $button, $grid, $filter, cb) {

	if (!$button.length || !dataVars) {
		return;
	}

	var
		labelLoad = $button.data('load-more-text-load') || $button.text(),
		labelLoading = $button.data('load-more-text-loading') || labelLoad,
		labelNo = $button.data('load-more-text-no') || labelLoad,
		inProgressClass = 'locked',
		localVars = dataVars;

	// set "no more" to button if there is already nothing load
	// after initial page load
	if (localVars.current_page >= localVars.max_page) {
		setButtonNoMore($button);
	}

	$button.on('click', function (e) {

		e.preventDefault();

		// prevent double click on the button
		// if the last request not finished yet
		if ($button.hasClass(inProgressClass)) {
			return;
		}

		request.page = localVars.current_page;

		$.ajax({
			url: localVars.ajaxurl, // AJAX handler
			data: request,
			type: 'POST',
			beforeSend: function () {
				// lock button
				$button.addClass(inProgressClass).text(labelLoading);
			},
			success: function (data) {

				// response has some posts to show
				if (data.length) {

					// callback function
					if (cb !== undefined) {
						cb($scope, data, $grid, $filter);
					}

					// needed on the next request
					localVars.current_page++;

					// if it's a last page then set "no more" to button
					if (localVars.current_page >= localVars.max_page) {

						setButtonNoMore($button);

						// unlock button
					} else {

						$button.removeClass(inProgressClass).text(labelLoad);

					}

					// empty response
				} else {

					setButtonNoMore($button);

				}
			}

		});

	});

	function setButtonNoMore($button) {

		$button.attr('class', 'button button_solid button_light cursor-default ' + inProgressClass).text(labelNo);

	}

}

/*!========================================================================
	2. Ajax Render Portfolio Items
	======================================================================!*/
function ajaxRenderPortfolioItems($scope, data, $grid, $filter) {

	if (!data || !$grid.length) {
		return;
	}

	var items = JSON.parse(data);

	addItemsToGrid();

	if ($filter.length) {
		addItemsToFilter();

	}

	function addItemsToGrid() {

		$.each(items, function () {

			var current = this;

			// use the first item in grid as a template
			var
				$template = $grid.find('.js-grid__item:visible').eq(0).clone(),
				$template_link = $template.find('.grid__item-link');

			// clear template categories classes
			// ahd any styling applied
			$template.alterClass('category-*').removeAttr('style');

			// check it it's a lightbox gallery and adjust link to the full image
			if ($template_link.data('elementor-open-lightbox') == true) {
				$template_link.attr('href', current.image_full[0]);
			} else {
				$template_link.attr('href', current.link);
			}

			$template.find('img').attr({
				src: current.image[0],
				width: current.image[1],
				height: current.image[2],
			}).css({
				opacity: '0',
				visibility: 'hidden'
			});

			$template.find('h3').html(current.title);

			if (current.categories.length) {

				var
					currentCategories = [],
					stringCategories;

				$.each(current.categories, function () {

					currentCategories.push(this.name);

					// add categories classes to the template
					$template.addClass('category-' + this.slug);

				});

				stringCategories = currentCategories.join(' | ');
				$template.find('.grid__item-category').html(stringCategories);

			}

			// add item to grid
			$grid.append($template);

			// reset filter
			if ($filter.length) {
				resetFilter();
			}

			// update grid
			$grid.isotope('appended', $template);

		});

		$grid.imagesLoaded(function () {
			setTimeout(function () {
				$grid.find('.js-grid__item img').css({
					opacity: 1,
					visibility: 'visible'
				});
				$grid.isotope('layout');
			}, 300);
		});

	}

	function addItemsToFilter() {

		var
			$filterItems = $filter.find('.js-filter__item'),
			$filterLine = $filter.find('.js-tabs__underline');

		if (!$filterLine.length) {
			return;
		}

		var
			$template = $filterItems.eq(0).clone(),
			filterCategories = [];

		// clear template data
		$template.removeAttr('data-filter').removeClass('tabs__item_active');

		$.each($filterItems, function () {

			filterCategories.push($(this).data('filter'));

		});

		$.each(items, function () {

			var current = this;

			if (current.categories.length) {

				$.each(current.categories, function () {

					var currentSlug = '.category-' + this.slug;

					// if there is a new slug that doesn't exist
					// in the filter at the moment - add this item
					// using the existing markup

					if (filterCategories.indexOf(currentSlug) === -1) {

						var $newItem = $template;

						$newItem.attr('data-filter', currentSlug);
						$newItem.find('h4').html(this.name);

						// add event listener to new item
						$newItem.on('click', function (e) {

							e.preventDefault();

							var filterBy = $(this).data('filter');

							$grid.isotope({
								filter: filterBy
							});

						});

						// add item to filter before underline
						$filterLine.before($newItem);

						resetFilter();

					}

				});

			}

		});

	}

	function resetFilter() {

		var Filter = new Tabs($scope, $filter);

		$grid.isotope({
			filter: '*'
		});

		Filter.setActiveTab(0);

	}

}

/*!========================================================================
	3. Article Project
	======================================================================!*/
var ArticleProject = function ($scope) {

	var $target = $scope.find('.project');

	if (!$target.length) {
		return;
	}

	createSlider();

	function createSlider() {

		var
			$sliderImages = $target.find('.js-slider-images'),
			sliderImages = new SliderImages($sliderImages);

		// start from 2nd slide to not show empty space
		// from the left
		sliderImages.slideTo(1);

	}

}

/*!========================================================================
	4. Aside Counters
	======================================================================!*/
var AsideCounters = function ($scope) {

	var $target = $scope.find('.aside-counters');

	if (!$target) {
		return;
	}

	var $counter = $scope.find('.js-counter');

	$counter.each(function () {

		new Counter($(this));

	});

}

/*!========================================================================
	5. Burger
	======================================================================!*/
var Burger = function () {

	var
		OPEN_CLASS = 'burger_opened',
		$overlay = $('.header__wrapper-overlay-menu');

	var header = new Header();

	$(document).on('click', '.js-burger', function (e) {

		e.preventDefault();

		if (!$overlay.hasClass('in-transition')) {

			var $burger = $(this);

			if ($burger.hasClass(OPEN_CLASS)) {
				$burger.removeClass(OPEN_CLASS);
				header.closeOverlayMenu();
			} else {
				$burger.addClass(OPEN_CLASS);
				header.openOverlayMenu();
			}

		}

	});

}

/*!========================================================================
	6. Counter
	======================================================================!*/
var Counter = function ($target) {

	var $num = $target.find('.js-counter__number');

	if (!$target.length || !$num.length) {
		return;
	}

	var
		numberStart = $target.data('counter-start') || 0,
		numberTarget = $target.data('counter-target') || 100,
		animDuration = $target.data('counter-duration') || 4,
		counter = {
			val: numberStart
		};

	setCounterUp();
	animateCounterUp();

	function setCounterUp() {

		$num.text(numberStart.toFixed(0));

	}

	function animateCounterUp() {

		var tl = new TimelineMax();

		tl.to(counter, animDuration, {
			val: numberTarget.toFixed(0),
			ease: Power4.easeOut,
			onUpdate: function () {
				$num.text(counter.val.toFixed(0));
			}
		});

		createOSScene($target, tl);

	}

}

/*!========================================================================
	7. Form
	======================================================================!*/
var Form = function () {

	var $form = $('.js-ajax-form');

	if (typeof window.theme !== 'undefined' && window.theme.contactForm7.customModals) {
		attachModalsEvents();
	}

	if (!$form.length) {
		return;
	}

	$form.on('submit', function (e) {
		e.preventDefault();
	});

	validateForm();

	function validateForm() {

		$form.validate({
			errorElement: 'span',
			errorPlacement: function (error, element) {
				error.appendTo(element.parent()).addClass('form-control__error');
			},
			submitHandler: function (form) {
				ajaxSubmit();
			}
		});

	}

	function ajaxSubmit() {

		$.ajax({
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: $form.serialize()
		}).done(function () {
			alert($form.attr('data-message-success'));
			$form.trigger('reset');
			floatLabels();
		}).fail(function () {
			alert($form.attr('data-message-error'));
		});
	}

	function attachModalsEvents() {
		$(document).on('wpcf7submit', function (e) {

			var $modal = $('#modalContactForm7');

			$modal.modal('dispose').remove();

			if (e.detail.apiResponse.status === 'mail_sent') {

				createModalTemplate({
					icon: 'icon-success.svg',
					message: e.detail.apiResponse.message,
				});
			}

			if (e.detail.apiResponse.status === 'mail_failed') {
				createModalTemplate({
					icon: 'icon-error.svg',
					message: e.detail.apiResponse.message
				});
			}

		});
	}

	function createModalTemplate({
		icon,
		message,
		onHide
	}) {

		$('body').append(`
			<div class="modal fade" id="modalContactForm7">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content radius-img">
						<div class="modal__close" data-dismiss="modal"><img src="${window.theme.themeURL}/img/general/icon-close.svg"/></div>
							<header class="text-center modal__header">
								<img src="${window.theme.themeURL}/img/general/${icon}" width="80px" height="80px" alt=""/>
								<h4 class="modal__message">${message}</h4>
							</header>
							<button type="button" class="button button_solid button_accent" data-dismiss="modal"><span>OK</span></button>
					</div>
				</div>
			</div>
		`);
		var $modal = $('#modalContactForm7');

		$modal.modal('show');
		$modal.on('hidden.bs.modal', function () {
			$modal.modal('dispose').remove();
			if (typeof onHide === 'function') {
				onHide();
			}
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
		});

	}

}

/*!========================================================================
	8. Gmap
	======================================================================!*/
var GMap = function ($scope) {

	var
		$wrapper = $scope.find('.gmap'),
		prevInfoWindow = false;

	if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
		return;
	}

	createMap($wrapper);

	/**
	 * 
	 * @param {Map jQuery Object} $wrapper 
	 */
	function createMap($wrapper) {

		var $mapContainer = $wrapper.find('.gmap__container');

		if (!$mapContainer.length) {
			return;
		}

		var
			$markers = $wrapper.find('.gmap__marker'),
			ZOOM = parseInt($wrapper.attr('data-gmap-zoom')),
			SNAZZY_STYLES = $wrapper.attr('data-gmap-snazzy-styles');

		var argsMap = {
			center: new google.maps.LatLng(0, 0),
			zoom: ZOOM,
		};

		if (SNAZZY_STYLES) {

			try {
				SNAZZY_STYLES = JSON.parse(SNAZZY_STYLES);
				$.extend(argsMap, {
					styles: SNAZZY_STYLES
				});
			} catch (err) {
				console.error('Google Map: Invalid Snazzy Styles');
			}

		};

		var map = new google.maps.Map($mapContainer[0], argsMap);

		map.markers = [];

		$markers.each(function () {
			createMarker($(this), map);
		});

		centerMap(ZOOM, map);

	}

	/**
	 * 
	 * @param {Marker jQuery object} $marker 
	 * @param {Google Map Instance} map
	 */
	function createMarker($marker, map) {

		if (!$marker.length) {
			return;
		}

		var
			MARKER_LAT = parseFloat($marker.attr('data-marker-lat')),
			MARKER_LON = parseFloat($marker.attr('data-marker-lon')),
			MARKER_IMG = $marker.attr('data-marker-img'),
			MARKER_WIDTH = $marker.attr('data-marker-width'),
			MARKER_HEIGHT = $marker.attr('data-marker-height'),
			MARKER_CONTENT = $marker.attr('data-marker-content');

		/**
		 * Marker
		 */
		var argsMarker = {
			position: new google.maps.LatLng(MARKER_LAT, MARKER_LON),
			map: map
		};

		if (MARKER_IMG) {

			$.extend(argsMarker, {
				icon: {
					url: MARKER_IMG
				}
			});

		}

		if (MARKER_IMG && MARKER_WIDTH && MARKER_HEIGHT) {

			$.extend(argsMarker.icon, {
				scaledSize: new google.maps.Size(MARKER_WIDTH, MARKER_HEIGHT)
			});

		}

		var marker = new google.maps.Marker(argsMarker)

		map.markers.push(marker);

		/**
		 * Info Window (Content)
		 */
		if (MARKER_CONTENT) {

			var infoWindow = new google.maps.InfoWindow({
				content: MARKER_CONTENT
			});

			marker.addListener('click', function () {

				if (prevInfoWindow) {
					prevInfoWindow.close();
				}

				prevInfoWindow = infoWindow;

				infoWindow.open(map, marker);

			});

		}

	}

	/**
	 * 
	 * @param {Map Zoom} zoom 
	 * @param {Google Map Instance} map
	 */
	function centerMap(zoom, map) {

		var
			bounds = new google.maps.LatLngBounds(),
			newZoom;

		$.each(map.markers, function () {

			var item = this;
			newZoom = new google.maps.LatLng(item.position.lat(), item.position.lng());
			bounds.extend(newZoom);

		});

		if (map.markers.length == 1) {

			map.setCenter(bounds.getCenter());
			map.setZoom(zoom);

		} else {

			map.fitBounds(bounds);

		}
	}

}

/*!========================================================================
	9. Grid
	======================================================================!*/
var Grid = function ($grid) {

	if (!$grid.length) {
		return false;
	}

	var masonryGrid = createGrid();

	lazyLoad($grid, $grid.find('.lazy-masonry'), function () {
		$grid.isotope('layout');
	});

	$grid.imagesLoaded(function () {
		setTimeout(function () {
			$grid.isotope('layout');
		}, 300);
	});

	function createGrid() {

		var grid = $grid.isotope({
			itemSelector: '.js-grid__item',
			columnWidth: '.js-grid__sizer',
			percentPosition: true
		});

		return grid;

	}

	return masonryGrid;

}

/*!========================================================================
	10. Header
	======================================================================!*/
var Header = function () {

	var
		$body = $('body'),
		$overlay = $('.header__wrapper-overlay-menu');

	if (!$overlay.length) {
		return;
	}

	var
		self = this,
		$pageWrapper = $('.page-wrapper'),
		$menu = $('.js-menu-overlay'),
		$menuLinks = $overlay.find('.menu-overlay > li > a .menu-overlay__item-wrapper'),
		$overlayLinks = $overlay.find('.menu-overlay > li a'),
		$burger = $('.js-burger'),
		$linksTop = $menu.find('> li > a'),
		$submenu = $overlay.find('.menu-overlay .sub-menu'),
		$submenuButton = $overlay.find('.js-submenu-back'),
		$submenuLinks = $submenu.find('> li > a .menu-overlay__item-wrapper'),
		$curtain1 = $overlay.find('.header__diagonal-curtain-1'),
		$curtain2 = $overlay.find('.header__diagonal-curtain-2'),
		$background = $overlay.find('.header__wrapper-background'),
		$backgrounds = $overlay.find('.header__background'),
		$overlayBackgrounds = $overlay.find('.header__overlay'),
		$overlayWidgets = $overlay.find('.header__wrapper-overlay-widgets');

	setOverlayMenu();

	if ($backgrounds.length) {
		hoverBackgrounds();
	}

	function setOverlayMenu() {

		TweenMax.set([$overlay, $overlayBackgrounds], {
			autoAlpha: 0
		});

		TweenMax.set([$menuLinks, $submenuLinks], {
			y: '100%'
		});

		TweenMax.set($overlayWidgets, {
			y: '10px',
			autoAlpha: 0
		});

		TweenMax.set([$submenu, $submenuButton], {
			autoAlpha: 0,
			x: '10px'
		});

		TweenMax.set($backgrounds, {
			autoAlpha: 0,
			scale: 1.1
		});

		TweenMax.set($curtain1, {
			x: '-50%',
		});

		TweenMax.set($curtain2, {
			x: '50%',
		});

	}

	this.closeOverlayMenu = function (cb) {

		lockScroll(false);

		var tl = new TimelineMax();

		tl.timeScale(1.5);

		tl
			.set($overlay, {
				className: '+=in-transition',
			})
			.set($pageWrapper, {
				// display: 'block',
				className: '-=page-wrapper_hidden',
			})
			.to([$menuLinks, $submenuLinks], 0.6, {
				y: '-100%',
				ease: Power4.easeIn
			})
			.to($overlayWidgets, 0.6, {
				y: '-10px',
				autoAlpha: 0
			}, '-=0.3')
			.to($submenuButton, 0.6, {
				x: '-10px',
				autoAlpha: 0
			}, 0)
			.set($overlayBackgrounds, {
				autoAlpha: 0
			})
			.set($background, {
				backgroundColor: 'transparent'
			})
			.to($backgrounds, 1, {
				autoAlpha: 0,
				scale: 1.1,
				ease: Power4.easeOut,
			}, 0.4)
			.to($curtain1, 1, {
				x: '-50%',
				right: '20%',
				ease: Expo.easeInOut,
			}, 0.6)
			.to($curtain2, 1, {
				x: '50%',
				left: '80%',
				ease: Expo.easeInOut,
			}, 0.6)
			.set($overlay, {
				className: '-=in-transition'
			})
			.add(function () {
				if (typeof cb === 'function') {
					cb();
				}

				setOverlayMenu();
			});

	};

	this.openOverlayMenu = function () {

		lockScroll(true);

		var tl = new TimelineMax();

		tl
			.set($overlay, {
				className: '+=in-transition',
				autoAlpha: 1
			})
			.to([$curtain1, $curtain2], 1, {
				x: '0%',
				ease: Expo.easeInOut,
			})
			.set($pageWrapper, {
				// display: 'none',
				className: '+=page-wrapper_hidden',
			})
			.to($overlayBackgrounds, 0.3, {
				autoAlpha: 1
			})
			.staggerTo($menuLinks, 0.6, {
				y: '0%',
				ease: Power4.easeOut,
			}, .075, 0.8)
			.to($overlayWidgets, 0.6, {
				y: '0px',
				autoAlpha: 1
			}, '-=0.3')
			.to($background, 0.3, {
				backgroundColor: '#181818'
			})
			.set($overlay, {
				className: '-=in-transition'
			});

	};

	function hoverBackgrounds() {

		$linksTop
			.on('mouseenter click', function () {

				if (Modernizr.mq('(min-width: 768px)')) {

					var
						postId = $(this).data('post-id'),
						$targetBackground = $backgrounds.filter('[data-header-background-for="' + postId + '"]');

					if (!$targetBackground.length) {
						return;
					}

					TweenMax.to($curtain1, 0.6, {
						right: '50%',
						ease: Expo.easeInOut
					});

					TweenMax.to($curtain2, 0.6, {
						left: '100%',
						ease: Expo.easeInOut
					});

					TweenMax.to($targetBackground, 0.6, {
						autoAlpha: 1,
						scale: 1,
						ease: Expo.easeInOut,
					});

				}

			})
			.on('mouseleave', function () {

				var $openedSubmenus = $('.sub-menu.opened');

				if ($openedSubmenus.length) {
					return;
				}

				var
					postId = $(this).data('post-id'),
					$targetBackground = $backgrounds.filter('[data-header-background-for="' + postId + '"]');

				TweenMax.to($curtain1, 0.6, {
					right: '20%',
					ease: Expo.easeInOut
				});

				TweenMax.to($curtain2, 0.6, {
					left: '80%',
					ease: Expo.easeInOut
				});

				TweenMax.to($targetBackground, 0.6, {
					autoAlpha: 0,
					scale: 1.1,
					ease: Expo.easeInOut,
				});

			});

	}

	this._scrollToAnchorFromMenu = function({
    element,
    url,
    menu = 'overlay'
  }) {
    if (!url || !element) {
      return;
    }

    const filteredUrl = url.substring(url.indexOf('#'));

    try {
      if (filteredUrl.length) {
        const $el = $body.find(filteredUrl);

        if ($el.length) {
          element.on('click', (e) => {
            e.stopPropagation();
            e.preventDefault();

            if (menu === 'overlay') {
							self.closeOverlayMenu(() => {
								$burger.removeClass('burger_opened');

								$('html, body').stop().animate({
									scrollTop: $el.offset().top
								}, 800, 'swing');
              });
            }
          });

        }
      }
    } catch (error) {
      console.error('An error occured while handling menu anchor links: ' + error);
    }

  }

	// Handle anchors
	$overlayLinks.filter('a[href*="#"]:not([href="#"]):not([href*="#elementor-action"])').each(function () {
		var
			$current = $(this),
			url = $current.attr('href');

		self._scrollToAnchorFromMenu({
			element: $current,
			url,
			menu: 'overlay'
		});
	});

}

/*!========================================================================
	11. Lazy Load
	======================================================================!*/
function lazyLoad($scope, $elements, callback) {

	if (!$scope) {
		var $scope = $(document);
	}

	if (!$elements) {
		var $elements = $scope.find('.lazy');
	}

	var $images = $elements.find('[data-src]');
	var $backgrounds = $scope.find('.lazy-bg');

	$images.Lazy({

		afterLoad: function (el) {

			$(el).parent().css({
				'padding-bottom': '0%',
				'height': 'initial',
				'animation-name': 'none',
				'background-color': 'initial'
			});

			if (typeof callback === 'function') {
				callback();
			}

		}

	});

	$backgrounds.Lazy();

}

/*!========================================================================
	12. Menu Overlay
	======================================================================!*/
var MenuOverlay = function () {

	var $menu = $('.js-menu-overlay');

	if (!$menu.length) {
		return;
	}

	var
		$overlay = $('.header__wrapper-overlay-menu'),
		$links = $menu.find('.menu-item-has-children > a'),
		$submenus = $menu.find('.sub-menu'),
		$submenuButton = $('.js-submenu-back'),
		$curtain1 = $overlay.find('.header__diagonal-curtain-1'),
		$curtain2 = $overlay.find('.header__diagonal-curtain-2'),
		$backgrounds = $overlay.find('.header__background'),
		OPEN_CLASS = 'opened',
		tl = new TimelineMax();

	function openSubmenu($submenu, $currentMenu) {

		var
			$currentLinks = $currentMenu.find('> li > a .menu-overlay__item-wrapper'),
			$submenuLinks = $submenu.find('> li > a .menu-overlay__item-wrapper');

		tl
			.set($overlay, {
				className: '+=in-transition',
			})
			.set($submenu, {
				autoAlpha: 1,
				zIndex: 100,
				y: '0px'
			})
			.to($currentLinks, 0.6, {
				y: '-100%',
				ease: Power4.easeIn
			}, '-=0.3')
			.staggerTo($submenuLinks, 0.6, {
				y: '0%',
				ease: Power4.easeOut
			}, 0.05)
			.set($overlay, {
				className: '-=in-transition',
			});

		$submenus.removeClass(OPEN_CLASS);
		$submenu.not($menu).addClass(OPEN_CLASS);

		if ($submenus.hasClass(OPEN_CLASS)) {
			tl.to($submenuButton, 0.3, {
				autoAlpha: 1,
				x: '0px'
			}, '-=0.6');
		} else {
			tl.to($submenuButton, 0.3, {
				autoAlpha: 0,
				x: '-10px'
			}, '-=0.6');
		}

	}

	function closeSubmenu($submenu, $currentMenu) {

		var
			$currentLinks = $currentMenu.find('> li > a .menu-overlay__item-wrapper'),
			$submenuLinks = $submenu.find('> li > a .menu-overlay__item-wrapper');

		tl
			.set($overlay, {
				className: '+=in-transition',
			})
			.set($submenu, {
				zIndex: -1
			})
			.to($submenuLinks, 0.6, {
				y: '100%',
				ease: Power4.easeIn
			}, '-=0.3')
			.staggerTo($currentLinks, 0.6, {
				y: '0%',
				ease: Power4.easeOut
			}, 0.05)
			.set($submenu, {
				autoAlpha: 0,
				y: '10px'
			})
			.set($overlay, {
				className: '-=in-transition',
			});

		$submenus.removeClass(OPEN_CLASS);
		$currentMenu.not($menu).addClass(OPEN_CLASS);

		if ($submenus.hasClass(OPEN_CLASS)) {
			TweenMax.to($submenuButton, 0.3, {
				autoAlpha: 1,
				x: '0px'
			}, '-=0.6');
		} else {

			TweenMax.to($submenuButton, 0.3, {
				autoAlpha: 0,
				x: '-10px'
			}, '-=0.6');

			TweenMax.to($curtain1, 0.6, {
				right: '20%',
				ease: Expo.easeInOut
			});

			TweenMax.to($curtain2, 0.6, {
				left: '80%',
				ease: Expo.easeInOut
			});

			TweenMax.to($backgrounds, 0.6, {
				autoAlpha: 0,
				scale: 1.1,
				ease: Expo.easeInOut,
			});

		}

	}

	$links.on('click', function (e) {

		e.preventDefault();

		if (!$overlay.hasClass('in-transition')) {
			var
				$el = $(this),
				$currentMenu = $el.parents('ul'),
				$submenu = $el.next('.sub-menu');

			openSubmenu($submenu, $currentMenu);
		}

	});

	$submenuButton.on('click', function (e) {

		e.preventDefault();

		if (!$overlay.hasClass('in-transition')) {
			var
				$openedMenu = $submenus.filter('.' + OPEN_CLASS),
				$prevMenu = $openedMenu.parent('li').parent('ul');

			closeSubmenu($openedMenu, $prevMenu);
		}

	})

}

/*!========================================================================
	13. Parallax
	======================================================================!*/
var Parallax = function ($scope = $document) {

	var $wrapper = $scope.find('[data-art-parallax]');

	if (!$wrapper.length) {
		return;
	}

	$wrapper.each(function () {

		var
			$current = $(this),
			$img = $current.find('img, .art-parallax__bg'),
			factor = parseFloat($current.data('art-parallax-factor')) || 0.3,
			factorTo = Math.abs(factor) * 100,
			factorFrom = -1 * factor * 100,
			factorScale = 1 + Math.abs(factor),
			sceneDuration = window.innerHeight + $current.height();

		if ($img.is('img')) {
			sceneDuration = window.innerHeight + $current.parent().height();
		}

		if (!$img.length) {
			return;
		}

		if (factorFrom > 0) {
			factorScale = factorScale * factorScale;
			factorTo = factor * 100;
		}

		var tl = new TimelineMax();

		TweenMax.set($img, {
			scale: factorScale,
			transformOrigin: 'center center',
			force3D: true,
			rotationZ: 0.01,
			ease: Expo.easeInOut
		});

		tl.fromTo($img, 0.3, {
			y: factorFrom + '%',
			force3D: true,
			ease: Linear.easeNone,
		}, {
			y: factorTo + '%',
			force3D: true,
			ease: Linear.easeNone,
		});

		var scene = new ScrollMagic.Scene({
				triggerElement: $current,
				triggerHook: 1,
				duration: sceneDuration
			})
			.setTween(tl)
			.addTo(window.SMController)
			.update(true);

		// update scene when smooth scroll is enabled
		if (window.SB !== undefined) {

			window.SB.addListener(function () {
				scene.refresh();
			});

		}

	});

}

/*!========================================================================
	14. Preloader
	======================================================================!*/
function Preloader() {

	var
		tl = new TimelineMax(),
		$pageWrapper = $('.page-wrapper'),
		$preloader = $('.preloader'),
		$bar = $preloader.find('.preloader__progress'),
		$fill = $preloader.find('.preloader__progress-fill'),
		$curtains = $preloader.find('.preloader__curtain'),
		$curtains = $curtains.get().reverse();

	function finish() {

		return new Promise(function (resolve) {

			document.fonts.ready.then(function () {

				tl
					.clear()
					.set($fill, {
						animationPlayState: 'paused',
					})
					.to($fill, 1, {
						animation: 'none',
						scaleX: 1,
						transformOrigin: 'left center',
						ease: Expo.easeOut,
						immediateRender: true
					})
					.to($bar, 0.6, {
						autoAlpha: 0,
						y: '-30px'
					})
					.staggerTo($curtains, 1, {
						x: '-100%',
						ease: Expo.easeInOut,
					}, 0.1, '-=0.6')
					.set($preloader, {
						autoAlpha: 0
					})
					.add(function () {
						resolve();
					}, '-=0.6');

			});

		})

	}

	function drawLoading() {

		tl
			.to($fill, 20, {
				scaleX: 1,
				transformOrigin: 'left center',
				ease: SlowMo.ease.config(0.7, 0.7, false)
			});

	}

	function animateUnload() {

		window.onbeforeunload = function () {
			$pageWrapper.addClass('page-wrapper_hidden');
			return;
		};

	}

	return new Promise(function (resolve, reject) {

		// animateUnload();
		drawLoading();
		lazyLoad($document);
		$pageWrapper.removeClass('page-wrapper_hidden');

		if (!$preloader.length) {
			resolve();
		} else {
			finish().then(function () {
				resolve();
			});
		}

	});

}

/*!========================================================================
	15. Scroll Down
	======================================================================!*/
var ScrollDown = function ($target) {

	var $section = $target.closest('.section-fullheight');

	if (!$target.length || !$section.length) {
		return;
	}

	var
		offset = $section.height(),
		$body = $('html, body');

	$target.on('click', function (e) {

		e.preventDefault();
		$body.animate({
			scrollTop: offset
		}, 600, 'swing');

	});

}

/*!========================================================================
	16. Lock Scroll
	======================================================================!*/
function lockScroll(enabled) {

	var
		$body = $('body'),
		$window = $(window),
		LOCK_CLASS = 'body_lock-scroll',
		lastTop = $window.scrollTop();

	if (enabled === true) {

		$body
			.addClass(LOCK_CLASS)
			.css({
				top: -lastTop
			});

	} else {

		var
			offset = parseInt($body.css('top'), 10),
			offsetValue = Math.abs(offset);

		$body
			.removeClass(LOCK_CLASS)
			.css({
				top: 'auto'
			});

		$window.scrollTop(offsetValue);

	}

}

/*!========================================================================
	17. Create OS Scene
	======================================================================!*/
function createOSScene($el, tl, $customTrigger, noReveal) {

	var $trigger = $el;

	if ($customTrigger && $customTrigger.length) {
		$trigger = $customTrigger;
	}

	if (!noReveal) {
		// reveal hidden element first
		tl.add([TweenMax.set($el, {
			autoAlpha: 1
		})], 'start');
	}

	new $.ScrollMagic.Scene({
			triggerElement: $trigger,
			triggerHook: window.SMSceneTriggerHook,
			reverse: window.SMSceneReverse
		})
		.setTween(tl)
		.addTo(window.SMController);

}

/*!========================================================================
	18. Scroll Up
	======================================================================!*/
var ScrollUp = function () {

	var
		$target = $('.js-scroll-up'),
		tl = new TimelineMax();

	prepare();
	animate();
	scrollUp();

	function prepare() {

		if (!$target.length) {
			return;
		}

		TweenMax.set($target, {
			autoAlpha: 0,
			y: '20px'
		});

	}

	function animate() {

		if (!$target.length) {
			return;
		}

		var
			offset = $(window).height(),
			$trigger = $('body');

		tl.to($target, 0.6, {
			autoAlpha: 1,
			y: '0px'
		});

		new $.ScrollMagic.Scene({
				reverse: true,
				triggerElement: $trigger,
				offset: offset
			})
			.setTween(tl)
			.addTo(window.SMController);

	}

	function scrollUp() {

		if (!$target.length) {
			return;
		}

		$target.on('click', function (e) {

			e.preventDefault();

			$('html, body').stop().animate({
				scrollTop: 0
			}, 800, 'swing');

		});

	}

}

/*!========================================================================
	19. Section Blog
	======================================================================!*/
var SectionBlog = function ($scope) {

	var $target = $scope.find('.section-blog');

	if (!$target.length) {
		return;
	}

	createSlider();

	function createSlider() {

		var
			$sliderGallery = $target.find('.js-slider-gallery');

		new SliderGallery($sliderGallery);

	}

}

/*!========================================================================
	20. Section Intro
	======================================================================!*/
var SectionIntro = function ($scope) {

	var $target = $scope.find('.section-intro');

	if (!$target.length) {
		return;
	}

	var
		$sliderContent = $target.find('.js-slider-intro-content'),
		$sliderBackgrounds = $target.find('.js-slider-intro-backgrounds'),
		sliderContent = new SliderIntroContent($sliderContent),
		sliderBackgrounds = new SliderIntroBackgrounds($sliderBackgrounds),
		$header = $('.header'),
		$contentContainer = $target.find('.section-intro__wrapper-content'),
		$sectionInner = $target.find('.section-fullheight__inner'),
		$curtain1 = $target.find('.section-intro__diagonal-curtain-1'),
		$curtain2 = $target.find('.section-intro__diagonal-curtain-2'),
		$scrollDown = $target.find('.js-scroll-down');

	if (sliderContent.slides.length <= 1) {
		sliderContent.destroy(true, true);
		sliderBackgrounds.destroy(true, true);
	} else {
		chainSliders();
	}

	new ScrollDown($scrollDown);
	// offsetHeader();
	// prepare();
	// animate();

	function chainSliders() {

		if (sliderContent && sliderBackgrounds) {

			sliderContent.controller.control = sliderBackgrounds;
			sliderBackgrounds.controller.control = sliderContent;

		}

	}

	function offsetHeader() {

		if ($header.length) {

			var offset = $header.height();

			if ($header.hasClass('header_absolute')) {
				$contentContainer.css({
					paddingTop: offset + 'px'
				});

			} else {

				$sectionInner.css({
					minHeight: 'calc(100vh - ' + offset + 'px)'
				});

			}

		}

	}

	function prepare() {

		TweenMax.set([$curtain1, $curtain2], {
			x: '-100%',
			y: '-100%'
		});

	}

	function animate() {
		TweenMax.staggerTo([$curtain1, $curtain2], 2, {
			x: '0%',
			y: '0%',
			ease: Expo.easeInOut
		}, 0.3);
	}

}

/*!========================================================================
	21. Section Latest Projects
	======================================================================!*/
var SectionLatestProjects = function ($scope) {

	var $target = $scope.find('.section-latest-projects');

	if (!$target.length) {
		return;
	}

	var
		$slider = $target.find('.js-slider-projects'),
		$inners = $target.find('.section-latest-projects__inner'),
		$tabs = $target.find('.js-tabs');

	bindSliderTabs();
	createInnerSliders();

	function bindSliderTabs() {

		if (!$slider.length || !$tabs.length) {
			return;
		}

		var slider = new SliderProjects($slider);
		var tabs = new Tabs($scope, $tabs);

		// initial set
		tabs.setActiveTab(slider.activeIndex);

		// handle slides change
		slider.on('slideChange', function () {
			tabs.setActiveTab(this.activeIndex);
		});

		// handle clicks on tabs
		tabs.$items.on('click', function () {
			var index = $(this).index();
			slider.slideTo(index);
		});

	}

	function createInnerSliders() {

		if (!$inners.length) {
			return;
		}

		$inners.each(function () {

			var
				$el = $(this),
				$sliderContent = $el.find('.js-slider-project-content'),
				$sliderBackgrounds = $el.find('.js-slider-project-backgrounds'),
				sliderContent = new SliderProjectContent($sliderContent),
				sliderBackgrounds = new SliderProjectBackgrounds($sliderBackgrounds);

			chainSliders();

			function chainSliders() {

				if (sliderContent && sliderBackgrounds) {

					sliderContent.controller.control = sliderBackgrounds;
					sliderBackgrounds.controller.control = sliderContent;

				}

			}

		});

	}

}

/*!========================================================================
	22. Section Portfolio
	======================================================================!*/
var SectionPortfolio = function ($scope) {

	if (!$scope.length) {
		$scope = $document;
	}

	var
		$target = $scope.find('.section-portfolio'),
		$filter = $target.find('.js-filter'),
		$grid = $target.find('.js-grid'),
		$button = $target.find('.js-load-more-button');

	bindGridTabs();
	loadMore();

	function bindGridTabs() {

		var Filter = new Tabs($scope, $filter);
		var GridPortfolio = new Grid($grid);

		if ($filter.length) {

			Filter.setActiveTab(0);

			Filter.$items.on('click', function (e) {

				e.preventDefault();

				var filterBy = $(this).data('filter');

				GridPortfolio.isotope({
					filter: filterBy
				});

			});

		}


		GridPortfolio.isotope({
			filter: '*'
		});

	}

	function loadMore() {

		if (!$button.length || !$grid.length) {
			return;
		}

		var
			dataVars = $grid.data('ajax'),
			request = {
				'action': 'loadmore',
				'post_type': 'arts_portfolio_item',
				'query': JSON.stringify(dataVars.posts)
			};

		ajaxLoadMore($scope, dataVars, request, $button, $grid, $filter, ajaxRenderPortfolioItems, bindGridTabs);

	}

}

/*!========================================================================
	23. Section Services
	======================================================================!*/
var SectionServices = function ($scope) {

	var $target = $scope.find('.section-services');

	if (!$target.length) {
		return;
	}

	var
		$servicesHover = $target.find('.js-service-hover'),
		$backgrounds = $target.find('.js-service-hover__background');

	if ($servicesHover.length && $backgrounds.length) {
		hoverBackgrounds();
	}

	function hoverBackgrounds() {

		TweenMax.set($backgrounds, {
			autoAlpha: 0,
			scale: 1.1
		});

		$servicesHover
			.on('mouseenter touchstart', function (e) {

				var
					postId = $(this).data('services-post-id'),
					$targetBackground = $backgrounds.filter('[data-services-background-for="' + postId + '"]'),
					$otherBackgrounds = $backgrounds.not($targetBackground);

				TweenMax.to($otherBackgrounds, 0.6, {
					autoAlpha: 0,
					scale: 1.1,
					ease: Expo.easeInOut,
				});

				TweenMax.to($targetBackground, 0.6, {
					autoAlpha: 1,
					scale: 1,
					ease: Expo.easeInOut
				});

			}).on('mouseleave touchend', function (e) {

				TweenMax.to($backgrounds, 0.6, {
					autoAlpha: 0,
					scale: 1.1,
					ease: Expo.easeInOut,
				});

			});

	}

}

/*!========================================================================
	24. Section Testimonials
	======================================================================!*/
var SectionTestimonials = function ($scope) {

	var $target = $scope.find('.section-testimonials');

	if (!$target.length) {
		return;
	}

	var $slider = $target.find('.js-slider-testimonials');

	createSlider();

	function createSlider() {

		if (!$slider.length) {
			return;
		}

		var slider = new SliderTestimonials($slider);

	}

}

/*!========================================================================
	25. Section Services Tabs
	======================================================================!*/
var SectionServicesTabs = function ($scope) {

	var
		$slider = $scope.find('.js-slider-services'),
		$tabs = $scope.find('.js-tabs');

	bindSliderTabs();

	function bindSliderTabs() {

		if (!$slider.length || !$tabs.length) {
			return;
		}

		var slider = new SliderServices($slider);
		var tabs = new Tabs($scope, $tabs);

		// initial set
		tabs.setActiveTab(slider.activeIndex);

		// handle slides change
		slider.on('slideChange', function () {
			tabs.setActiveTab(this.activeIndex);
		});

		$(window).on('resize', function () {
			tabs.setActiveTab(this.activeIndex);
		})

		// handle clicks on tabs
		tabs.$items.on('click', function () {
			var index = $(this).index();
			slider.slideTo(index);
		});

	}

}

/*!========================================================================
	26. Slider Gallery
	======================================================================!*/
var SliderGallery = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		autoplay: {
			delay: 6000
		},
		speed: 800,
		preloadImages: false,
		lazy: {
			loadPrevNext: true,
			loadOnTransitionStart: true
		},
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		pagination: {
			el: '.js-slider-gallery__nav',
			type: 'bullets',
			bulletElement: 'div',
			clickable: true,
			bulletClass: 'slider-nav__dot',
			bulletActiveClass: 'slider-nav__dot_active'
		}
	});

	return slider;

}

/*!========================================================================
	27. Slider Intro Content
	======================================================================!*/
var SliderIntroContent = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		speed: $slider.data('speed') || 1200,
		autoplay: {
			enabled: $slider.data('autoplay-enabled') || false,
			delay: $slider.data('autoplay-delay') || 6000,
		},
		pagination: {
			el: '.js-slider-intro-content__nav',
			type: 'bullets',
			bulletElement: 'div',
			clickable: true,
			bulletClass: 'slider-nav__dot',
			bulletActiveClass: 'slider-nav__dot_active'
		},
		simulateTouch: false
	});

	return slider;

}

/*!========================================================================
	28. Slider Images
	======================================================================!*/
var SliderImages = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var
		lg = elementorFrontend.config.breakpoints.lg - 1 || 1024,
		md = elementorFrontend.config.breakpoints.md - 1 || 767;

	var slider = new Swiper($slider[0], {
		autoHeight: true,
		speed: $slider.data('speed') || 1200,
		parallax: true,
		preloadImages: false,
		lazy: {
			loadPrevNext: true,
			loadOnTransitionStart: true
		},
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		centeredSlides: $slider.data('centered-slides') || true,
		slidesPerView: $slider.data('slides-per-view') || 1.75,
		slidesPerGroup: 1, // compatibility with Swiper 5.x
		autoplay: {
			enabled: $slider.data('autoplay-enabled') || false,
			delay: $slider.data('autoplay-delay') || 6000,
		},
		spaceBetween: $slider.data('space-between') || 30,
		pagination: {
			el: '.js-slider-images__nav',
			type: 'bullets',
			bulletElement: 'div',
			clickable: true,
			bulletClass: 'slider-nav__dot',
			bulletActiveClass: 'slider-nav__dot_active'
		},
		navigation: {
			nextEl: '.js-slider-images__next',
			prevEl: '.js-slider-images__prev',
		},
		breakpointsInverse: true // compatibility with both Swiper 4.x and 5.x
	});

	slider.params.breakpoints = {
		[lg]: {
			centeredSlides: $slider.data('centered-slides') || true,
			slidesPerView: $slider.data('slides-per-view') || 1.75,
			spaceBetween: $slider.data('space-between') || 30,
		},
		[md]: {
			slidesPerView: $slider.data('slides-per-view-tablet') || 1.33,
			spaceBetween: $slider.data('space-between-tablet') || 15,
			centeredSlides: $slider.data('centered-slides-tablet') || true,
		},
		0: {
			slidesPerView: $slider.data('slides-per-view-mobile') || 1.2,
			spaceBetween: $slider.data('space-between-mobile') || 15,
			centeredSlides: $slider.data('centered-slides-mobile') || true,
		}
	};

	slider.update();

	// update height after images are loaded
	slider.on('lazyImageReady', function () {
		slider.update();
	});

	return slider;

}

/*!========================================================================
	29. Slider Intro Backgrounds
	======================================================================!*/
var SliderIntroBackgrounds = function () {

	var $slider = $('.js-slider-intro-backgrounds');

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		speed: 1200,
		watchSlidesVisibility: true,
		preloadImages: false,
		lazy: {
			loadPrevNext: true
		},
		direction: 'vertical'
	});

	return slider;

}

/*!========================================================================
	30. Slider Project Backgrounds
	======================================================================!*/
var SliderProjectBackgrounds = function ($slider) {

	if (!$slider.length) {
		return false;
	}

	var slider = new Swiper($slider[0], {
		effect: 'fade',
		fadeEffect: {
			crossFade: true
		},
		speed: 1200,
		watchSlidesVisibility: true,
		preloadImages: false,
		lazy: {
			loadPrevNext: true
		},
		watchSlidesProgress: true,
		simulateTouch: false,
		nested: true,
		parallax: true
	});

	return slider;

}

/*!========================================================================
	31. Slider Projects
	======================================================================!*/
var SliderProjects = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		effect: 'fade',
		fadeEffect: {
			crossFade: true
		},
		speed: 1200,
		simulateTouch: false,
	});

	return slider;

}

/*!========================================================================
	32. Slider Project Content
	======================================================================!*/
var SliderProjectContent = function ($slider) {

	if (!$slider.length) {
		return false;
	}

	var slider = new Swiper($slider[0], {
		speed: 1200,
		preloadImages: false,
		lazy: {
			loadPrevNext: true,
			loadOnTransitionStart: true
		},
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		pagination: {
			el: $slider.find('.js-slider-project-content__nav'),
			type: 'bullets',
			bulletElement: 'div',
			clickable: true,
			bulletClass: 'slider-nav__dot',
			bulletActiveClass: 'slider-nav__dot_active',
		},
		navigation: {
			nextEl: '.js-slider-project-content__next',
			prevEl: '.js-slider-project-content__prev',
		},
		parallax: true,
		nested: true
	});

	return slider;

}

/*!========================================================================
	33. Slider Services
	======================================================================!*/
var SliderServices = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		speed: 800,
		autoHeight: true
	});

	return slider;

}

/*!========================================================================
	34. Slider Testimonials
	======================================================================!*/
var SliderTestimonials = function ($slider) {

	if (!$slider.length) {
		return;
	}

	var slider = new Swiper($slider[0], {
		autoHeight: true,
		speed: $slider.data('speed') || 1200,
		autoplay: {
			enabled: $slider.data('autoplay-enabled') || false,
			delay: $slider.data('autoplay-delay') || 6000,
		},
		pagination: {
			el: $slider.find('.js-slider-testimonials__nav'),
			type: 'bullets',
			bulletElement: 'div',
			clickable: true,
			bulletClass: 'slider-nav__dot',
			bulletActiveClass: 'slider-nav__dot_active',
		},
	});

	return slider;

}

/*!========================================================================
	35. Tabs
	======================================================================!*/
var Tabs = function ($scope, $tabs) {

	if (!$tabs.length) {
		return;
	}

	var
		self = this,
		itemClass = '.js-tabs__item',
		$items = $scope.find(itemClass),
		activeItemClass = 'tabs__item_active';

	this.$tabs = $scope.find($tabs);
	this.$items = $scope.find($items);

	bindEvents();
	updateLinePosition();

	function bindEvents() {

		$($scope)
			.on('mouseenter', itemClass, function () {

				updateLinePosition($(this));

			})
			.on('mouseleave', itemClass, function () {

				updateLinePosition($items.filter('.' + activeItemClass));

			})
			.on('click', itemClass, function () {

				var $el = $(this);

				$items.removeClass(activeItemClass);
				$el.addClass(activeItemClass);
				updateLinePosition($el);

			});

	}

	function updateLinePosition($target) {

		var
			$line = self.$tabs.find('.js-tabs__underline');

		if (!$line.length) {
			return;
		}

		if (!$target || !$target.length) {

			TweenMax.to($line, 0.6, {
				width: 0
			});

		} else {

			var
				headingWidth = $target.find('h4').innerWidth(),
				headingPos = $target.find('h4').position().left,
				colPos = $target.position().left;

			TweenMax.to($line, 0.6, {
				ease: Expo.easeInOut,
				width: headingWidth,
				x: headingPos + colPos,
			});

		}

	}

	function setActiveTab(index) {

		var $target = $items.eq(index);
		if (!$target) {
			return;
		}

		$items.removeClass(activeItemClass);
		$target.addClass(activeItemClass);
		updateLinePosition($target, self.$tabs);

	}

	this.setActiveTab = function (index) {
		setActiveTab(index);
	}

}

/*!========================================================================
	36. Load Swiper
	======================================================================!*/
function loadSwiper() {
	return new Promise((resolve) => {
		if (typeof Swiper === 'undefined' && typeof elementorFrontend.utils.swiper !== 'undefined') {
			elementorFrontend.utils.assetsLoader.load('script', 'swiper').then(() => resolve(true));
		} else {
			resolve(true);
		}
	});
}

/*!========================================================================
	37. Elementor
	======================================================================!*/
$(window).on('elementor/frontend/init', function () {

	elementorFrontend.hooks

		.addAction('frontend/element_ready/harizma-widget-slider-intro.default', function ($scope) {

			loadSwiper().then(() => {
				new SectionIntro($scope);
				lazyLoad($scope);
			});

		})

		.addAction('frontend/element_ready/harizma-widget-services-grid.default', function ($scope) {

			new SectionServices($scope);
			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-logos-grid.default', function ($scope) {

			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-contacts.default', function ($scope) {

			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-team-member.default', function ($scope) {

			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-slider-testimonials.default', function ($scope) {

			loadSwiper().then(() => {
				new SectionTestimonials($document);
				lazyLoad($scope);
			});

		})

		.addAction('frontend/element_ready/harizma-widget-background-link.default', function ($scope) {

			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-step.default', function ($scope) {

			lazyLoad($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-slider-images.default', function ($scope) {

			loadSwiper().then(() => {
				new SliderImages($scope.find('.js-slider-images'));
			});

		})

		.addAction('frontend/element_ready/harizma-widget-google-map.default', function ($scope) {

			new GMap($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-portfolio-masonry-grid.default', function ($scope) {

			// fixes for elementor preview
			if (typeof elementor !== 'undefined') {
				$scope = $document;
			}

			new SectionPortfolio($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-masonry-grid.default', function ($scope) {

			// fixes for elementor preview
			if (typeof elementor !== 'undefined') {
				$scope = $document;
			}

			new SectionPortfolio($scope);

		})

		.addAction('frontend/element_ready/harizma-widget-portfolio-slider.default', function ($scope) {

			loadSwiper().then(() => {
				new SectionLatestProjects($scope);
			});

		})

		.addAction('frontend/element_ready/harizma-widget-services-slider.default', function ($scope) {

			loadSwiper().then(() => {
				new SectionServicesTabs($scope);
			});

		})

		.addAction('frontend/element_ready/harizma-widget-latest-posts.default', function ($scope) {

			lazyLoad($scope);

		});

});



/**
 * Elementor Document Settings
 * Live Preview & Editing
 */
jQuery(window).on('elementor/frontend/init', function () {

	if (typeof elementor != 'undefined') {

		/**
		 * Version Compare
		 */
		function compareVersion(v1, v2) {
			if (typeof v1 !== 'string') return false;
			if (typeof v2 !== 'string') return false;
			v1 = v1.split('.');
			v2 = v2.split('.');
			const k = Math.min(v1.length, v2.length);
			for (let i = 0; i < k; ++i) {
				v1[i] = parseInt(v1[i], 10);
				v2[i] = parseInt(v2[i], 10);
				if (v1[i] > v2[i]) return 1;
				if (v1[i] < v2[i]) return -1;
			}
			return v1.length == v2.length ? 0 : (v1.length < v2.length ? -1 : 1);
		}

		/**
		 * Reload Preview & Open Panel
		 */
		function updatePreview(openedPageAfter, openedTabAfter, openedSectionAfter) {
			elementor.reloadPreview();
			elementor.once('preview:loaded', () => {
				if (openedPageAfter) {
					elementor.getPanelView().setPage(openedPageAfter);
				}

				if (openedTabAfter) {
					elementor.getPanelView().getCurrentPageView().activeTab = openedTabAfter;
				}

				if (openedSectionAfter) {
					elementor.getPanelView().getCurrentPageView().activateSection(openedSectionAfter);
				}

				elementor.getPanelView().getCurrentPageView().render();
			});
		}

		/**
		 * Reload Elementor Preview
		 */
		function reloadPreview(openedPageAfter, openedTabAfter, openedSectionAfter) {

			// Backward Compatibility for Elementor 2.8.5 or earlier
			if (compareVersion(elementor.config.version, '2.9.0') <= 0) {
				elementor.saver.update({
					onSuccess: () => {
						updatePreview(openedPageAfter, openedTabAfter, openedSectionAfter);
					}
				});
			} else {
				elementor.saver.update().then(() => {
					updatePreview(openedPageAfter, openedTabAfter, openedSectionAfter)
				});
			}

		}

		/**
		 * Page Header Settings
		 */
		elementor.settings.page.addChangeCallback('page_header_settings', function (newval) {
			reloadPreview('page_settings', 'settings', 'header_section');
		});

		/**
		 * Header Theme
		 */
		elementor.settings.page.addChangeCallback('page_header_theme', function (newval) {
			reloadPreview('page_settings', 'settings', 'header_section');
		});

		/**
		 * Menu Style
		 */
		elementor.settings.page.addChangeCallback('page_menu_style', function (newval) {
			reloadPreview('page_settings', 'settings', 'header_section');
		});

	}

});


})(jQuery);
