<?php
/**
 * Contact_Methods_Base API
 *
 * Abstract class for the User Contact Methods
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\User;

/**
 * Contact_Methods_Base Class
 */
abstract class Contact_Methods_Base {

	/**
	 * New contact methods to add.
	 *
	 * @var array
	 */
	protected $new_contact_methods = [];

	/**
	 * Contact methods to remove.
	 *
	 * @var array
	 */
	protected $contact_methods_to_remove = [];

	protected $author = null;

	/**
	 * Init the Class
	 */
	function __construct() {

		$this->new_contact_methods = [
			'avatar'			=> [
				'label'	=> __( 'Custom Url avatar', 'italystrap' ),
				'icon'	=> '',
			],
			'skype'				=> [
				'label'	=> __( 'Skype', 'italystrap' ),
				'icon'	=> 'skype',
				'protocol'	=> ['skype'],
			],
			'twitter'			=> [
				'label'	=> __( 'Twitter', 'italystrap' ),
				'icon'	=> 'twitter',
			],
			'fb_profile'		=> [
				'label'	=> __( 'Facebook Profile URL', 'italystrap' ),
				'icon'	=> 'facebook',
			],
			'fb_page'			=> [
				'label'	=> __( 'Facebook Page URL', 'italystrap' ),
				'icon'	=> 'facebook',
			],
			'linkedIn'			=> [
				'label'	=> __( 'LinkedIn', 'italystrap' ),
				'icon'	=> 'linkedin',
			],
			'pinterest'			=> [
				'label'	=> __( 'Pinterest', 'italystrap' ),
				'icon'	=> 'pinterest',
			],
		];

		$this->contact_methods_to_remove = [
			'yim',
			'jabber',
			'aim',
		];

		$this->set_author();
	}

	/**
	 * Set author info from database
	 */
	public function set_author() {

		global $author_name;

		/**
		 * Author object
		 * @var \WP_User
		 */
		$this->author = array_key_exists( 'author_name', $_GET )
			? get_user_by( 'slug', $author_name )
			: get_userdata( absint( get_the_author_meta( 'ID' ) ) );
	}

	/**
	 * @return \WP_User
	 */
	public function get_author() {

		if ( ! $this->author ) {
			$this->set_author();
		}

		return $this->author;
	}
}
