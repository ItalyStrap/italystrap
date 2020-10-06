<?php
declare(strict_types=1);

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
 * @package ItalyStrap
 */
namespace ItalyStrap\User;

use ItalyStrap\Event\SubscriberInterface;

/**
 * Contact Method Class
 */
class ContactMethods extends ContactMethodsBase implements SubscriberInterface {

	/**
	 * Returns an array of hooks that this subscriber wants to register with
	 * the WordPress plugin API.
	 *
	 * @hooked user_contactmethods - 10
	 *
	 * @return array
	 */
	public function getSubscribedEvents(): array {

		return array(
			// 'hook_name'							=> 'method_name',
			'user_contactmethods'	=> 'run',
//			'get_avatar_url'	=> array(
//				'function_to_add'	=> 'avatar_url',
//				'accepted_args'     => 2,
//			),
			'kses_allowed_protocols'	=> 'allowedProtocols',
		);
	}


	public function avatarUrl( $url, $id_or_email ) {

		d($this->getAuthor()->avatar);

		d($url, $id_or_email);
		return $url;
	}


	public function allowedProtocols( $protocols) {
		$protocols[] = 'skype';
		return $protocols;
	}

	/**
	 * Add user contact method
	 *
	 * @param  array $contactmethods The array with user contact methods.
	 * @return array                 Return the new array.
	 */
	public function addContactMethods( array &$contactmethods ) {

		foreach ( $this->new_contact_methods as $key => $value ) {
			if ( ! array_key_exists( $key, $contactmethods ) ) {
				$contactmethods[ $key ] = $value['label'];
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
	public function removeContactMethods( array &$contactmethods ) {

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

		$this->addContactMethods( $contactmethods );
		$this->removeContactMethods( $contactmethods );

		return $contactmethods;
	}
}
