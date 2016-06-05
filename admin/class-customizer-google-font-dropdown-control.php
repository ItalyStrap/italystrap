<?php
/**
 * This is the class for loading google font
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
class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {


    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'checkbox-multiple';

	/**
	 * Fonts container
	 *
	 * @var string
	 */
	private $fonts;

	/**
	 * Init the constructor
	 *
	 * @param WP_Customize_Manager $manager [description]
	 * @param [type] $id      [description]
	 * @param array  $args    [description]
	 * @param array  $options [description]
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {

		$this->fonts = $this->get_fonts();

		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the content of the category dropdown
	 */
	public function render_content() {

		if ( ! empty( $this->fonts ) ) {
			// d( $this->fonts );
			// d( $this->value() );
			// d( get_theme_mods() );
			?>
				<label>
					<span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>

					<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

					<select class="widefat" <?php $this->link(); ?>>
						<?php
						foreach ( $this->fonts as $k => $v ) {
							printf(
								'<option value="%s" %s>%s</option>',
								$k,
								selected( $this->value(), $k, false ),
								$v->family
							);
						}
						?>
					</select>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span class="description customize-control-description"><?php echo $this->description; ?></span>
					<?php endif; ?>
				</label>
			<?php
		}
	}

	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @param  integer $amount
	 *
	 * @return String
	 */
	public function get_fonts( $amount = 30 ) {

		// delete_transient( 'italystrap_google_fonts' );

		if ( false === ( $fonts = get_transient( 'italystrap_google_fonts' ) ) ) {

			$font_content = wp_remote_get( $this->google_api, array( 'sslverify' => false ) );

			$fonts = wp_remote_retrieve_body( $font_content );

			$fonts = json_decode( $fonts );

			set_transient( 'italystrap_google_fonts', $fonts, MONTH_IN_SECONDS );

		}

		return $fonts->items;

		// $select_directory = STYLESHEETPATH . '/admin/';

		// $final_select_directory = '';

		// if ( is_dir( $select_directory ) ) {
		// 	$final_select_directory = $select_directory;
		// }

		// $font_file = $final_select_directory . '/cache/google-web-fonts.txt';

		// if ( file_exists( $font_file ) && WEEK_IN_SECONDS < filemtime( $font_file ) ) {
		// 	$content = json_decode( file_get_contents( $font_file ) );
		// } else {

		// 	$google_api = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyAukcQy3eDah9zhEKEwdBKnMbB1egGVpuM';

		// 	$font_content = wp_remote_get( $google_api, array( 'sslverify' => false ) );

		// 	$fp = fopen( $font_file, 'w' );
		// 	fwrite( $fp, $font_content['body'] );
		// 	fclose( $fp );

		// 	$content = json_decode( $font_content['body'] );
		// }

		// // d( $content );

		// if ( 'all' === $amount ) {
		// 	return $content->items;
		// } else {
		// 	return array_slice( $content->items, 0, $amount );
		// }
	}
}
