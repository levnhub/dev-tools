$ = jQuery; // WP only

// Includes
//= './include/jquery.typographer.js'
//= './include/jquery.hyphen.ru.js'

// Main JS File
$(document).ready(function () {

// Ready
	console.log('jQuery Ready!');

// Typography
	jQuery(function($) {
		$('p, h1, h2, h3, h4, h5, h6, blockquote, .js-typo, .js-text').typographer();
		$('p, blockquote, .js-hypen, .js-text').hyphenate();
	});

// Pre-loader
	$(".js-loader-inner").fadeOut(); 
	$(".js-loader").delay(400).fadeOut("slow");

}); // Ready end

// Prevent Scroll to Top
	$('a[href*="#"]').click(function($e) {
			$e.preventDefault();
	});

// ...

