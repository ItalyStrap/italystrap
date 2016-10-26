<?php
/**
 * Class API for Update some stuff from older version
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\Admin\Upgrade;

/**
 * Class description
 */
class Update {

	/**
	 * [$var description]
	 *
	 * @var array
	 */
	private $theme_mods = array();

	/**
	 * [__construct description]
	 *
	 * @param [type] $argument [description].
	 */
	function __construct( array $theme_mods = array() ) {
		$this->theme_mods = $theme_mods;
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function update_display_navbar_brand() {
// var_dump( $this->theme_mods['display_navbar_brand'] );
// var_dump( $this->theme_mods['display_navbar_logo_image'] );
// var_dump( $this->theme_mods['display_navbar_brand-test'] );
// var_dump( $this->theme_mods['display_navbar_brand-test[test1]'] );
// set_theme_mod( $name, $value );
// remove_theme_mod( 'display_navbar_brand-test' );
		
		if ( ! empty( $this->theme_mods['display_navbar_logo_image'] ) ) {

			set_theme_mod( 'display_navbar_brand', 'display_image' );
			remove_theme_mod( 'display_navbar_logo_image' );
			return;
		} elseif ( ! empty( $this->theme_mods['display_navbar_brand'] ) && '1' === $this->theme_mods['display_navbar_brand'] ) {

			set_theme_mod( 'display_navbar_brand', 'display_name' );
			return;
		}
	}

	/**
	 * Function description
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function register() {

		$this->update_display_navbar_brand();
	}
}
