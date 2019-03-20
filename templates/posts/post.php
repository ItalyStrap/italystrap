<?php
/**
 * The template part for displaying standard posts
 *
 * @package ItalyStrap
 * @since 1.0.0
 * @since 4.0.0 Code refactoring.
 */

namespace ItalyStrap;

?>
<article<?php echo HTML\get_attr( 'entry', [ 'id' => \get_the_ID(), 'class' => \join( ' ', \get_post_class() ) ] ) ?>>
<?php
	\do_action( 'italystrap_before_entry_content' );

		\do_action( 'italystrap_entry_content' );

	\do_action( 'italystrap_after_entry_content' );

?>
</article>
