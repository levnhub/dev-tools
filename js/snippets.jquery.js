// JS SNIPPETS

// Scroll to Top
	$('.js-up').on('click', function () {
		window.scrollTo({
			top: 0,
			behavior: "smooth"
		});
	});

// Smooth Scroll
	$(document).ready(function(){
		// Add smooth scrolling to all links
		$("a").on('click', function(event) {

			// Make sure this.hash has a value before overriding default behavior
			if (this.hash !== "") {
				// Prevent default anchor click behavior
				event.preventDefault();

				// Store hash
				var hash = this.hash;

				// Using jQuery's animate() method to add smooth page scroll
				// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
				$('html, body').animate({
					scrollTop: $(hash).offset().top
				}, 300, function(){

					// Add hash (#) to URL when done scrolling (default click behavior)
					window.location.hash = hash;
				});
			} // End if
		});
	});

// Fancybox
	// Defaults
	$.fancybox.defaults.lang = "ru";
	$.fancybox.defaults.i18n = {
		ru: {
			CLOSE: "Закрыть",
			NEXT: "Следующий",
			PREV: "Предыдущий",
			ERROR: "Ошибка загрузки контента, попробуйте обновить страницу, либо свяжитесь с нами",
			PLAY_START: "Начать слайдшоу",
			PLAY_STOP: "Остановать слайдшоц",
			FULL_SCREEN: "Полный экран",
			THUMBS: "Плитка",
			DOWNLOAD: "Скачать",
			SHARE: "Поделиться",
			ZOOM: "Увеличить"
		}
	};

	$('[data-fancybox]').fancybox({
		buttons: [
	    "close"
	  ],
	  btnTpl: {
	    close:
	      '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
	      '<i class="icon icon-close"></i>' +
	      "</button>"
	  }
	});

// BS Collapse
	$('.js-collapse-trigger').on('click', function () {

		$(this).siblings('.collapse').collapse('toggle');
		$(this).toggleClass('trigger-active');

		if ( $(this).hasClass('trigger-active') ) {
			$(this).text('Свернуть');
		} else {
			$(this).text('Развернуть');
		}

	});

// JQuery Masked Input
	// Money mask
	$('.js-money').mask('000 000 000 000 000', { reverse: true });

	// Tel Mask
	var telMaskOptions = {
		'translation': {
			0: {pattern: /[0-9*]/}
		}
	}

	function addTelMask(el) {
		el.mask('+7 (000) 000–00–00', telMaskOptions);

		// Manually add counry on focus
		el.on('focus', function () {
			if ( el.val() == '' ) {
				el.val('+7 (');
			}
		});
		el.on('blur', function () {
			if ( el.val() == '+7 (' ) {
				el.val('');
			}
		});
	};

	addTelMask( $('input[type="tel"]') );

// Window scroll event
	$(window).scroll(function(){
	  console.log( $(this).scrollTop() );
	});

// Slick carousel refresh
  $(window).on('resize orientationchange', function() {
    $('.js-carousel').slick('resize');
  });

  $.each(array/object, function(index, val) {
  	 /* iterate through array or object */
  });