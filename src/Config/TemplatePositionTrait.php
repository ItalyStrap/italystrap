<?php
declare(strict_types=1);

namespace ItalyStrap\Config;

trait TemplatePositionTrait {

	private function getAllPosition(): iterable {
		return (array)$this->dispatcher->filter(
			'italystrap_template_positions_trait',
			[
				'italystrap_before'			=> \__( 'After the <code>&lt;/body&gt;</code>', 'italystrap' ),

				'italystrap_before_header'	=> \__( 'Before the header', 'italystrap' ),
				'italystrap_content_header'	=> \__( 'The content header', 'italystrap' ),
				'italystrap_after_header'	=> \__( 'After the header', 'italystrap' ),

				'italystrap_before_main'	=> \__( 'Before the Main Content', 'italystrap' ),

				'italystrap_before_content'	=> \__( 'Before the Content', 'italystrap' ),

				'italystrap_before_loop'	=> \__( 'Before the Loop', 'italystrap' ),
				'italystrap_loop'			=> \__( 'The Loop', 'italystrap' ),
				'italystrap_after_loop'		=> \__( 'After the Loop', 'italystrap' ),

				'italystrap_after_content'	=> \__( 'After the Content', 'italystrap' ),

				'italystrap_after_main'		=> \__( 'After the Main Content', 'italystrap' ),

				'italystrap_before_footer'	=> \__( 'In the footer open', 'italystrap' ),
				'italystrap_footer'			=> \__( 'In the footer', 'italystrap' ),
				'italystrap_after_footer'	=> \__( 'In the footer closed', 'italystrap' ),

				// phpcs:disable
				'italystrap_after'			=> \__( 'At the end of the page before the <code>&lt;/body&gt;</code>', 'italystrap' ),
				// phpcs:enable
			]
		);
	}
}
