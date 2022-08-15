<?php
declare(strict_types=1);

namespace ItalyStrap\Customizer;

use ItalyStrap\Config\ConfigPostThumbnailProvider;

trait ComponentsWidthChoicesTrait {

	private function getAlignmentChoices(): iterable {
		yield 'container-fluid' => \__('Full witdh', 'italystrap');
		yield 'container' => \__('Standard width', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_NONE => \__('Align None', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_FULL => \__('Align Full', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_WIDE => \__('Align Wide', 'italystrap');
	}

	/**
	 * @psalm-return \Generator<string, string, mixed, void>
	 */
	private function getThumbnailAlignementsChoices(): \Generator {
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_NONE => \__('Align None', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_FULL => \__('Align Full', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_WIDE => \__('Align Wide', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_CENTER => \__('Align Center', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_LEFT => \__('Align Left', 'italystrap');
		yield ConfigPostThumbnailProvider::POST_THUMBNAIL_ALIGN_RIGHT => \__('Align Right', 'italystrap');
	}
}
