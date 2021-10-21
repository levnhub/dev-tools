// JS Time

Date.now(); // returns the number of milliseconds
// minute * second * milliseconds
// 15 * 1 * 1000

// Strip HTML tags

String.replace(/(<([^>]+)>)/gi, "")

// JS media queries
	function mediaQueryWatch(mediaWidth) {
		if (mediaWidth.matches) { // If media query matches
			// Mobile
			document.body.style.backgroundColor = "yellow";
		} else {
			// Desktop
			document.body.style.backgroundColor = "pink";
		}
	}

	var mediaWidth = window.matchMedia("(max-width: 996px)")
	mediaQueryWatch(mediaWidth) // Call listener function at run time
	mediaWidth.addListener(mediaQueryWatch) // Attach listener function on state changes