jQuery( document ).ready( function() {

	/* === Select box Multiple Control === */

	jQuery( ".customize-control-select-multiple select" ).on(
		"change",
		function() {
			var $this = jQuery( this );
			var parents = $this.parents( '.customize-control' );
			parents.find( 'input[type="hidden"]' ).val( $this.val() ).trigger( 'change' );
		}
	);

} ); // jQuery( document ).ready