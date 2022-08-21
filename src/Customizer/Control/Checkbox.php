<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer\Control;

use WP_Customize_Control;

/**
 * Class for single checkbox in the customizer
 *
 * @link http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
 */
class Checkbox extends WP_Customize_Control {

	/**
	 * @access public
	 * @var string
	 */
	// public $type = 'checkbox';

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   10/16/2012
	 * @return  void
	 */
	// phpcs:ignore
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>"
				<?php //checked( in_array( $this->value(), $multi_values ) ); ?> />
			<?php echo esc_html( $this->label ); ?>
		</label>
		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
<?php
	}
}
