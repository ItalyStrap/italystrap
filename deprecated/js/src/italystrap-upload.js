jQuery(document).ready(function($){

	/**
	 * @link http://brinidesigner.com/use-wordpress-3-5-new-media-uploader-for-your-plugin-and-theme-options-panel-development/
	 * @link  http://codex.wordpress.org/Javascript_Reference/wp.media
	 */
	$('.upload_button').click(function(e) {
		e.preventDefault();
		var prev = $(this).prev();
		var next = $(this).parent().find('.img-preview');
		// console.log(next);
		var image = wp.media({
				title: 'Upload Image',
				// mutiple: true if you want to upload multiple files at once
				multiple: false,

				displaySettings: true,

				displayUserSettings: false

			}).open()
				.on('select', function(e){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_image = image.state().get('selection').first();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						// console.log(uploaded_image);
						var image_url = uploaded_image.toJSON().url;
						// Let's assign the url value to the input field
						prev.val(image_url);
						next.attr('src', image_url);
					});
	});

});