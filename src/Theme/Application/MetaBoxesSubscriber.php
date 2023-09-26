<?php

declare(strict_types=1);

namespace ItalyStrap\Theme\Application;

use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Event\SubscriberInterface;
use ItalyStrap\Theme\Infrastructure\CMB2Factory;
use ItalyStrap\Theme\Infrastructure\Config\ConfigThemeProvider;
use function ItalyStrap\Bools\experimental_is_block_theme;

/**
 * https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
 */
class MetaBoxesSubscriber implements SubscriberInterface
{
    private ConfigInterface $config;
    private CMB2Factory $factory;

    public function getSubscribedEvents(): iterable
    {
        yield 'cmb2_admin_init' => $this;
    }

    public function __construct(ConfigInterface $config, CMB2Factory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    public function __invoke()
    {

        if (experimental_is_block_theme()) {
            return;
        }

        $prefix = (string)$this->config->get(ConfigThemeProvider::PREFIX);
        $post_id = \array_key_exists('post', $_GET) ? \absint($_GET['post']) : null;
        $post_type = \array_key_exists('post_type', $_GET)
            ? \esc_attr($_GET['post_type'])
            : (string)\get_post_type($post_id);

        $cmb = $this->factory->make([
            'id'            => "$prefix-template-settings-metabox",
            'title'         => \__('Custom settings', 'italystrap'),
            'object_types'  => [
                'page',
                'post',
                'download',
                'product',
                'forum',
                'topic',
                'reply',
            ],
            'context'    => 'side',
            'priority'   => 'low',
        ]);

        $cmb->add_field(
            [
                'name'              => \__('Page container width settings', 'italystrap'),
                'desc'              => \sprintf(
                    \__('Choose the width of the page container for this %s', 'italystrap'),
                    $post_type
                ),
                'id'                => "_{$prefix}_width_settings",
                'type'              => 'radio',
                'show_option_none'  => \sprintf(
                    \__('Default width set in %s', 'italystrap'),
                    $post_type
                ),
                'options'           => \apply_filters('italystrap_theme_width', []),
            ]
        );

        $cmb->add_field(
            [
                'name'              => \__('Layout settings', 'italystrap'),
                'desc'              => \sprintf(
                    \__('Advance layout setting for this %s', 'italystrap'),
                    $post_type
                ),
                'id'                => "_{$prefix}_layout_settings",
                'type'              => 'radio',
                'show_option_none'  => sprintf(
                    \__('Default layout set in %s', 'italystrap'),
                    $post_type
                ),
                'options'           => require \get_template_directory() . '/config/layout.php',
            ]
        );

        $cmb->add_field(
            [
                'name'      => \__('Template settings', 'italystrap'),
                'desc'      => \sprintf(
                    \__('Advance template content setting for this %s', 'italystrap'),
                    $post_type
                ),
                'id'        => "_{$prefix}_template_settings",
                'type'      => 'multicheck',
                'options'   => require \get_template_directory() . '/config/template-content.php',
            ]
        );

        if (\current_theme_supports('custom-header') && \get_theme_mod('header_image_data')) {
            $cmb->add_field(
                [
                    'name'          => \__('Custom header', 'italystrap'),
                    'desc'          => \__('The image for the theme header', 'italystrap'),
                    'id'            => "_{$prefix}_custom_header",
                    'type'          => 'file',
                    'options'       => [
                        'url'   => false, // Hide the text input for the url
                    ],
                    'default'       => null,
                    'text'          => [
                        'add_upload_file_text' => \__('Add or upload image', 'italystrap')
                    ],
                ]
            );
        }

        /**
         * This functionality is not already developed
         */
        if (\current_theme_supports('featured-video')) {
            /**
             * @example https://github.com/WebDevStudios/CMB2/wiki/Field-Types#oembed
             * $url = \esc_url( \get_post_meta( \get_the_ID(), 'wiki_test_embed', 1 ) );
             * echo \wp_oembed_get( $url );
             */
            $cmb->add_field(
                [
                    'name'      => \__('Video URL', 'italystrap'),
					// phpcs:disable
					'desc'		=> \sprintf(
						'Enter a youtube, twitter, or instagram URL. Supports services listed at %s. This will be shown instead of feature image.',
						'<a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>'
					),
					// phpcs:enable
                    'default'   => '',
                    'id'        => "_{$prefix}_featured_video",
                    'type'      => 'text',
                ]
            );
        }
    }
}
