<?php
/**
 * Contact_Methods_Base API
 *
 * Abstract class for the User Contact Methods
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package Italystrap
 */

namespace ItalyStrap\Core\User;

/**
 * Contact_Methods_Base Class
 */
abstract class Contact_Methods_Base {

	/**
	 * New contact methods to add.
	 *
	 * @var array
	 */
	protected $new_contact_methods = array();

	/**
	 * Contact methods to remove.
	 *
	 * @var array
	 */
	protected $contact_methods_to_remove = array();

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
}
