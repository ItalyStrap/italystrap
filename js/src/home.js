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

		$('#cat').addClass('form-control');
		$('select').addClass('form-control');
		$('#wp-calendar').addClass('table table-hover');
		$('td a').addClass('badge').css('margin-right', '-10px');

		/**
		 * This snippet works only if ItalyStrap plugin with
		 * Lazy Load functionality is active
		 * @url https://wordpress.org/plugins/italystrap/
		 */
		var cHeight = 0;
		$("#IndexCarousel").on("slide.bs.carousel", function(){var $nextImage = $(".active.item", this).next(".item").find("img");var src = $nextImage.data("src");if (typeof src !== "undefined" && src !== ""){$nextImage.attr("src", src);$nextImage.data("src", "");}});

	});
});