<?php
declare(strict_types=1);

namespace ItalyStrap\Components\Navigations;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\HTML;

class Pager {

	/**
	 * Theme config.
	 *
	 * @var array
	 */
	private $config;

	/**
	 * Pagination constructor.
	 *
	 * @param ConfigInterface $config
	 * @param \WP_Query|null $query
	 */
	public function __construct( ConfigInterface $config ) {
		$this->config = $config;
	}

	/**
	 * Get paginate link
	 *
	 * @return array        Return the paginate link
	 */
	private function get_paginate_link() {

		/**
		 * Arguments for previous_post_link() and next_post_link()
		 *
		 * @var array
		 */
		$args = array(
			'previous_format'	=> '<li class="previous pager-prev"> %link',
			'previous_link'		=> '<i class="glyphicon glyphicon-arrow-left">&nbsp;</i> %title</li>',
			'next_format'		=> '<li class="next pager-next"> %link',
			'next_link'			=> '%title <i class="glyphicon glyphicon-arrow-right">&nbsp;</i></li>',
		);

		$args = apply_filters( 'italystrap_previous_next_post_link_args', $args );

		$post_links = [
			get_previous_post_link( $args['previous_format'], $args['previous_link'] ),
			get_next_post_link( $args['next_format'], $args['next_link'] ),
		];

		return (array) $post_links;
	}

	/**
	 * Render the output of the controller.
	 *
	 */
	public function render() {

		/**
		 * Arguments for previous_post_link() and next_post_link()
		 *
		 * @var array
		 */
		$args = array(
			'previous_format'	=> '<li class="previous pager-prev"> %link',
			'previous_link'		=> '<i class="glyphicon glyphicon-arrow-left">&nbsp;</i> %title</li>',
			'next_format'		=> '<li class="next pager-next"> %link',
			'next_link'			=> '%title <i class="glyphicon glyphicon-arrow-right">&nbsp;</i></li>',
		);

		$args = apply_filters( 'italystrap_previous_next_post_link_args', $args );

		ob_start();

		?>
		<nav aria-label="<?php _e( 'In post navigation', 'italystrap' ); ?>">
			<ul class="pager">
				<?php previous_post_link( $args['previous_format'], $args['previous_link'] );
				next_post_link( $args['next_format'], $args['next_link'] ); ?>
			</ul>
		</nav>
		<span class="clearfix">&nbsp;</span>
		<?php

		return ob_get_clean();
	}
}
