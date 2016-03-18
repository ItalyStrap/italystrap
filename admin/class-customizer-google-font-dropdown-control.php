<?php
/**
 * This is the class for loading google font
 *
 * @package ItalyStrap
 * @since 4.0.0
 */

namespace ItalyStrap\Admin;

use WP_Customize_Control;

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * A class to create a dropdown for all google fonts
 */
class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {

	/**
	 * Fonts container
	 *
	 * @var string
	 */
	private $fonts;

	/**
	 * Init the constructor
	 *
	 * @param object $manager [description]
	 * @param [type] $id      [description]
	 * @param array  $args    [description]
	 * @param array  $options [description]
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->fonts = $this->get_fonts();
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the content of the category dropdown
	 */
	public function render_content() {

		if ( ! empty( $this->fonts ) ) {
			?>
                <label>
                    <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php
						foreach ( $this->fonts as $k => $v ) {
							printf( '<option value="%s" %s>%s</option>', $k, selected( $this->value(), $k, false ), $v->family );
						}
						?>
                    </select>
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

		$select_directory = STYLESHEETPATH . '/admin/';

		$final_select_directory = '';

		if ( is_dir( $select_directory ) ) {
			$final_select_directory = $select_directory;
		}

		$font_file = $final_select_directory . '/cache/google-web-fonts.txt';

		if ( file_exists( $font_file ) && WEEK_IN_SECONDS < filemtime( $font_file ) ) {
			$content = json_decode( file_get_contents( $font_file ) );
		} else {

			$google_api = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyAukcQy3eDah9zhEKEwdBKnMbB1egGVpuM';

			$font_content = wp_remote_get( $google_api, array( 'sslverify' => false ) );

			$fp = fopen( $font_file, 'w' );
			fwrite( $fp, $font_content['body'] );
			fclose( $fp );

			$content = json_decode( $font_content['body'] );
		}

		if ( 'all' === $amount ) {
			return $content->items;
		} else {
			return array_slice( $content->items, 0, $amount );
		}
	}
}
