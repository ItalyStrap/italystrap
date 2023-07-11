<?php

declare(strict_types=1);

namespace ItalyStrap\Config;

use ItalyStrap\Event\EventDispatcherInterface;

trait AlignmentChoicesTrait
{
    private EventDispatcherInterface $dispatcher;

    private function alignNone(): iterable
    {
        return [
            AlignmentKeys::ALIGN_NONE => \__('None', 'italystrap')
        ];
    }

    private function getHorizontalStandard(): iterable
    {
        yield from $this->alignNone();
        yield 'container-fluid' => \__('Full witdh (deprecated)', 'italystrap');
        yield 'container' => \__('Standard width (deprecated)', 'italystrap');
        yield AlignmentKeys::ALIGN_FULL => \__('Align Full', 'italystrap');
        yield AlignmentKeys::ALIGN_WIDE => \__('Align Wide', 'italystrap');
    }

    private function getHorizontalThumb(): iterable
    {
        yield from $this->alignNone();
        yield AlignmentKeys::ALIGN_FULL => \__('Align Full', 'italystrap');
        yield AlignmentKeys::ALIGN_WIDE => \__('Align Wide', 'italystrap');
        yield AlignmentKeys::ALIGN_CENTER => \__('Align Center', 'italystrap');
        yield AlignmentKeys::ALIGN_LEFT => \__('Align Left', 'italystrap');
        yield AlignmentKeys::ALIGN_RIGHT => \__('Align Right', 'italystrap');
    }

    private function getHorizontalAll(): iterable
    {
        yield from $this->getHorizontalStandard();
        yield AlignmentKeys::ALIGN_FULL => \__('Align Full', 'italystrap');
        yield AlignmentKeys::ALIGN_WIDE => \__('Align Wide', 'italystrap');
        yield AlignmentKeys::ALIGN_CENTER => \__('Align Center', 'italystrap');
        yield AlignmentKeys::ALIGN_LEFT => \__('Align Left', 'italystrap');
        yield AlignmentKeys::ALIGN_RIGHT => \__('Align Right', 'italystrap');
    }

    private function getAllHorizontalAlignment(): iterable
    {
        return (array)$this->dispatcher->filter(
            'italystrap_horizontal_alignment_choices_trait',
            [
                ...$this->getHorizontalStandard(),
                AlignmentKeys::ALIGN_FULL => \__('Align Full', 'italystrap'),
                AlignmentKeys::ALIGN_WIDE => \__('Align Wide', 'italystrap'),
                AlignmentKeys::ALIGN_CENTER => \__('Align Center', 'italystrap'),
                AlignmentKeys::ALIGN_LEFT => \__('Align Left', 'italystrap'),
                AlignmentKeys::ALIGN_RIGHT => \__('Align Right', 'italystrap'),
            ]
        );
    }
}
