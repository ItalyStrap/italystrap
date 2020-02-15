<?php
/**
 * [Short Description (no period for file headers)]
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Control;

/**
 * Customize for textarea, extend the WP customizer
 *
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Textarea extends WP_Customize_Control {

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   10/16/2012
	 * @return  void
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea class="large-text" cols="20" rows="10" <?php $this->link(); ?>>
				<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
		</label>
		<?php
	}
}
