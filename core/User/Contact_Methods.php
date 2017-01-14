<?php
/**
 * User Contact Method API
 *
 * Add new user contact method in the user dashboard.
 *
 * @link http://yoast.com/user-contact-fields-wordpress/
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package Italystrap
 */
namespace ItalyStrap\Core\User;

/**
 * Contact Method Class
 */
class Contact_Methods {

	/**
	 * New contact methods to add.
	 *
	 * @var array
	 */
	private $new_contact_methods = array();

	/**
	 * Contact methods to remove.
	 *
	 * @var array
	 */
	private $contact_methods_to_remove = array();

	/**
	 * Init the Class
	 */
	function __construct() {

		$this->new_contact_methods = array(
			'avatar'			=> __( 'Url avatar', 'italystrap' ),
			'skype'				=> __( 'Skype', 'italystrap' ),
			'twitter'			=> __( 'Twitter', 'italystrap' ),
			'google_profile'	=> __( 'Google Profile URL', 'italystrap' ),
			'google_page'		=> __( 'Google Page URL', 'italystrap' ),
			'fb_profile'		=> __( 'Facebook Profile URL', 'italystrap' ),
			'fb_page'			=> __( 'Facebook Page URL', 'italystrap' ),
			'linkedIn'			=> __( 'LinkedIn', 'italystrap' ),
			'pinterest'			=> __( 'Pinterest', 'italystrap' ),
		);

		$this->contact_methods_to_remove = array(
			'yim',
			'jabber',
			'aim',
		);
	}

	/**
	 * Add user contact method
	 *
	 * @param  array $contactmethods The array with user contact methods.
	 * @return array                 Return the new array.
	 */
	public function add_contact_methods( array &$contactmethods ) {

		foreach ( $this->new_contact_methods as $key => $value ) {
			if ( ! isset( $contactmethods[ $key ] ) ) {
				$contactmethods[ $key ] = $value;
			}
		}

		return $contactmethods;	
	}

	/**
	 * Remove user contact method
	 *
	 * @param  array $contactmethods The array with user contact methods.
	 * @return array                 Return the new array.
	 */
	public function remove_contact_methods( array &$contactmethods ) {

		foreach ( $this->contact_methods_to_remove as $key => $value ) {
			if ( isset( $contactmethods[ $key ] ) ) {
				unset( $contactmethods[ $key ] );
			}
		}

		return $contactmethods;	
	}

	/**
	 * Run
	 *
	 * @param  array $contactmethods The array with user contact methods.
	 * @return array                 Return the new array.
	 */
	public function run( array $contactmethods ) {

		$this->add_contact_methods( $contactmethods );
		$this->remove_contact_methods( $contactmethods );

		return $contactmethods;	
	}
}
