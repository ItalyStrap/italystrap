<?php
/**
 * The template part for header.php
 * This file is for display the HTML tags header and nav
 */

declare(strict_types=1);

namespace ItalyStrap\Headers;

use ItalyStrap\Components\Headers\CustomHeader;
use ItalyStrap\Config\ConfigInterface;
use function ItalyStrap\HTML\close_tag_e;
use function ItalyStrap\HTML\open_tag_e;

/** @var $this ConfigInterface */

open_tag_e( 'custom-header', 'header', ['class'=> 'header-wrapper'] );

	\do_action( 'header_open' );

		open_tag_e( 'custom-header-container', 'div', [
				'class' => $this->get('custom_header.container_width'),
		] );

			open_tag_e( 'custom-header-row', 'div', ['class' => 'row'] );

				open_tag_e( 'custom-header-col', 'div', ['class' => 'col-md-12'] );

					open_tag_e( 'custom-header-anchor', 'a', [
							'href' => \get_home_url( null, '/' ),
							'rel' => 'home',
					] );

						echo $this->get( CustomHeader::OUTPUT );
//the_custom_header_markup();

					close_tag_e( 'custom-header-anchor' );

					close_tag_e( 'custom-header-col' );

					close_tag_e( 'custom-header-row' );

					close_tag_e( 'custom-header-container' );

					\do_action( 'header_closed' );

					close_tag_e( 'custom-header' );
