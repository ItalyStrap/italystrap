<?php

declare(strict_types=1);

namespace ItalyStrap\Tests;

use Codeception\Test\Unit;
use ItalyStrap\Asset\Infrastructure\InlineStyleGenerator;
use ItalyStrap\Config\ConfigInterface;
use ItalyStrap\Customizer\FieldControlFactory;
use ItalyStrap\Empress\AurynConfigInterface;
use ItalyStrap\Empress\Injector;
use ItalyStrap\Event\GlobalDispatcherInterface;
use ItalyStrap\Event\ListenerRegisterInterface;
use ItalyStrap\Event\SubscriberRegisterInterface;
use ItalyStrap\Finder\FileInfoFactoryInterface;
use ItalyStrap\Finder\FinderInterface;
use ItalyStrap\HTML\Tag;
use ItalyStrap\Navigation\UI\Components\Navbar;
use ItalyStrap\Theme\Infrastructure\Support as ThemeSupport;
use ItalyStrap\UI\Components\ComponentInterface;
use ItalyStrap\UI\Elements\AuthorInfo;
use ItalyStrap\UI\Infrastructure\ViewBlockInterface;
use ItalyStrap\View\ViewInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Psr\EventDispatcher\EventDispatcherInterface;
use UnitTester;
use WP_Customize_Manager;
use WP_Theme;

class UnitTestCase extends Unit
{
    use DefineUndefineFunctionsTrait;

    protected UnitTester $tester;

    protected Prophet $prophet;

    protected ObjectProphecy $config;

    protected function makeConfig(): ConfigInterface
    {
        return $this->config->reveal();
    }

    protected ObjectProphecy $globalDispatcher;

    protected function makeGlobalDispatcher(): GlobalDispatcherInterface
    {
        return $this->globalDispatcher->reveal();
    }

    protected ObjectProphecy $dispatcher;

    protected function makeDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher->reveal();
    }

    protected ObjectProphecy $subscriberRegister;

    protected function makeSubscriberRegister(): SubscriberRegisterInterface
    {
        return $this->subscriberRegister->reveal();
    }

    protected ObjectProphecy $view;

    protected function makeView(): ViewInterface
    {
        return $this->view->reveal();
    }

    protected ObjectProphecy $viewBlock;

    protected function makeViewBlock(): ViewBlockInterface
    {
        return $this->viewBlock->reveal();
    }

    protected ObjectProphecy $injector;

    protected function makeInjector(): Injector
    {
        return $this->injector->reveal();
    }

    protected ObjectProphecy $aurynConfigInterface;

    protected function makeAurynConfigInterface(): AurynConfigInterface
    {
        return $this->aurynConfigInterface->reveal();
    }

    protected ObjectProphecy $finder;

    protected function makeFinder(): FinderInterface
    {
        return $this->finder->reveal();
    }

    protected ObjectProphecy $theme_support;

    protected function makeThemeSupport(): ThemeSupport
    {
        return $this->theme_support->reveal();
    }

    protected ObjectProphecy $component;

    protected function makeComponent(): ComponentInterface
    {
        return $this->component->reveal();
    }

    protected ObjectProphecy $navbar;

    protected function makeNavbar(): Navbar
    {
        return $this->navbar->reveal();
    }

    protected ObjectProphecy $tag;

    protected function makeTag(): Tag
    {
        return $this->tag->reveal();
    }

    protected ObjectProphecy $fileInfoFactory;

    protected function makeFileInfoFactory(): FileInfoFactoryInterface
    {
        return $this->fileInfoFactory->reveal();
    }

    protected ObjectProphecy $inlineStyleGenerator;

    protected function makeInlineStyleGenerator(): InlineStyleGenerator
    {
        return $this->inlineStyleGenerator->reveal();
    }

    protected ObjectProphecy $theme;

    protected function makeTheme(): WP_Theme
    {
        return $this->theme->reveal();
    }

    protected ObjectProphecy $manager;

    protected function makeWPCustomizeManager(): WP_Customize_Manager
    {
        return $this->manager->reveal();
    }

    protected ObjectProphecy $control;

    protected function makeFieldControlFactory(): FieldControlFactory
    {
        return $this->control->reveal();
    }

    protected ObjectProphecy $author;

    protected function makeAuthorInfo(): AuthorInfo
    {
        return $this->author->reveal();
    }

    protected ObjectProphecy $listenerRegister;

    protected function makeListenerRegister(): ListenerRegisterInterface
    {
        return $this->listenerRegister->reveal();
    }

    // phpcs:ignore
    protected function _before()
    {
        $this->setUpProphet();
    }

    // phpcs:ignore
    protected function _after()
    {
        $this->tearDownProphet();
        $this->undefineAllFunction(
            [
            ]
        );
    }

    private function setUpProphet()
    {
        $this->prophet = new Prophet();
        $this->config = $this->prophet->prophesize(ConfigInterface::class);
        $this->view = $this->prophet->prophesize(ViewInterface::class);
        $this->viewBlock = $this->prophet->prophesize(ViewBlockInterface::class);
        $this->globalDispatcher = $this->prophet->prophesize(GlobalDispatcherInterface::class);
        $this->dispatcher = $this->prophet->prophesize(EventDispatcherInterface::class);
        $this->subscriberRegister = $this->prophet->prophesize(SubscriberRegisterInterface::class);
        $this->injector = $this->prophet->prophesize(Injector::class);
        $this->aurynConfigInterface = $this->prophet->prophesize(AurynConfigInterface::class);
        $this->finder = $this->prophet->prophesize(FinderInterface::class);
        $this->theme_support = $this->prophet->prophesize(ThemeSupport::class);
        $this->component = $this->prophet->prophesize(ComponentInterface::class);
        $this->navbar = $this->prophet->prophesize(Navbar::class);
        $this->tag = $this->prophet->prophesize(Tag::class);
        $this->fileInfoFactory = $this->prophet->prophesize(FileInfoFactoryInterface::class);
        $this->inlineStyleGenerator = $this->prophet->prophesize(InlineStyleGenerator::class);
        $this->theme = $this->prophet->prophesize(WP_Theme::class);
        $this->manager = $this->prophet->prophesize(WP_Customize_Manager::class);
        $this->control = $this->prophet->prophesize(FieldControlFactory::class);
        $this->author = $this->prophet->prophesize(AuthorInfo::class);
        $this->listenerRegister = $this->prophet->prophesize(ListenerRegisterInterface::class);
//      \Brain\Monkey\setUp();
    }

    private function tearDownProphet()
    {
//      \Brain\Monkey\tearDown();
        $this->prophet->checkPredictions();
    }
}
