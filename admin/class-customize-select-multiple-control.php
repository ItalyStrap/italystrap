<?php
/**
 * Class for extending WP_Customize_Control with a multiple select
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Admin;

use WP_Customize_Control;
use WP_Customize_Manager;

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A class to create a dropdown for all google fonts
 */
class Customize_Select_Multiple_Control extends WP_Customize_Control {


	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'select-multiple';

	/**
	 * Fonts container
	 *
	 * @var string
	 */
	private $fonts;

	/**
	 * Init the constructor
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    {
	 *     Optional. Arguments to override class property defaults.
	 *
	 *     @type int                  $instance_number Order in which this instance was created in relation
	 *                                                 to other instances.
	 *     @type WP_Customize_Manager $manager         Customizer bootstrap instance.
	 *     @type string               $id              Control ID.
	 *     @type array                $settings        All settings tied to the control. If undefined, `$id` will
	 *                                                 be used.
	 *     @type string               $setting         The primary setting for the control (if there is one).
	 *                                                 Default 'default'.
	 *     @type int                  $priority        Order priority to load the control. Default 10.
	 *     @type string               $section         Section the control belongs to. Default empty.
	 *     @type string               $label           Label for the control. Default empty.
	 *     @type string               $description     Description for the control. Default empty.
	 *     @type array                $choices         List of choices for 'radio' or 'select' type controls, where
	 *                                                 values are the keys, and labels are the values.
	 *                                                 Default empty array.
	 *     @type array                $input_attrs     List of custom input attributes for control output, where
	 *                                                 attribute names are the keys and values are the values. Not
	 *                                                 used for 'checkbox', 'radio', 'select', 'textarea', or
	 *                                                 'dropdown-pages' control types. Default empty array.
	 *     @type array                $json            Deprecated. Use WP_Customize_Control::json() instead.
	 *     @type string               $type            Control type. Core controls include 'text', 'checkbox',
	 *                                                 'textarea', 'radio', 'select', and 'dropdown-pages'. Additional
	 *                                                 input types such as 'email', 'url', 'number', 'hidden', and
	 *                                                 'date' are supported implicitly. Default 'text'.
	 * }
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {

		$this->args = $args;

		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script(
			'jt-customize-controls',
			ITALYSTRAP_PARENT_PATH . '/admin/js/customizer-select-multiple.min.js',
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);
	}

	/**
	 * Render the content of the category dropdown
	 */
	public function render_content() {

		if ( ! isset( $this->args['choices'] ) ) {
			$this->args['choices'] = array();
		}

		if ( ! is_array( $this->args['choices'] ) ) {
			$this->args['choices'] = array();
		}

?>
<label>
	<span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>

	<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

	<select class="widefat" multiple>
		<?php
		foreach ( $this->args['choices'] as $value => $label ) {
			printf( '<option value="%s" %s>%s</option>',
				esc_attr( $value ),
				selected( in_array( $value, $multi_values, true ), true, false ),
				esc_html( $label )
			);
		}
		?>
	</select>

	<?php if ( ! empty( $this->description ) ) : ?>
		<span class="description customize-control-description"><?php echo $this->description; // XSS ok. ?></span>
	<?php endif; ?>
	<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
</label>
<?php
	}
}
