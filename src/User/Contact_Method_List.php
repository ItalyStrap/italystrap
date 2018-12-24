<?php
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
class Contact_Method_List extends Contact_Methods_Base {

	/**
	 * Get author info from database
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function get_author_info() {
		/**
		 * Author object
		 * @var object
		 */
		$this->author_info = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( absint( get_the_author_meta( 'ID' ) ) );
	}

	/**
	 * Get th list
	 *
	 * @param  string $value [description]
	 * @return string        [description]
	 */
	public function get_list() {

		$this->get_author_info();

		$list = '';

		foreach ( $this->new_contact_methods as $key => $value ) {
			if ( ! empty( $this->author_info->$key ) ) {
				$list .= sprintf(
					'<li><a href="%1$s" title="%3$s" rel="me" class="sprite32 %2$s32"><span class="sr-only">%3$s</span></a></li>',
					esc_url( $this->author_info->$key ),
					$key,
					$value
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

		printf(
			'<ul class="list-inline">%s</ul>',
			$this->get_list()
		);
	}
}
