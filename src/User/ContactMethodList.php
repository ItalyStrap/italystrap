<?php
declare(strict_types=1);
/**
 * Contact_Method_List API
 *
 * This class generate the contact method list on frontend.
 *
 * @link www.italystrap.com
 * @since 4.0.0
 *
 * @package ItalyStrap
 */

namespace ItalyStrap\User;

/**
 * Contact_Method_List
 */
class ContactMethodList extends ContactMethodsBase {

	/**
	 * Get th list
	 *
	 * @return string        [description]
	 */
	private function get_list() {

		$this->set_author();

		$list = '';

		$asclude = [
			'avatar',
		];

		foreach ( $this->new_contact_methods as $key => $value ) {
//			if ( array_key_exists( $key, $list ) ) {
//				continue;
//			}

			d($key, $this->author->$key);
			if ( ! empty( $this->author->$key ) ) {
				$list .= sprintf(
					'<li><a href="%1$s" title="%3$s" rel="me" class="sprite32 %2$s32"><span class="sr-only">%3$s</span></a></li>',
					esc_url( $this->author->get( $key ), ( isset( $value['protocol'] ) ? $value['protocol'] : null ) ),
					$value['icon'],
					$value['label']
				);
			}
		}

		return $list;
	}

	/**
	 * Render
	 */
	public function render() {

		$get_list = $this->get_list();

		if ( empty( $get_list ) ) {
			return '';
		}

		return sprintf(
			'<ul class="list-inline">%s</ul>',
			$this->get_list()
		);
	}
}
