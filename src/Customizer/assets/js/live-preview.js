function italystrap_toogle_control() {
	wp.customize.bind( 'ready', function() {
		console.log( 'message' );
	} );
}

/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 *
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/}
 */
( function( $ ) {
	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.brand-name' ).html( newval );
		} );
	} );
	
	// //Update the site description in real time...
	// wp.customize( 'blogdescription', function( value ) {
	// 	value.bind( function( newval ) {
	// 		$( '.site-description' ).html( newval );
	// 	} );
	// } );

	// //Update site title color in real time...
	// wp.customize( 'header_textcolor', function( value ) {
	// 	value.bind( function( newval ) {
	// 		$('#site-title a').css('color', newval );
	// 	} );
	// } );

	// //Update site background color...
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );
	
	//Update site link color in real time...
	wp.customize( 'link_textcolor', function( value ) {
		value.bind( function( newval ) {
			$('a').css('color', newval );
		} );
	} );

	wp.customize( 'hx_textcolor', function( value ) {
		value.bind( function( newval ) {
			$('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading').css('color', newval );
		} );
	} );

	/**
	 * ==================================================
	 *
	 * Navbar settings
	 *
	 * ==================================================
	 */

	/**
	 * Navbar background color
	 */
	wp.customize( 'navbar[type]', function( value ) {
		value.bind( function( newval ) {
			$('nav.navbar').removeClass( 'navbar-inverse navbar-default' ).addClass( newval );
		} );
	} );

	/**
	 * Navbar position
	 */
	wp.customize( 'navbar[position]', function( value ) {
		value.bind( function( newval ) {
			$('nav.navbar').removeClass( 'navbar-relative-top navbar-fixed-top navbar-fixed-bottom navbar-static-top' ).addClass( newval );
		} );
	} );

	/**
	 *
	 */
	wp.customize( 'navbar[nav_width]', function( value ) {
		value.bind( function( newval ) {
			// console.log(newval);
			$('.navbar-wrapper').removeClass( 'container' ).addClass( newval );
		} );
	} );

	wp.customize( 'navbar[menus_width]', function( value ) {
		value.bind( function( newval ) {
			$('nav > div').removeClass( 'container-fluid container' ).addClass( newval );
		} );
	} );

	// wp.customize( 'navbar[main_menu_x_align]', function( value ) {
	// 	console.log(value);
	// 	value.bind( function( newval ) {
	// 		$('#main-menu').removeClass( 'navbar-left navbar-right' ).addClass( newval );
	// 	} );
	// } );

	wp.customize( 'display_navbar_brand', function( value ) {
		value.bind( function( newval ) {
			console.log(newval);
			// $('.navbar').css('color', newval );
			$('.navbar-brand').css('color', newval );
		} );
	} );

	wp.customize( 'boxed', function( value ) {
		value.bind( function( newval ) {
			$('.wrapper').removeClass( 'boxed' ).addClass( newval );
		} );
	} );

	/**
	 * Breadcrumbs
	 */
	wp.customize( 'breadcrumbs_show_on', function( value ) {
		value.bind( function( newval ) {
			if ( -1 !== $.inArray( $('body').data("current-template"), newval.split(",") ) ) {
				$('.breadcrumb').show();
			} else {
				$('.breadcrumb').hide();
			}
		} );
	} );

	/**
	 * 404 Page settings
	 */
	wp.customize( '404_title', function( value ) {
		value.bind( function( newval ) {
			$( '.404-title' ).html( newval );
		} );
	} );

	wp.customize( '404_content', function( value ) {
		value.bind( function( newval ) {
			$( '.404-content' ).html( newval );
		} );
	} );

	wp.customize( 'colophon', function( value ) {
		value.bind( function( newval ) {
			$( '.colophon-entry-content' ).html( newval );
		} );
	} );

	// wp.customize( 'italystrap_display_navbar_brand', function( value ) {
	// 	console.log( 'italystrap_display_navbar_brand', value );
	// 	value.bind( function( newval ) {
	// 		console.log( 'italystrap_display_navbar_brand', newval );
	// 		// $('.navbar').css('color', newval );
	// 	} );
	// } );

	// wp.customize( 'heading', function( value ) {
	// 	value.bind( function( newval ) {
	// 		console.log(newval);
	// 		$('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .heading').css('font-family', newval );
	// 	} );
	// } );

	// wp.customize( 'custom_css', function( value ) {
	// 	value.bind( function( newval ) {
	// 		$('a').css('color', newval );
	// 	} );
	// } );
	

	// $( '.customize-control-checkbox input[type="checkbox"]' ).on(
	// 	'change',
	// 	function() {

	// 		var elementLi = $( this ).parents( '.customize-control' );

	// 		console.log(elementLi);

	// 		var checkbox_values = elementLi.find( 'input[type="checkbox"]:checked' ).map(
	// 			function() {
	// 				return this.value;
	// 			}
	// 		);

	// 		console.log(checkbox_values);

	// 		// checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
	// 		//		function() {
	// 		//			return this.value;
	// 		//		}
	// 		//	).get().join( ',' );

	// 		// $( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
	// 		// 
	// 		elementLi.find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
	// 	}
	// );
// console.log("hola datevid");
//     $( ".customize-control-select-multiple select" ).on(
//         "change",
//         function() {

//             var checkbox_values = $( this ).parents( '.customize-control' ).find( 'select:selected' ).map(
//                 function() {
//                     return this.value;
//                 }
//             ).get().join( ',' );

//             $( this ).parents( '.customize-control' ).find( 'select' ).val( checkbox_values ).trigger( 'change' );
//         }
//     );

	// wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
	// 	// logic to refresh
	// } );

} )( jQuery );

// console.log("hola datevid");
// jQuery( document ).ready( function() {
// 	console.log("hola datevid");
// 	jQuery( '.customize-control-checkbox input[type="checkbox"]' ).on(
// 		'change',
// 		function() {
// 			var elementLi = jQuery( this ).parents( '.customize-control' );
// 			console.log(elementLi);
// 			var checkbox_values = elementLi.find( 'input[type="checkbox"]:checked' ).map(
// 				function() {
// 					return this.value;
// 				}
// 			);
// 			console.log(checkbox_values);
// 			// checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
// 			//		function() {
// 			//			return this.value;
// 			//		}
// 			//	).get().join( ',' );
// 			// jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
// 			// 
// 			elementLi.find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
// 		}
// 	);
// } ); // jQuery( document ).ready
