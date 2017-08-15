/**
 * WP Editor Column Addon
 * 
 * @author    David Chandra Purnama <david@shellcreeper.com>
 * @copyright Copyright (c) 2013, David Chandra Purnama
 * @link      http://my.wp-editor.com
 * @link      http://shellcreeper.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

( function ( d ) {

	var lorem = 'Your text here -> Lorem ipsum dolor sit amet. Donec laoreet tincidunt sollicitudin vitae. Proin sagittis turpis semper purus.';

	function getContent( n ) {

		if ( ! n ) {
			n = 1;
		}

		/* First column content if any text selected, use it. */
		var selected_content = tinyMCE.activeEditor.selection.getContent();
		if ( selected_content ){
			return '<p>' + selected_content + '</p>';
		}

		return '<p>' + lorem + '</p>';
	}

	function getRow( type, content ) {

		/* Insert */
		var insert  = '<div class="row">' + content + '</div><p>&nbsp;</p>';

		tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, insert + ' ' );
	}

	function getColumn( n, classes, content ) {

		classes =  typeof classes === "undefined" ? 'col-md' : classes;

		var insert = '<div class="' + classes + '">';
		insert += 1 === n ? getContent( n ) : '<p>' + lorem + '</p>';
		insert += '</div>';

		return insert;
	}

	function build_block ( columns_n, classes ) {
		var content = '';

		if ( ! classes ) {
			classes = [
				'col-md',
			];
		}

		for ( var i = 0; i < columns_n; i++ ) {
			if ( ! classes[ i ] ) {
				classes[ i ] = classes[0];
			}
			content += getColumn( 1 + i, classes[ i ] );
		}

		getRow( '', content );
	}

	/**
	 * ================================================
	 * Setting to Remove Column
	 * ================================================
	 */
	function render_remove_button( e ){

		/* Bail if DOM is not set. */
		if ( typeof tinymce.activeEditor.dom === "undefined" ) {
			return;
		}

		/* Column */
		var col_element = jQuery( tinymce.activeEditor.dom.select( '.row' ) );

		/* Add inline setting */
		col_element.mousemove( function(){

			var $this = jQuery( this );

			/* Add active class */
			$this.addClass('wpe-col-active');

			/* If inline setting not exist, add it */
			if ( $this.children('.remove-block').length <= 0 ) {
				$this.prepend( '<div class="remove-block"></div>' );
			}
		});

		/* Remove inline setting */
		col_element.mouseleave( function(){
			var $this = jQuery( this );
			$this.removeClass('wpe-col-active');
			$this.find( '.remove-block' ).remove();
		});
	}

	/**
	 * ================================================
	 * Do Inline Setting
	 * ================================================
	 */
	function remove_block( e ){

		/* Bail if DOM is not set. */
		if ( typeof tinymce.activeEditor.dom === "undefined" ) {
			return;
		}

		/* Column Remove Icon */
		var remove_icon = jQuery( tinymce.activeEditor.dom.select('.remove-block') );

		/* Remove Column on Click */
		remove_icon.click(function(){

			var $this = jQuery(this);

			/* Add class to delete setting */
			$this.addClass( "wpe-col-setting-ready-remove" );

			/* Add class to delete the current box */
			$this.parent( '.row' ).addClass( "wpe-col-ready-remove" );

			var row_container = $this.parent( '.row' );

			if ( row_container.hasClass('wpe-col-ready-remove') ){

				/* Remove the remove icon */
				row_container.find('.wpe-col-setting-ready-remove').remove();

				var content = '';
				row_container.children( 'div' ).each( function ( index, value ) {
					content += value.innerHTML;
				} );

				/* Add each column content to editor */
				row_container.after( content );

				/* Remove the column */
				row_container.remove();
			}
		});
	}

	/**
	 * ================================================
	 * Presistent adding column, to make sure no column is deleted.
	 * ================================================
	 */
	function wpe_columns_fix( e ){

		/* Bail if DOM is not set. */
		if ( typeof tinymce.activeEditor.dom === "undefined" ) {
			return;
		}

		/* Column */
		var col_element = jQuery( tinymce.activeEditor.dom.select( '.row' ) );

		/* if there's a remove icon */
		if ( col_element.children('.remove-block').length == 0 ) {
			/* No 1st col */
			if ( col_element.children('.wpe-col-1').length == 0 ) {
				/* Add after remove icon */
				col_element.children('.remove-block').after( '<div class="wpe-col-1"><p>&nbsp;</p></div>' );
			}
		}
		/* No remove icon */
		else{
			/* No 1st column, add it in the beginning */
			if ( col_element.children('.wpe-col-1').length == 0 ) {
				col_element.prepend( '<div class="wpe-col-1"><p>&nbsp;</p></div>' );
			}
		}
		/* No 2nd column */
		if ( col_element.children('.wpe-col-2').length == 0 ) {
			/* Add it after 1st column */
			col_element.children('.wpe-col-1').after( '<div class="wpe-col-2"><p>&nbsp;</p></div>' );
		}
		/* 3rd column, only in 13-13-13 */
		if ( col_element.hasClass('wpe-col-13-13-13') ) {
			/* No 3rd column */
			if ( col_element.children('.wpe-col-3').length == 0 ) {
				col_element.children('.wpe-col-2').after( '<div class="wpe-col-3"><p>&nbsp;</p></div>' );
			}
		}
	}

	/**
	 * ================================================
	 * Create TinyMCE Plugin for Boxes
	 * Modified from Crazy Pills Plugins
	 * http://wordpress.org/extend/plugins/crazy-pills/
	 * ================================================
	 */
	tinymce.create( 'tinymce.plugins.wpe_addon_columns', {

		/* Load inline setting on editor click */
		init : function( editor, url ) {

			/**
			 * Per aggiungere più bottoni aggiungere anche il nome del bottone
			 * in TinyMCE::mce_add_buttons_4_columns
			 */

			/* Column 1/2 - 1/2 Button */
			editor.addButton('wpe_addon_col_12_12', {
				title : '1/2-1/2',
				image : url + '/../images/tool-icon-12-12.png',
				onclick : function() {
					build_block ( 2 );
				},
			});
			/* Column 1/3 - 2/3 Button */
			editor.addButton('wpe_addon_col_13_23', {
				title : '1/3-2/3',
				image : url + '/../images/tool-icon-13-23.png',
				onclick : function() {
					build_block ( 2, ['col-md-3','col-md-9'] );
				},
			});
			/* Column 2/3 - 1/3 Button */
			editor.addButton('wpe_addon_col_23_13', {
				title : '2/3-1/3',
				image : url + '/../images/tool-icon-23-13.png',
				onclick : function() {
					build_block ( 2, ['col-md-9','col-md-3'] );
				},
			});
			/* Column 1/3 - 1/3 - 1/3 Button */
			editor.addButton('wpe_addon_col_13_13_13', {
				title : '1/3-1/3-1/3',
				image : url + '/../images/tool-icon-13-13-13.png',
				onclick : function() {
					build_block ( 3 );
				},
			});
			/* Column 1/3 - 1/3 - 1/3 Button */
			editor.addButton('wpe_addon_col_14_14_14', {
				title : '1/4-1/4-1/4-1/4',
				image : url + '/../images/tool-icon-13-13-13.png',
				onclick : function() {
					build_block ( 4 );
				},
			});

			/* Load funtions on Event */
			editor.on( 'init', function( e ) {
				// wpe_columns_fix( e );
				render_remove_button( e );
				remove_block( e );
			});
			editor.on( 'change', function( e ) {
				// wpe_columns_fix( e );
			});
			editor.on( 'focus', function( e ) {
				// wpe_columns_fix( e );
				render_remove_button( e );
				remove_block( e );
			});
			editor.on( 'click', function( e ) {
				// wpe_columns_fix( e );
				render_remove_button( e );
				remove_block( e );
			});
			editor.on( 'show', function( e ) {
				// wpe_columns_fix( e );
				render_remove_button( e );
				remove_block( e );
			});

		},

		/**
		 * Creates control instances based in the incomming name.
		 */
		createControl: function (n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 */
		getInfo : function() {
			return {
				longname : "WP Editor Columns",
				author : "David Chandra Purnama",
				authorurl : 'http://shellcreeper.com',
				infourl : 'http://wp-editor.com',
				version : "0.1.1"
			};
		}
	});

	tinymce.PluginManager.add( 'wpe_addon_columns', tinymce.plugins.wpe_addon_columns );
}(jQuery));