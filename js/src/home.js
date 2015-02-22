jQuery.noConflict()(function($){
	"use strict";
	$(document).ready(function() {
		/**
		 * Activate slide on windows load
		 */
		$('#IndexCarousel').carousel({
			interval : 0,
			pause : "hover"
		});
	});
});