<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 09/04/2019
 * Time: 13:57
 */

namespace ItalyStrap\HTML;


class Tag {

	public static $is_debug = false;

	private $tags = [];

	/**
	 * @param string $context
	 * @param string $tag
	 * @param array $attr
	 * @param bool $is_void
	 * @return string
	 */
	public function open( string $context, string $tag, array $attr = [], $is_void = false ) : string {

		try {
			$this->set_tag( $context, $tag );
		} catch ( \RuntimeException $e ) {
			echo $e->getMessage();
		} catch ( \Exception $e ) {
			echo $e->getMessage();
		}

		if ( ! $tag = $this->get_tag( $context ) ) {
			return '';
		}

		$self_close = '';

		if ( $is_void ) {
			$self_close = '/';
		}

		$output = \sprintf(
			'<%s%s%s>',
			esc_attr( $tag ),
			get_attr( $context, $attr ),
			$self_close
		);

		if ( $this->is_debug() ) {
			return $this->add_comment_in_debug_mode( __FUNCTION__, $context, $output );
		}

		return $output;
	}

	/**
	 * @param string $context
	 * @return string
	 */
	public function close( string $context ) : string {

		if ( ! $tag = $this->get_tag( $context ) ) {
			$this->remove_tag( $context );
			return '';
		}

		$output = \sprintf(
			'</%s>',
			esc_attr( $tag )
		);

		if ( $this->is_debug() ) {
			$output = $this->add_comment_in_debug_mode( __FUNCTION__, $context, $output, 'post' );
		}

		$this->remove_tag( $context );
		return $output;
	}

	/**
	 * @param string $context
	 * @param string $tag
	 * @param array $attr
	 * @return string
	 */
	public function void( string $context, string $tag, array $attr = [] ) : string {
		$output = $this->open( $context, $tag, $attr, true );
		$this->remove_tag( $context );
		return $output;
	}

	private function create_element( string $context, string $tag, array $attr, string $content ) : string {

		$content = (string) \apply_filters( 'italystrap_' . $context . '_element', $content );

		if ( empty( $content ) ) {
			$content = '&nbsp;';
		}

		if ( (bool) \apply_filters( 'italystrap_pre_' . $context, false ) ) {
			return $content;
		}

		$output = $this->open( $context, $tag, $attr ) . $context . $this->close( $context );

		return apply_filters( 'italystrap_' . $context, $output );
	}

	private function set_tag( string $context, string $tag ) : self {

		if ( $this->has_tag( $context ) ) {
			throw new \RuntimeException( sprintf( 'The %s is already used', $context ) );
		}

		$this->tags[ $context ] = (string) \apply_filters( "italystrap_{$context}_tag", $tag );
		return $this;
	}

	private function has_tag( string $context ) : bool {
		return array_key_exists( $context, $this->tags );
	}

	private function get_tag( string $context ) : string {

		if ( ! $this->has_tag( $context ) ) {
			return '';
		}

		return $this->tags[ $context ];
	}

	private function remove_tag( string $context ) {
		unset( $this->tags[ $context] );
		return $this;
	}

	private function change_tag( string $context, string $new_tag ) {
		$this->tags[ $context] = $new_tag;
		return $this;
	}

	/**
	 * @todo Make a both for selfclose
	 *
	 * @param string $func_name
	 * @param string $context
	 * @param string $html
	 * @param string $preOrPost
	 * @return string
	 */
	private function add_comment_in_debug_mode( string $func_name, string $context, string $html, string $preOrPost = 'pre' ) : string {

		$format = [
			'pre'	=> '<!-- %1$s in context: %2$s -->%3$s',
			'post'	=> '%3$s<!-- %1$s in context: %2$s -->',
			'both'	=> '<!-- %1$s in context: %2$s -->%3$s<!-- Self Close in context: %2$s -->',
		];

		return \sprintf(
			$format[ $preOrPost ],
			$func_name,
			esc_attr( $context ),
			$html
		);
	}

	private function is_debug () : bool {
		return self::$is_debug;
	}

	/**
	 *
	 */
	public function __destruct() {

		if ( ! self::$is_debug ) {
			return;
		}

		try {
			if ( count( $this->tags ) > 0 ) {
				throw new \RuntimeException( sprintf(
					'You missed to close this tags: { %s }',
					\join( ' | ', $this->get_missed_close_tags() )
				) );
			}
		} catch ( \RuntimeException $e ) {
			echo $e->getMessage();
		} catch ( \Exception $e ) {
			echo $e->getMessage();
		}
	}

	/**
	 * @return array
	 */
	private function get_missed_close_tags() : array {
		$output = [];
		foreach ( $this->tags as $context => $tag ) {
			$output[] = sprintf(
				'Context "%s": Tag "%s"',
				$context,
				$tag
			);
		}
		return $output;
	}
}