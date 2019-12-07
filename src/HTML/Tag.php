<?php
/**
 * Created by PhpStorm.
 * User: fisso
 * Date: 09/04/2019
 * Time: 13:57
 */

namespace ItalyStrap\HTML;


class Tag implements Tag_Interface {

	public static $is_debug = false;

	/**
	 * Array with tags indexed by $context.
	 *
	 * @var array
	 */
	private $tags = [];

	/**
	 * @var Attributes
	 */
	private $attr;

	/**
	 * Tag constructor.
	 * @param Attributes $attributes
	 */
	public function __construct( Attributes $attributes ) {
		$this->attr = $attributes;
	}

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

		$this->attr->add_attr( $context, $attr );

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
//			get_attr( $context, $attr ),
			$this->attr->render( $context ),
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

	/**
	 * @todo Maybe future development
	 *
	 * @example :
	 * <div>Some content</div>
	 * <i class="fa fa-icon"></i>
	 * Some content
	 *
	 * @param string $context
	 * @param string $tag
	 * @param array $attr
	 * @param string $content
	 * @return string
	 */
	public function element( string $context, string $tag, array $attr, string $content = '' ) : string {

		/**
		 * @todo Può essere utile un fitro qui?
		 */
		$content = (string) \apply_filters( "italystrap_{$context}_element_content", $content, $context, $this );

		/**
		 * It could be used to display the content without the wrapper
		 */
		if ( (bool) \apply_filters( "italystrap_pre_{$context}", false, $context, $this ) ) {
			return $content;
		}

		$output = $this->open( $context, $tag, $attr ) . $content . $this->close( $context );

		return \apply_filters( "italystrap_{$context}_element_output", $output, $context, $this );
	}

	/**
	 * @param string $context
	 * @param string $tag
	 * @return Tag
	 */
	private function set_tag( string $context, string $tag ) : self {

		if ( $this->has_tag( $context ) ) {
			throw new \RuntimeException( sprintf( 'The %s is already used', $context ) );
		}

		$this->tags[ $context ] = (string) \apply_filters( "italystrap_{$context}_tag", $tag, $context, $this );
		return $this;
	}

	/**
	 * @param string $context
	 * @return bool
	 */
	private function has_tag( string $context ) : bool {
		return array_key_exists( $context, $this->tags );
	}

	/**
	 * @param string $context
	 * @return string
	 */
	private function get_tag( string $context ) : string {

		if ( ! $this->has_tag( $context ) ) {
			return '';
		}

		return $this->tags[ $context ];
	}

	/**
	 * @param string $context
	 * @return $this
	 */
	private function remove_tag( string $context ) {
		unset( $this->tags[ $context] );
		return $this;
	}

	/**
	 * @param string $context
	 * @param string $new_tag
	 * @return $this
	 */
	private function change_tag( string $context, string $new_tag ) {
		$this->tags[ $context] = $new_tag;
		return $this;
	}

	/**
	 * @todo Maybe make a both for selfclose
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

	/**
	 * @return bool
	 */
	private function is_debug () : bool {
		return self::$is_debug;
	}

	/**
	 * @throws \Exception
	 */
	public function check_non_closed_tags() {
		if ( ! self::$is_debug ) {
			return;
		}

		try {
			if ( \count( $this->tags ) > 0 ) {
				throw new \RuntimeException( \sprintf(
					'You forgot to close this tags: { %s }',
					\join( ' | ', $this->get_missed_close_tags() )
				) );
			}
		} catch ( \RuntimeException $e ) {
			echo $e->getMessage();
//			throw $e;
		} catch ( \Exception $e ) {
			echo $e->getMessage();
//			throw $e;
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

	/**
	 *
	 * @throws \Exception
	 */
	public function __destruct() {
		$this->check_non_closed_tags();
	}

	/**
	 * @TODO Qualche idea da sviluppare in futuro
	 * https://gitlab.com/byjoby/html-object-strings/blob/master/src/TagTrait.php
	 */
//	private function add_attr_if( string $context, bool $condition, array $attr = [] ) {
//		// attribute[ $context ] = $attr;
//	}

	/**
	 * Agginge una o più classi css
	 */
//	private function add_class( string $context, string $classes ) {
//		// attribute[ $context ] = $attr;
//	}

	/**
	 * Agginge una o più classi css
	 */
//	private function add_data( string $context, string $classes ) {
//		// attribute[ $context ] = $attr;
//	}

}