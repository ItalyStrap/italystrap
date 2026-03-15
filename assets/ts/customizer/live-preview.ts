function italystrap_toogle_control() {
	wp.customize.bind( 'ready', function() {
	} );
}

/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using native DOM APIs.
 *
 * {@link https://developer.wordpress.org/themes/customize-api/the-customizer-javascript-api/}
 */

( function() {
	var body = document.body;

	function getElements( selector ) {
		return document.querySelectorAll( selector );
	}

	function setInnerHtml( selector, value ) {
		getElements( selector ).forEach( function( element ) {
			element.innerHTML = value;
		} );
	}

	function setStyle( selector, property, value ) {
		getElements( selector ).forEach( function( element ) {
			element.style.setProperty( property, value );
		} );
	}

	function replaceClasses( selector, classesToRemove, classToAdd ) {
		getElements( selector ).forEach( function( element ) {
			element.classList.remove.apply( element.classList, classesToRemove );
			if ( classToAdd ) {
				element.classList.add( classToAdd );
			}
		} );
	}

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			setInnerHtml( '.brand-name', newval );
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
			body.style.setProperty( 'background-color', newval );
		} );
	} );

	/**
	 * ==================================================
	 *
	 * Navigation settings
	 *
	 * ==================================================
	 */

	/**
	 * Navigation background color
	 */
	wp.customize( 'navbar[type]', function( value ) {
		value.bind( function( newval ) {
			replaceClasses( 'nav.site-nav', [ 'is-dark', 'is-light' ], newval );
		} );
	} );

	/**
	 * Navigation position
	 */
	wp.customize( 'navbar[position]', function( value ) {
		value.bind( function( newval ) {
			replaceClasses(
				'nav.site-nav',
				[ 'is-relative-top', 'is-fixed-top', 'is-fixed-bottom', 'is-static-top' ],
				newval
			);
		} );
	} );

	/**
	 *
	 */
	wp.customize( 'navbar[nav_width]', function( value ) {
		value.bind( function( newval ) {
			replaceClasses( '.site-nav-wrapper', [ 'container' ], newval );
		} );
	} );

	wp.customize( 'navbar[menus_width]', function( value ) {
		value.bind( function( newval ) {
			replaceClasses( 'nav > div', [ 'container-fluid', 'container' ], newval );
		} );
	} );

	wp.customize( 'display_navbar_brand', function( value ) {
		value.bind( function( newval ) {
			setStyle( '.site-nav-brand', 'color', newval );
		} );
	} );

	wp.customize( 'boxed', function( value ) {
		value.bind( function( newval ) {
			replaceClasses( '.wrapper', [ 'boxed' ], newval );
		} );
	} );

	/**
	 * Breadcrumbs
	 */
	wp.customize( 'breadcrumbs_show_on', function( value ) {
		value.bind( function( newval ) {
			var currentTemplate = body.dataset.currentTemplate;
			var templateList = newval ? newval.split( ',' ) : [];

			getElements( '.breadcrumb' ).forEach( function( element ) {
				element.style.display = templateList.indexOf( currentTemplate ) !== -1 ? '' : 'none';
			} );
		} );
	} );

	/**
	 * 404 Page settings
	 */
	wp.customize( '404_title', function( value ) {
		value.bind( function( newval ) {
			setInnerHtml( '.404-title', newval );
		} );
	} );

	wp.customize( '404_content', function( value ) {
		value.bind( function( newval ) {
			setInnerHtml( '.404-content', newval );
		} );
	} );

	wp.customize( 'colophon', function( value ) {
		value.bind( function( newval ) {
			setInnerHtml( '.colophon-entry-content', newval );
		} );
	} );

	// wp.customize( 'italystrap_display_navbar_brand', function( value ) {
	// 	value.bind( function( newval ) {
	// 		// $('.navbar').css('color', newval );
	// 	} );
	// } );

	// wp.customize( 'heading', function( value ) {
	// 	value.bind( function( newval ) {
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

	// 		var checkbox_values = elementLi.find( 'input[type="checkbox"]:checked' ).map(
	// 			function() {
	// 				return this.value;
	// 			}
	// 		);

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

} )();

// jQuery( document ).ready( function() {
// 	jQuery( '.customize-control-checkbox input[type="checkbox"]' ).on(
// 		'change',
// 		function() {
// 			var elementLi = jQuery( this ).parents( '.customize-control' );
// 			var checkbox_values = elementLi.find( 'input[type="checkbox"]:checked' ).map(
// 				function() {
// 					return this.value;
// 				}
// 			);
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
