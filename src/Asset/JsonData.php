<?php

declare(strict_types=1);

namespace ItalyStrap\Asset;

use ItalyStrap\Config\ConfigFactory;
use ItalyStrap\ThemeJsonGenerator\Factory\Color as FClr;
use ItalyStrap\ThemeJsonGenerator\Factory\Spacing as FSpace;
use ItalyStrap\ThemeJsonGenerator\Factory\Typography as FTypo;
use ItalyStrap\ThemeJsonGenerator\SectionNames;
use ItalyStrap\ThemeJsonGenerator\Settings\CustomCollection as Custom;
use ItalyStrap\ThemeJsonGenerator\Settings\PresetCollection as Preset;
use ItalyStrap\ThemeJsonGenerator\Styles\Border;

final class JsonData
{
    public static function getJsonData(): array
    {
        $data = new self();

        $config = ConfigFactory::make();

        $result = $data->buildJsonData();

//      $result = $data->parseDataAndCleanFromEmptyValue( $result );

        if (\count($result) === 0) {
            throw new \RuntimeException('The theme.json is empty');
        }

        return $result;
    }

    private function buildJsonData(): array
    {

        $font_family = new Preset(
            [
                [
					// phpcs:ignore
					'fontFamily' => 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                    'slug' => "base",
                    "name" => "Default font family",
                ],
                [
					// phpcs:ignore
					'fontFamily' => 'SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
                    'slug' => "monospace",
                    "name" => "Font family for code",
                ],
            ],
            'fontFamily'
        );

        $custom = new Custom(
            [
                'contentSize'   => 'clamp(16rem, 60vw, 60rem)',
                'wideSize'      => 'clamp(16rem, 85vw, 70rem)',
                'baseFontSize'  => "1rem",
                'spacer'        => [
                    'base'  => '1rem',
                    'v'     => 'calc( {{spacer.base}} * 4 )',
                    'h'     => 'calc( {{spacer.base}} * 4 )',
                    's'     => 'calc( {{spacer.base}} / 1.5 )',
                    'm'     => 'calc( {{spacer.base}} * 2 )',
                    'l'     => 'calc( {{spacer.base}} * 3 )',
                    'xl'    => 'calc( {{spacer.base}} * 4 )',
                ],
                'lineHeight'    => [
                    'base' => 1.5,
                    'xs' => 1.1,
                    's' => 1.3,
                    'm' => '{{lineHeight.base}}',
                    'l' => 1.7
                ],
                'body'      => [
                    'bg'    => '{{color.base}}',
                    'text'  => '{{color.bodyBg}}',
                ],
                'link'      => [
                    'bg'            => '{{color.base}}',
                    'text'          => '{{color.bodyBg}}',
                    'decoration'    => 'underline',
                    'hover' => [
                        'text'          => '{{color.bodyColor}}',
                        'decoration'    => 'underline',
                    ],
                ],
                'button'        => [
                    'bg'    => '{{color.base}}',
            //                  'text'  => $button_text_hover->toHex(),
                    'borderColor'   => 'transparent',
                    'borderRadius'  => 'calc( {{fontSize.base}} /4)',
                    'hover' => [
            //                      'bg'    => $button_bg_hover->toHex(),
            //                      'text'  => $button_text_hover->toHex(),
                        'borderColor'   => 'transparent',
                    ],
                    'padding'   => ' 0.25em 0.7em',
                ],
                'form'  => [
                    'border'    => [
                        'color' => '',
                        'width' => '',
                    ],
                    'input' => [
                        'color' => '',
                    ],
                ],
                'navbar'    => [
                    'min'       => [
                        'height'    => 'calc( {{spacer.base}} * 5.3125 )',
                    ],
                ],
                'query'     => [
                    'post'  => [
                        'title' => '{{fontSize.h1}}',
                    ],
                ],
                //              'site-blocks'   => [
                //                      'margin'    => [
                //                          'top'   => '',
                //                  ],
                //              ],
            ]
        );

        return [
            '$schema' => 'https://schemas.wp.org/trunk/theme.json',
            SectionNames::VERSION => 2,

            SectionNames::SETTINGS  => [
                'layout' => [
                    'contentSize' => 'clamp(16rem, 60vw, 60rem)',
                    'wideSize' => 'clamp(16rem, 85vw, 70rem)',
                ],
            ],

            /**
             * ============================================
             * Styles for FSE and Front-End
             * ============================================
             */
            SectionNames::STYLES    => [

                'typography' => FTypo::make()
                    ->fontFamily($font_family->varOf('base'))
//                  ->fontSize( $font_sizes->varOf( 'base' ) )
                    ->fontSize('18px')
                    ->fontStyle('normal')
                    ->fontWeight('300')
                    ->letterSpacing('normal')
                    ->lineHeight($custom->varOf('lineHeight.m'))
                    ->textDecoration('none')
                    ->textTransform('none')
                    ->toArray(),

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
                        'spacing'   => [
                            'margin'    => (string) FSpace::shorthand(['0']),
                            'padding'   => (string) FSpace::shorthand(['0']),
                        ],
                    ],
                    'core/image' => [ // wp-block-image {figure element}
                        'spacing'   => [
                            'margin'    => (string) FSpace::make()
                                ->top('1rem')
                                ->bottom('0px'),
                        ],
                    ],
                    'core/post-featured-image' => [ // wp-block-post-featured-image {figure element}
//                      'spacing'   => [
//                          'margin'    => (string) FSpace::make()
//                              ->top( '1rem' )
//                              ->bottom('0'),
//                      ],
                    ],
//                  'core/gallery' => [ // wp-block-gallery {figure element}
//                  ],

                    'core/post-title' => [ // .wp-block-post-title
                        'color' => FClr::make()
                            ->text('inherit')
                            ->toArray(),
//                      'border' => (new Border())
//                          ->style('solid')
//                          ->width('1px')
//                          ->color('black')
//                          ->toArray(),
                        'typography' => FTypo::make()
                            ->fontSize('35px')
                            ->toArray(),
                        'elements' => [
                            'link' => [ // .wp-block-post-title a
                                'color' => FClr::make()
                                    ->text('inherit')
                                    ->background('transparent')
                                    ->toArray(),
                            ],
                        ],
                    ],

                    'core/post-date' => [
                        'typography' => FTypo::make()
//                          ->fontSize( '0.75rem' )
                            ->toArray(),
                    ],
                    'core/post-author' => [
                        'typography' => FTypo::make()
//                          ->fontSize( '16px' )
                            ->toArray(),
                    ],
                    'core/post-terms' => [
                        'typography' => FTypo::make()
//                          ->fontSize( '0.75rem' )
                            ->toArray(),
                    ],

                    /**
                     * ============================================
                     * Blocks for content
                     * ============================================
                     */
                    'core/post-content' => [ // .wp-block-post-content
                        'color' => FClr::make()
                            ->text('inherit')
                            ->toArray(),
                    ],
                    'core/post-excerpt' => [ // .wp-block-post-content
                        'color' => FClr::make()
                            ->text('inherit')
                            ->toArray(),
                    ],
                    'core/paragraph' => [ // .wp-block-post-content
                        'color' => FClr::make()
                            ->text('inherit')
                            ->toArray(),
                        'spacing'   => [
                            'margin'    => (string) FSpace::make()
                                ->top('1.2rem')
                                ->bottom('0px'),
                        ],
                    ],

                ],
            ],
        ];
    }
}
