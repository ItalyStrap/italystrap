<?php
declare(strict_types=1);

namespace ItalyStrap\Theme;

use ItalyStrap\ThemeJsonGenerator\Factory\Color as FClr;
use ItalyStrap\ThemeJsonGenerator\Factory\Spacing as FSpace;
use ItalyStrap\ThemeJsonGenerator\Factory\Typography as FTypo;
use ItalyStrap\ThemeJsonGenerator\SectionNames;
use ItalyStrap\ThemeJsonGenerator\Styles\Border;

final class JsonData {

	public static function getJsonData(): array {
		$data = new self();

		$result = $data->buildJsonData();

//		$result = $data->parseDataAndCleanFromEmptyValue( $result );

		if ( \count( $result ) === 0 ) {
			throw new \RuntimeException('The theme.json is empty');
		}

		return $result;
	}

	private function buildJsonData(): array {

		return [
			'$schema' => 'https://schemas.wp.org/trunk/theme.json',
			SectionNames::VERSION => 2,

			/**
			 * ============================================
			 * Styles for FSE and Front-End
			 * ============================================
			 */
			SectionNames::STYLES	=> [

				/**
				 * ============================================
				 * Blocks styles
				 * ============================================
				 */
				'blocks' => [

					/**
					 * ============================================
					 * Blocks elements for images
					 * ============================================
					 */
					'core/site-logo' => [ // wp-block-site-logo {figure element}
						'spacing'	=> [
							'margin'	=> (string) FSpace::shorthand(['0']),
							'padding'	=> (string) FSpace::shorthand(['0']),
						],
					],
					'core/image' => [ // wp-block-image {figure element}
						'spacing'	=> [
							'margin'	=> (string) FSpace::make()
								->top( '1rem' )
								->bottom( '0px' ),
						],
					],
					'core/post-featured-image' => [ // wp-block-post-featured-image {figure element}
//						'spacing'	=> [
//							'margin'	=> (string) FSpace::make()
//								->top( '1rem' )
//								->bottom('0'),
//						],
					],
//					'core/gallery' => [ // wp-block-gallery {figure element}
//					],

					'core/post-title' => [ // .wp-block-post-title
						'color' => FClr::make()
							->text( 'inherit' )
							->toArray(),
//						'border' => (new Border())
//							->style('solid')
//							->width('1px')
//							->color('black')
//							->toArray(),
						'typography' => FTypo::make()
							->fontSize( '35px' )
							->toArray(),
						'elements' => [
							'link' => [ // .wp-block-post-title a
								'color'	=> FClr::make()
									->text( 'inherit' )
									->background( 'transparent' )
									->toArray(),
							],
						],
					],

					'core/post-date' => [
						'typography' => FTypo::make()
//							->fontSize( '0.75rem' )
							->toArray(),
					],
					'core/post-author' => [
						'typography' => FTypo::make()
//							->fontSize( '16px' )
							->toArray(),
					],
					'core/post-terms' => [
						'typography' => FTypo::make()
//							->fontSize( '0.75rem' )
							->toArray(),
					],

					/**
					 * ============================================
					 * Blocks for content
					 * ============================================
					 */
					'core/post-content' => [ // .wp-block-post-content
						'color' => FClr::make()
							->text( 'inherit'  )
							->toArray(),
					],
					'core/post-excerpt' => [ // .wp-block-post-content
						'color' => FClr::make()
							->text( 'inherit'  )
							->toArray(),
					],
					'core/paragraph' => [ // .wp-block-post-content
						'color' => FClr::make()
							->text( 'inherit'  )
							->toArray(),
						'spacing'	=> [
							'margin'	=> (string) FSpace::make()
								->top( '1.2rem' )
								->bottom( '0px' ),
						],
					],

				],
			],
		];
	}
}
