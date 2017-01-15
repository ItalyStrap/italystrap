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
class Contact_Methods extends Contact_Methods_Base {

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
