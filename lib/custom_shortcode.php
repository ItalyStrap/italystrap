<?php
/**
 * The following snippet will reveal the hidden "Styles" dropdown in the advanced toolbar.
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
 * @since 1.9.2
 *
 */

function italystrap_reveal_hidden_tinymce_buttons($buttons){
	//Add style selector to the beginning of the toolbar
	array_unshift($buttons, 'styleselect');

	return $buttons;
}

add_filter('mce_buttons_2','italystrap_reveal_hidden_tinymce_buttons'); 

/**
 * Add Next Page/Page Break Button
 * in WordPress Visual Editor
 *
 * @link http://shellcreeper.com/?p=889
 * @link http://shellcreeper.com/how-to-add-next-page-or-page-break-button-in-wordpress-editor/
 */
function italystrap_break_page_button( $buttons, $id ){

	/* only add this for content editor */
	if ( 'content' != $id )
		return $buttons;

	/* add next page after more tag button */
	array_splice( $buttons, 13, 0, 'wp_page' );

	return $buttons;
}

/* Add Next Page Button in First Row */
add_filter( 'mce_buttons', 'italystrap_break_page_button', 1, 2 ); // 1st row

?>